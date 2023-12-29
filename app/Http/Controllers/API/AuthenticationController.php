<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            "first_name" => ['required', 'string'],
            "last_name" => ['required', 'string'],
            "gender" => ['required', 'string'],
            "dob" => ['required', 'date', 'date_format:d-m-Y'],
            "phone_number" => ['required', 'string'],
            'email' => 'required|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'role_id' => 'required',
        ]);

        $dob = Carbon::createFromFormat('d-m-Y', $data['dob'])->format('Y-m-d');
        // Add the converted date to the validated data array
        $data['dob'] = $dob;

        // Set default role to 'applicant' when user register
        $userData = array_merge($data, ['role_id' => $data['role_id'] ?? 1]);


        // Mass assign the validated request data to a new instance of the User model
        $user = User::create($userData);
        $token = $user->createToken('my-token')->plainTextToken;

        $id = $request->role_id;
        if ($request->role_id == null) {
            $id = 2;
        }

        $role = Role::find($id);

        return response()->json([
            'user' => $user,
            'token' => $token,
            'Type' => 'Bearer',
            'role' => $role->name,
        ]);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Wrong credentials'
            ]);
        }

        $token = $user->createToken('my-token')->plainTextToken;

        $role = Role::find($user->role_id);

        return response()->json([
            'user' => $user,
            'token' => $token,
            'Type' => 'Bearer',
            'role' => $role->role_name
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

     //display user
     public function getUserIndi(Request $request)
     {
         return $request->user();
     }

    //change the password
    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {

            return response([
                'message' => 'Password not match'
            ]);
        }

        // Check if the new password is at least 8 characters long
        if (strlen($request->new_password) < 8) {
            return response([
                'message' => 'New password must be at least 8 characters long'
            ]);
        }

        try {
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response([
                'message' => 'Password changed successfully',
                'new_password' => $request->new_password,
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'An error occurred while changing the password.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
