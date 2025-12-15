<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 random test users (will have random wishlists)
        User::factory()->count(5)->create();
        
        // Create specific test users
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => Hash::make('password123'),
            'wishlist' => json_encode([1, 3, 5]), // Specific animals
        ]);
        
        User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@test.com', 
            'password' => Hash::make('password123'),
            'wishlist' => json_encode([2, 4, 6, 8]),
        ]);
        
        // Create an admin user using our custom state
        User::factory()->admin()->create();
        
        // Create user with empty wishlist
        User::factory()->emptyWishlist()->create([
            'name' => 'No Favorites User',
            'email' => 'nofav@test.com',
        ]);
        
        // Create user with full wishlist
        User::factory()->fullWishlist()->create([
            'name' => 'Animal Lover',
            'email' => 'animal.lover@test.com',
        ]);
        
        echo "Created test users with random wishlists!\n";
        echo "All users have password: 'password' (except admin: 'admin123')\n";
    }
}
