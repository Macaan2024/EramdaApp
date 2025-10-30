<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\EmergencyVehicle;
use App\Models\Log;
use App\Models\SubmittedReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LogsController extends Controller
{

   


    public function userLogs(Request $request, $status, $id = null)
    {
        $agencies = Agency::all();
        $search = $request->input('search');
        $trackUserId = $request->get('track_user_id'); // Detect tracking request

        // =========================
        // USERS PAGINATION LOGIC
        // =========================
        $perPage = 10;
        $usersQuery = User::withTrashed()
            ->orderBy('id')
            ->where('user_type', '!=', 'admin')
            ->when($search, function ($query, $search) {
                $query->where('lastname', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($id, function ($query, $id) {
                $query->where('agency_id', $id);
            });

        // Current page for pagination
        $page = $request->input('users_page', 1);

        // If tracking a specific user, find its page
        if ($trackUserId) {
            $allUsers = $usersQuery->get();
            $position = $allUsers->search(fn($u) => $u->id == $trackUserId);
            if ($position !== false) {
                $page = floor($position / $perPage) + 1;
            }
        }

        // Paginate users
        $users = $usersQuery->paginate($perPage, ['*'], 'users_page', $page);

        // =========================
        // LOGS QUERY LOGIC
        // =========================
        if (empty($id)) {
            if ($status === 'All') {
                $logsQuery = Log::with(['user' => fn($q) => $q->withTrashed()])
                    ->whereNotNull('user_id')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'user',
                            fn($q) =>
                            $q->withTrashed()
                                ->where('lastname', 'like', "%{$search}%")
                                ->orWhere('firstname', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                        )
                    );
            } elseif ($status === 'Delete') {
                $logsQuery = Log::with(['user' => fn($q) => $q->withTrashed()])
                    ->whereNotNull('user_id')
                    ->where('interaction_type', 'Delete')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'user',
                            fn($q) =>
                            $q->onlyTrashed()
                                ->where('lastname', 'like', "%{$search}%")
                                ->orWhere('firstname', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                        )
                    );
            } else {
                $logsQuery = Log::with(['user' => fn($q) => $q->withTrashed()])
                    ->whereNotNull('user_id')
                    ->where('interaction_type', $status);
            }
        } else {
            $checkAgency = Agency::findOrFail($id);

            if ($status === 'All') {
                $logsQuery = Log::with(['user' => fn($q) => $q->withTrashed()])
                    ->where('agency_id', $id)
                    ->whereNotNull('user_id')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'user',
                            fn($q) =>
                            $q->withTrashed()
                                ->where('lastname', 'like', "%{$search}%")
                                ->orWhere('firstname', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                        )
                    );
            } elseif ($status === 'Delete') {
                $logsQuery = Log::with(['user' => fn($q) => $q->onlyTrashed()])
                    ->where('agency_id', $id)
                    ->whereNotNull('user_id')
                    ->where('interaction_type', 'Delete')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'user',
                            fn($q) =>
                            $q->onlyTrashed()
                                ->where('lastname', 'like', "%{$search}%")
                                ->orWhere('firstname', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                        )
                    );
            } elseif ($status === 'Restored') {
                $logsQuery = Log::with(['user' => fn($q) => $q->withTrashed()])
                    ->where('agency_id', $id)
                    ->whereNotNull('user_id')
                    ->where('interaction_type', 'Restored')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'user',
                            fn($q) =>
                            $q->withTrashed()
                                ->where('lastname', 'like', "%{$search}%")
                                ->orWhere('firstname', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                        )
                    );
            } else {
                $logsQuery = Log::with(['user' => fn($q) => $q->withTrashed()])
                    ->where('agency_id', $id)
                    ->whereNotNull('user_id')
                    ->where('interaction_type', $status)
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'user',
                            fn($q) =>
                            $q->withTrashed()
                                ->where('lastname', 'like', "%{$search}%")
                                ->orWhere('firstname', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                        )
                    );
            }
        }

        // =========================
        // LOGS PAGINATION
        // =========================
        $logs = $logsQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'logs_page');

        // =========================
        // STATS COUNTS
        // =========================
        $restoredCount = Log::where('interaction_type', 'Restored')->count();
        $deletedCount = Log::where('interaction_type', 'Delete')->count();
        $editedCount = Log::where('interaction_type', 'Update')->count();
        $addedCount = Log::where('interaction_type', 'Add')->count();


        $pendingCount = User::where('account_status', 'Pending')->count();
        $activeCount = User::where('account_status', 'Active')->count();
        $deactivateCount = User::where('account_status', 'Deactivate')->count();

        // =========================
        // RETURN VIEW
        // =========================
        return view('PAGES.admin.logs-user', compact(
            'status',
            'agencies',
            'logs',
            'id',
            'search',
            'users',
            'restoredCount',
            'deletedCount',
            'editedCount',
            'addedCount',
            'pendingCount',
            'activeCount',
            'deactivateCount'
        ));
    }

    // Show User
    public function showUser($id)
    {
        $user = User::findOrFail($id);

        if ($user) {
            return view('PAGES/admin/logs-view-users', compact('user'));
        }

        return redirect()->back()->with('error', 'No user found for this log.');
    }

    // Add User Form
    public function usersAdd()
    {
        $agencies = Agency::all();

        return view('PAGES/admin/logs-add-user', compact('agencies'));
    }

    // Store New User
    public function addUsers(Request $request)
    {
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
            'account_status' => 'required|in:Pending,Active',
            'availability_status' => 'required|in:Available,Unavailable',
        ]);

        $agency = Agency::findOrFail($request->agency_id);

        if (($request->user_type === 'Nurse Chief' && $agency->agencyTypes !== 'HOSPITALS') ||
            ($request->user_type !== 'Nurse Chief' && $agency->agencyTypes === 'HOSPITALS')
        ) {
            return redirect()->back()->with('error', 'Failed to add user.');
        }

        if ($agency->agencyTypes !== 'HOSPITALS') {
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
            'account_status' => $request->account_status,
            'availability_status' => $request->availability_status,
        ]);

        if ($user) {
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Add',
                'agency_id' => auth()->user()->agency_id,
                'user_id' => $user->id, // ✅ log the user ID
            ]);

            return redirect()->route('admin.logs-users', 'All')->with('success', 'Successfully added user.');
        } else {
            return redirect()->back()->with('error', 'Failed to add user.');
        }
    }

    // Edit User Form
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $agencies = Agency::all();

        if ($user) {
            return view('PAGES/admin/logs-edit-user', compact('user', 'agencies'));
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    // Update User
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => 'required|in:m,f',
            'position' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);



        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'position' => $request->position,
            'contact_number' => $request->contact_number,
            'photo' => $data['photo'] ?? $user->photo, // If no photo uploaded, keep the old one
        ]);


        if ($user) {
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Update',
                'agency_id' => auth()->user()->agency_id,
                'user_id' => $user->id,
            ]);

            return redirect()->route('admin.logs-users', 'All')->with('success', 'User successfully updated.');
        }

        return redirect()->back()->with('error', 'Update failed.')->withInput();
    }

    // Delete User
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        if ($user) {
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Delete',
                'agency_id' => auth()->user()->agency_id,
                'user_id' => $user->id,
            ]);

            return redirect()->route('admin.logs-users', 'All')->with('success', 'User successfully deleted.');
        }

        return redirect()->back()->with('error', 'Delete failed.');
    }

    // Restore User
    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();

        if ($user) {
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Restored',
                'agency_id' => $user->agency_id,
                'user_id' => $user->id,
            ]);

            return redirect()->back()->with('success', 'User successfully restored.');
        }

        return redirect()->back()->with('error', 'User not found or already restored.');
    }





    public function vehicleLogs(Request $request, $status, $id = null)
    {
        $agencies = Agency::all();
        $search = $request->input('search');
        $trackVehicleId = $request->get('track_vehicle_id'); // Detect tracking request

        // =========================
        // VEHICLES PAGINATION LOGIC
        // =========================
        $perPage = 10;
        $vehiclesQuery = EmergencyVehicle::withTrashed()
            ->orderBy('id')
            ->when($search, function ($query, $search) {
                $query->where('plateNumber', 'like', "%{$search}%")
                    ->orWhere('vehicleTypes', 'like', "%{$search}%");
            })
            ->when($id, function ($query, $id) {
                $query->where('agency_id', $id);
            });

        // ✅ Use the current page from request (fixes pagination UI)
        $page = $request->input('vehicles_page', 1);

        // If tracking a specific vehicle, find which page it's on
        if ($trackVehicleId) {
            $allVehicles = $vehiclesQuery->get();
            $position = $allVehicles->search(fn($v) => $v->id == $trackVehicleId);
            if ($position !== false) {
                $page = floor($position / $perPage) + 1;
            }
        }

        // Paginate with proper page detection
        $vehicles = $vehiclesQuery->paginate($perPage, ['*'], 'vehicles_page', $page);

        // =========================
        // LOGS QUERY LOGIC
        // =========================
        if (empty($id)) {
            if ($status === 'All') {
                $logsQuery = Log::with(['emergencyVehicle' => fn($q) => $q->withTrashed()])
                    ->whereNotNull('emergency_vehicle_id')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'emergencyVehicle',
                            fn($q) =>
                            $q->withTrashed()->where('plateNumber', 'like', "%{$search}%")
                        )
                    );
            } elseif ($status === 'Delete') {
                $logsQuery = Log::with(['emergencyVehicle' => fn($q) => $q->withTrashed()])
                    ->whereNotNull('emergency_vehicle_id')
                    ->where('interaction_type', 'Delete')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'emergencyVehicle',
                            fn($q) =>
                            $q->onlyTrashed()->where('plateNumber', 'like', "%{$search}%")
                        )
                    );
            } else {
                $logsQuery = Log::with(['emergencyVehicle' => fn($q) => $q->withTrashed()])
                    ->whereNotNull('emergency_vehicle_id')
                    ->where('interaction_type', $status);
            }
        } else {
            // Check if the agency exists
            $checkAgency = Agency::findOrFail($id);

            if ($status === 'All') {
                $logsQuery = Log::with(['emergencyVehicle' => fn($q) => $q->withTrashed()])
                    ->where('agency_id', $id)
                    ->whereNotNull('emergency_vehicle_id')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'emergencyVehicle',
                            fn($q) =>
                            $q->withTrashed()->where('plateNumber', 'like', "%{$search}%")
                        )
                    );
            } elseif ($status === 'Delete') {
                $logsQuery = Log::with(['emergencyVehicle' => fn($q) => $q->withTrashed()])
                    ->where('agency_id', $id)
                    ->whereNotNull('emergency_vehicle_id')
                    ->where('interaction_type', 'Delete')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'emergencyVehicle',
                            fn($q) =>
                            $q->onlyTrashed()->where('plateNumber', 'like', "%{$search}%")
                        )
                    );
            } elseif ($status === 'Restored') {
                $logsQuery = Log::with(['emergencyVehicle']) // no withTrashed()
                    ->where('agency_id', $id)
                    ->whereNotNull('emergency_vehicle_id')
                    ->where('interaction_type', 'Restored')
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'emergencyVehicle',
                            fn($q) =>
                            $q->where('plateNumber', 'like', "%{$search}%")
                        )
                    );
            } else {
                $logsQuery = Log::with(['emergencyVehicle' => fn($q) => $q->withTrashed()])
                    ->where('agency_id', $id)
                    ->whereNotNull('emergency_vehicle_id')
                    ->where('interaction_type', $status)
                    ->when(
                        $search,
                        fn($query, $search) =>
                        $query->whereHas(
                            'emergencyVehicle',
                            fn($q) =>
                            $q->withTrashed()->where('plateNumber', 'like', "%{$search}%")
                        )
                    );
            }
        }

        // =========================
        // LOGS PAGINATION
        // =========================
        $logs = $logsQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'logs_page');

        // =========================
        // VIEW RETURN
        // =========================


        $policeCarCount = EmergencyVehicle::where('vehicleTypes', 'Police Car')->count();
        $fireTruckCount = EmergencyVehicle::where('vehicleTypes', 'Fire Truck')->count();
        $ambulanceCount = EmergencyVehicle::where('vehicleTypes', 'Ambulance')->count();

        $restoredCount = Log::where('interaction_type', 'Restore')->count();
        $deletedCount = Log::where('interaction_type', 'Delete')->count();
        $editedCount = Log::where('interaction_type', 'Edit')->count();
        $addedCount = Log::where('interaction_type', 'Add')->count();
        return view('PAGES.admin.logs-vehicle', compact(
            'status',
            'agencies',
            'logs',
            'id',
            'search',
            'vehicles',
            'policeCarCount',
            'fireTruckCount',
            'ambulanceCount',
            'restoredCount',
            'deletedCount',
            'editedCount',
            'addedCount'
        ));
    }





    public function showVehicle($id)
    {
        $vehicle = EmergencyVehicle::findOrFail($id);

        if ($vehicle) {
            return view('PAGES/admin/logs-view-vehicle', compact('vehicle'));
        }
        return redirect()->back()->with('error', 'No emergency vehicle found for this log.');
    }


    public function vehiclesAdd()
    {

        $agencies = Agency::all();

        return view('PAGES/admin/logs-add-vehicle', compact('agencies'));
    }

    public function addVehicles(Request $request)
    {
        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'vehicleTypes' => 'required|string|max:255',
            'plateNumber' => 'required|string|max:255|unique:emergency_vehicles,plateNumber',
            'vehicle_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable',
        ]);

        $photoPath = $request->hasFile('vehicle_photo')
            ? $request->file('vehicle_photo')->store('vehicles', 'public')
            : null;

        $vehicle = EmergencyVehicle::create([
            'agency_id' => $request->agency_id,
            'vehicleTypes' => $request->vehicleTypes,
            'plateNumber' => $request->plateNumber,
            'vehicle_photo' => $photoPath,
            'availabilityStatus' => $request->availabilityStatus,
        ]);

        if ($vehicle) {

            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Add',
                'agency_id' => auth()->user()->agency_id,
                'emergency_vehicle_id' => $vehicle->id, // ✅ only the ID
            ]);

            return redirect()->route('admin.logs-vehicles', 'All')->with('success', 'Successfully added vehicles');
        } else {
            return redirect()->back()->with('error', 'Fail to add vehicles');
        }
    }

    public function editVehicle($id)
    {

        $vehicles = EmergencyVehicle::findOrFail($id);

        $agencies = Agency::all();

        if ($vehicles) {
            return view('PAGES/admin/logs-edit-vehicle', compact('vehicles', 'agencies'));
        } else {
            return redirect()->back()->with('error', 'Vehicle ID cant be found');
        }
    }


    public function updateVehicles(Request $request, $id)
    {
        $vehicle = EmergencyVehicle::findOrFail($id);

        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'vehicleTypes' => 'required|string|max:255',
            'plateNumber' => 'required|string|max:255|unique:emergency_vehicles,plateNumber,' . $id,
            'vehicle_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availabilityStatus' => 'required|in:Available,Unavailable',
        ]);

        // ✅ Define $data before using it
        $data = [
            'agency_id' => $request->agency_id,
            'vehicleTypes' => $request->vehicleTypes,
            'plateNumber' => $request->plateNumber,
            'availabilityStatus' => $request->availabilityStatus,
        ];

        // ✅ Handle photo upload (optional)
        if ($request->hasFile('vehicle_photo')) {
            $data['vehicle_photo'] = $request->file('vehicle_photo')->store('vehicles', 'public');
        }

        // ✅ Update record
        $updated = $vehicle->update($data);

        // ✅ Log the update action
        if ($updated) {
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Update',
                'agency_id' => auth()->user()->agency_id,
                'emergency_vehicle_id' => $vehicle->id,
            ]);

            return redirect()
                ->route('admin.logs-vehicles', ['status' => 'All'])
                ->with('success', 'Successfully updated emergency vehicle.');
        }

        return redirect()
            ->back()
            ->with('error', 'Update failed, please try again.')
            ->withInput();
    }

    public function destroyVehicle($id)
    {

        $vehicle = EmergencyVehicle::findOrFail($id);

        $vehicle->update([
            'availabilityStatus' => 'Deleted'
        ]);

        $vehicle->delete();

        if ($vehicle) {
            // ✅ Delete all logs related to this vehicle (if needed)
            Log::where('emergency_vehicle_id', $id)->delete();

            // Log action before delete
            Log::create([
                'modified_by' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'interaction_type' => 'Delete',
                'agency_id' => auth()->user()->agency_id,
                'emergency_vehicle_id' => $vehicle->id
            ]);

            return redirect()->route('admin.logs-vehicles', ['status' => 'All'])->with('success', 'Emergency Vehicle successfully deleted.');
        } else {
            return redirect()->back()->with('error', 'Delete failed, please try again.');
        }
    }


    public function restoreVehicle($id)
    {
        $vehicle = EmergencyVehicle::withTrashed()->findOrFail($id);

        $vehicle->restore();

        if ($vehicle) {

            $vehicle->update([
                'availabilityStatus' => 'Available'
            ]);

            Log::create([
                'modified_by' => auth()->user()->lastname . '' . auth()->user()->firstname,
                'interaction_type' => 'Restored',
                'agency_id' => $vehicle->agency_id,
                'emergency_vehicle_id' => $vehicle->id,
            ]);

            return redirect()->back()->with('success', 'Emergency Vehicle successfully restored.');
        } else {
            return redirect()->back()->with('error', 'Vehicle not found or already restored.');
        }
    }





    public function responderIndex(Request $request, $status)
    {
        $agencies = Agency::all();
        $selectedAgency = $request->agency ?? '';

        // Logs with filters
        $logs = Log::with('user')
            ->whereNotNull('user_id')
            ->whereHas('user', function ($query) {
                $query->where('user_type', 'responders');
            })
            ->when($selectedAgency, function ($query) use ($selectedAgency) {
                $query->whereHas('user', function ($q) use ($selectedAgency) {
                    $q->where('agency_id', $selectedAgency);
                });
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('interaction_type', 'like', '%' . $request->search . '%')
                        ->orWhereHas('user', function ($userQ) use ($request) {
                            $userQ->where('firstname', 'like', '%' . $request->search . '%')
                                ->orWhere('lastname', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->when($status !== 'All', function ($query) use ($status) {
                $query->where('interaction_type', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // === Simple readable counts ===
        if ($selectedAgency) {
            $addCount = Log::where('interaction_type', 'Add Responder')
                ->whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();

            $editCount = Log::where('interaction_type', 'Update Responder')
                ->whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();

            $deleteCount = Log::where('interaction_type', 'Delete Responder')
                ->whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();

            $totalCount = Log::whereHas('user', fn($q) => $q->where('agency_id', $selectedAgency))
                ->count();
        } else {
            $addCount = Log::where('interaction_type', 'Add Responder')->count();
            $editCount = Log::where('interaction_type', 'Update Responder')->count();
            $deleteCount = Log::where('interaction_type', 'Delete Responder')->count();
            $totalCount = Log::count();
        }

        return view('PAGES.admin.user-logs', compact(
            'logs',
            'agencies',
            'status',
            'selectedAgency',
            'addCount',
            'editCount',
            'deleteCount',
            'totalCount'
        ));
    }




    public function trackResponder(User $user, $id)
    {

        // Paginate logs for this user
        $logs = Log::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // adjust page size

        return view('PAGES/admin/track-user', compact('user', 'logs', 'id'));
    }



    public function index($status, $id = null)
    {
        $vehicles = EmergencyVehicle::withTrashed()->paginate(10);

        $users = User::withTrashed()

            ->paginate(10);
        return view('PAGES.admin.manage-logs', compact('vehicles', 'users', 'status'));
    }
}
