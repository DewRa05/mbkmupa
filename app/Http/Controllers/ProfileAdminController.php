<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileAdminController extends Controller
{
    /**
     * Display the profile edit form for the admin.
     */
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Update the admin's profile information using AJAX.
     */
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile' => 'nullable|image|max:2048',
        ]);

        // Update profile fields
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'];
        $admin->address = $validated['address'];

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            if ($admin->profile) {
                Storage::delete('img/user/admin' . $admin->profile);
            }

            $file = $request->file('profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('img/user/admin', $filename);

            $admin->profile = $filename;
        }

        $admin->save();

        // Return a JSON response for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully!',
            'admin' => $admin // Optionally return updated data
        ]);
    }
}
