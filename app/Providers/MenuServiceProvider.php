<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Route;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
 public function boot(): void
  {
    // Ensure menu directory exists with proper permissions
    $menuDir = base_path('resources/menu');
    if (!File::exists($menuDir)) {
      File::makeDirectory($menuDir, 0755, true);
    }

    // Create default verticalMenu.json if it doesn't exist (theme demo fallback)
    $defaultMenuPath = base_path('resources/menu/verticalMenu.json');
    if (!File::exists($defaultMenuPath)) {
      $defaultMenu = [
        'menu' => [
          [
            'url' => '/dashboard',
            'name' => 'Dashboard',
            'icon' => 'menu-icon tf-icons mdi mdi-view-dashboard-outline',
            'slug' => 'dashboard',
          ],
          [
            'url' => '/profile',
            'name' => 'Profile',
            'icon' => 'menu-icon tf-icons mdi mdi-account-outline',
            'slug' => 'profile.show',
          ],
        ],
      ];
      // Ensure write permissions and create file
      if (
        file_put_contents($defaultMenuPath, json_encode($defaultMenu, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ===
        false
      ) {
        // Log error if creation fails (for theme demo debugging)
        \Log::error('Failed to create default verticalMenu.json in ' . $defaultMenuPath);
      }
    }

    // Role-based vertical menu via composer (theme demo compatibility)
    View::composer('layouts.sections.menu.verticalMenu', function ($view) use ($defaultMenuPath) {
      $menuData = [(object) ['menu' => []]]; // Default empty for guests/unauth

      if (Auth::check()) {
        $user = Auth::user();
        // Adjust role detection for Spatie or similar (theme demo assumes hasRole or roles relation)
        $roles = $user->roles; // If using Spatie, this is a collection
        $role = $roles->first()->name ?? 'GUEST'; // Or use $user->hasRole('HEADOFFICE') ? 'HEADOFFICE' : 'GUEST';

        $menuFile = base_path("resources/menu/{$role}-menu.json");

        if (File::exists($menuFile)) {
          $verticalMenuJson = file_get_contents($menuFile);
          if ($verticalMenuJson !== false) {
            $verticalMenuData = json_decode($verticalMenuJson); // No 'true' flag to get object
            if (json_last_error() === JSON_ERROR_NONE && isset($verticalMenuData->menu)) {
              $menuData = [$verticalMenuData];
            }
          }
        } else {
          // Fallback to default (ensure it exists now)
          if (File::exists($defaultMenuPath)) {
            $fallbackJson = file_get_contents($defaultMenuPath);
            if ($fallbackJson !== false) {
              $fallbackData = json_decode($fallbackJson); // No 'true' flag to get object
              if (json_last_error() === JSON_ERROR_NONE && isset($fallbackData->menu)) {
                $menuData = [$fallbackData];
              }
            }
          }
        }
      }

      $view->with('menuData', $menuData);
    });
  }
}
