<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Log;
use App\Models\PersonnelResponder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersonnelRespondersController extends Controller
{

    public function index(Request $request, $status = 'All')
    {

        $total = 0;
        $sessionUser = auth()->user()->user_type;
        if ($sessionUser !== 'admin') {
            $responders = User::where('user_type', 'responders')
                ->where('agency_id', auth()->user()->agency_id)
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('firstname', 'like', '%' . $request->search . '%')
                            ->orWhere('lastname', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('position', 'like', '%' . $request->search . '%')
                            ->orWhere('contact_number', 'like', '%' . $request->search . '%');
                    });
                })
                ->paginate(10);
            return view('PAGES/BFP_BDRRMC/manage-personnel-responders', compact('responders'));
        } else {
            $agencies = Agency::all();

            $responders = User::withTrashed()
                ->whereNot('user_type', 'admin')
                ->when($request->agency, function ($query) use ($request) {
                    $query->where('agency_id', $request->agency);
                })
                ->when($status === 'Archived', function ($query) {
                    $query->onlyTrashed();
                    $total = $query->count();
                })
                ->when(in_array($status, ['Pending', 'Approved', 'Declined']), function ($query) use ($status) {
                    $query->where('account_status', ucfirst($status));
                    $total = $query->count();
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('firstname', 'like', '%' . $request->search . '%')
                            ->orWhere('lastname', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('position', 'like', '%' . $request->search . '%')
                            ->orWhere('contact_number', 'like', '%' . $request->search . '%');
                    });
                })
                ->paginate(10);

            return view('PAGES/admin/personnel-responders', compact('responders', 'agencies', 'status'));
        }
    }


    public function register()
    {
        $agency = Auth::user()->agency;

        return view('PAGES/BFP_BDRRMC/add-personnel-responders', compact('agency'));
    }

    public function addResponders(Request $request)
    {
        // Validate form input
        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'user_type' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'contact_number' => 'required|string|max:255',
            'account_status' => 'required|in:Pending,Deactive,Activate',
            'availability_status' => 'required|in:Available,Unavailable',
        ]);

        // Handle photo upload
        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('photos', 'public')
            : null;

        // Create user
        $responder = User::create([
            'agency_id' => $request->agency_id,
            'user_type' => $request->user_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'gender' => $request->gender,
            'position' => $request->position,
            'photo' => $photoPath,
            'contact_number' => $request->contact_number,
            'account_status' => $request->account_status,
            'availability_status' => $request->availability_status,
        ]);

        if ($responder) {

            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Add',
                'agency_id' => auth()->user()->agency_id,
                'user_id' => $responder->id, // ✅ only the ID
            ]);

            return redirect()->route('bfp.responders')->with('success', 'Successfully Register Responder.');
        } else {
            return redirect()->back()->with('errors', 'Register fail, Please try again.')->withInput();
        }
    }

    public function edit($id)
    {
        $sessionUser = auth()->user()->user_type;
        $responder = User::findOrFail($id);

        if ($sessionUser !== 'admin') {
            return view('PAGES/BFP_BDRRMC/edit-personnel-responders', compact('responder'));
        } else {
            return view('PAGES/admin/edit-personnel-responders', compact('responder'));
        }
    }

    public function updateResponders(Request $request, $id)
    {
        $sessionUser = auth()->user()->user_type;
        $responder = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'email',
            'lastname',
            'firstname',
            'gender',
            'position',
            'contact_number',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        $updated = $responder->update($data);

        // Log action
        Log::create([
            'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
            'interaction_type' => 'Update',
            'creator_user_id' => auth()->id(),
            'agency_id' => auth()->user()->agency_id,
            'user_id' => $responder->id,
        ]);

        if ($updated) {
            if ($sessionUser !== 'admin') {
                return redirect()->route('bfp.responders')->with('success', 'Successfully Update Responder');
            } else {
                return redirect()->route('admin.responders', 'All')->with('success', 'Successfully Update Responder');
            }
        } else {
            return redirect()->back()->withErrors('error', 'Update failed, please try again.')->withInput();
        }
    }

    public function show($id)
    {
        $responder = User::findOrFail($id);

        return view('PAGES/BFP_BDRRMC/view-personnel-responders', compact('responder'));
    }

    public function destroy($id)
    {
        $responder = User::findOrFail($id);

        $responder->update([
            'account_status' => 'Deleted',
            'availability_status' => 'Unavailable'
        ]);

        // Log action before delete
        Log::create([
            'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
            'interaction_type' => 'Delete',
            'creator_user_id' => auth()->id(),
            'agency_id' => auth()->user()->agency_id,
            'user_id' => $responder->id,
        ]);

        $responder->delete();

        return $responder ? redirect()->back()->with('success', 'Responder successfully deleted.') : redirect()->back()->with('error', 'Responder delete fail');
    }
}
