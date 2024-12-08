<?php

namespace App\Http\Controllers\Ecom\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AuthController extends Controller
{
   public function register(Request $request)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed', // 'password_confirmation' required
            ]);

            // Return validation errors if any
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
       try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string|min:4',
            ]);

            // Return validation errors if any
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Check if the user exists
            $user = User::where('email', $request->email)->first();
			
			// Validate password
            if (!$user ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email',
                ], 401);
            }

            // Validate password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid password',
                ], 401);
            }

            // Generate a token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    
        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
		// Ensure the user is authenticated
		if ($request->user()) {
			if ($request->user()->tokens()->exists()) {
				$request->user()->tokens->each(function ($token) {
					$token->delete();
				});
			}		

			// Return success response
			return response()->json(['message' => 'Logged out successfully'], 200);
		}		 
		
		// Return error if user is not authenticated
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}