<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class VendorRegisterController extends Controller
{
  public function showRegistrationForm()
  {
    return view('auth.register-vendor');
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users,email'],
      'phone' => ['nullable', 'string', 'max:30'],
      'password' => ['required', 'confirmed', Password::defaults()],
      'shop_name' => ['required', 'string', 'max:255'],
      'shop_description' => ['nullable', 'string'],
    ]);

    DB::beginTransaction();
    try {
      $user = User::create([
        'name' => $request->name,
        'email' => strtolower($request->email),
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'role_hint' => 'vendor',
      ]);

      // ensure role exists
      Role::firstOrCreate(['name' => 'vendor', 'guard_name' => 'web']);

      // assign vendor role
      $user->assignRole('vendor');

      // create vendor profile (inactive by default — admin approval optional)
      $vendor = Vendor::create([
        'user_id' => $user->id,
        'shop_name' => $request->shop_name,
        'slug' => Str::slug($request->shop_name . '-' . Str::random(6)),
        'description' => $request->shop_description,
        'is_active' => false,
      ]);

      DB::commit();

      // fire Registered so Laravel can send verification email
      event(new Registered($user));

      return redirect()->route('login')->with('success', 'Vendor registration successful. Please verify your email. Admin will activate your seller account after review.');
    } catch (\Throwable $e) {
      DB::rollBack();
      return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
    }
  }
}
