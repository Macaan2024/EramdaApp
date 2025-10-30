<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    public function register()
    {

        $agencies = Agency::orderBy('agencyNames', 'asc')->get();

        return view('PAGES/register', compact('agencies'));
    }
    public function submitRegister(Request $request)
    {
        // Validate form input first
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
        ]);

        $agency = Agency::findOrFail($request->agency_id);
        if ($request->user_type === 'Nurse Chief' && $agency->agencyTypes !== 'HOSPITALS' ) {
            return redirect()->back()->with('error', 'Nurse Cheif is for Hospital Agencies only')->withInput();
        }
        // Business rule: Only hospital can have Nurse Chief
        if ($agency === 'HOSPITALS' && $request->user_type !== 'Nurse Chief') {
            return  redirect()->back()->with('error', 'Hospital is for Nurse Chief Only')->withInput();
        }

        // Handle photo upload
        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('photos', 'public')
            : null;

        // Create user
        $user = User::create([
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
        ]);

        // Return with message
        return $user
            ? redirect('/')->with('user', $user)
            : redirect()->back()
            ->withErrors(['registration' => 'Registration Failed, please try again.'])
            ->withInput();
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user) {
                // Admin override
                if ($user->user_type === 'admin') {
                    return redirect()->route('admin.dashboard');
                }elseif ($user->user_type === 'nurse-chief') {
                    if ($user->account_status === 'Active') {
                        return redirect()->route('nurse-chief.dashboard');
                    }else {
                        return redirect()->back()->with('error', 'User account deactivated');
                    }
                }

                // Check agency type dynamically
                $agencyType = $user->agency->agencyTypes ?? null;

                switch ($agencyType) {
                    case 'BDRRMC':
                        return redirect()->route('bdrrmc.dashboard');
                    case 'BFP':
                        return redirect()->route('bfp.dashboard');
                    case 'HOSPITALS':
                        return redirect()->route('nurse-chief.dashboard');
                    default:
                        return back()->withErrors(['agencies' => 'No Agencies Assigned Yet']);
                }
            }
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
