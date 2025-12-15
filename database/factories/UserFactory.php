<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // All test users: password = "password"
            'wishlist' => $this->generateRandomWishlist(),
            'remember_token' => Str::random(10),
        ];
    }
    
    /**
     * Generate random wishlist with 0-4 animal IDs
     */
    private function generateRandomWishlist(): string
    {
        // Your current animal IDs (1-10)
        $allAnimalIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        
        // Random number of animals (0-4)
        $count = $this->faker->numberBetween(0, 4);
        
        // Random unique animal IDs
        $wishlistIds = $this->faker->randomElements($allAnimalIds, $count);
        
        // Sort for consistency
        sort($wishlistIds);
        
        // Return as JSON string
        return json_encode($wishlistIds);
    }
    
    /**
     * Create an admin user
     */
    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin123'),
                'wishlist' => json_encode([1, 3, 5, 7]), // Admin has specific favorites
            ];
        });
    }
    
    /**
     * Create a user with empty wishlist
     */
    public function emptyWishlist(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'wishlist' => json_encode([]),
            ];
        });
    }
    
    /**
     * Create a user with full wishlist
     */
    public function fullWishlist(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'wishlist' => json_encode([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            ];
        });
    }
}