<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Controller
{
  //display user
  public function getUserIndi(Request $request)
  {
      return $request->user();
  }

    //update user (student, staff)
    public function updateUser(Request $request)
    {
        $user = $request->user();

        // Define an array of fields that can be updated
        $updatableFields = ['first_name', 'last_name', 'username', 'phone_number', 'bio', 'dob'];

        // Check if any data has been modified
        $isProfileModified = false;

        foreach ($updatableFields as $field) {
            if ($request->has($field) && $request->$field !== $user->$field) {
                $isProfileModified = true;
                $user->$field = $request->$field;
            }
        }

        if ($request->hasFile('image')) {
            $isProfileModified = true;
            $path = $request->file('image')->store('uploads', 'public');
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $path;
        }

        // If no data has been modified, return a response with a message
        if (!$isProfileModified) {
            return response()->json(['message' => 'No changes were made to your profile.']);
        }

        $user->save();

        return response()->json([
            'message' => 'User information updated successfully',
            'user' => $user, // Include the updated user data
        ]);
    }


    // display user 
    public function getUser(Request $request, string $id)
    {
        $programs = Books::with(['user.enrollments.course'])
        ->where('head_of_program_id', $id)
        ->get();


    }
}
