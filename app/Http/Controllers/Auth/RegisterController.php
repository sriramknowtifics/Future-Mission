<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Customer;             // <<< ADD THIS
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;   // <<< useful for logging

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'phone' => ['nullable','string','max:30'],
            'password' => ['required','confirmed', Password::defaults()],
        ]);

        // for now hardcoded
        $role = 'customer';

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => strtolower($request->input('email')),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'role_hint' => $role,
            ]);

            if ($role === 'vendor') {
                $user->assignRole('vendor');

                $shopName = $request->input('shop_name', $user->name . "'s Shop");
                $slug = Str::slug($shopName . '-' . Str::random(6));

                Vendor::create([
                    'user_id' => $user->id,
                    'shop_name' => $shopName,
                    'slug' => $slug,
                    'is_active' => false,
                ]);
            } else {
                // assign customer role
                $user->assignRole('customer');

                // create customer record (ensure Customer model has user_id in $fillable)
                Customer::create([
                    'user_id'       => $user->id,
                    'name'          => $user->name,
                    'email'         => $user->email,
                    'phone'         => $user->phone,
                    'status'        => 'inactive',
                ]);

            }

            DB::commit();

            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Registered. Please verify your email before logging in.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Registration failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Registration failed. Please check logs.']);
        }
    }
}
