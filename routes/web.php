<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Homepage with Pagination
Route::get('/', function () {
    $allAnimals = [
        [
            'id' => 1,
            'image' => '/images/animal-pictures/dog.avif',
            'name' => 'Max',
            'type' => 'Dog',
            'age' => '2 years',
            'breed' => 'Golden Retriever',
            'description' => 'Loves playing fetch and cuddling'
        ],
        [
            'id' => 2,
            'image' => '/images/animal-pictures/cat.avif',
            'name' => 'Luna',
            'type' => 'Cat',
            'age' => '6 months',
            'breed' => 'Domestic Shorthair',
            'description' => 'Very affectionate and playful'
        ],
        [
            'id'=> 3,
            'image' => '/images/animal-pictures/bunny.jpg',
            'name' => 'Buddy',
            'type' => 'Rabbit',
            'age' => '1 year',
            'breed' => 'Holland Lop',
            'description' => 'Gentle and loves carrots'
        ],
        [
            'id'=> 4,
            'image' => '/images/animal-pictures/dog2.jpg',
            'name' => 'Charlie',
            'type' => 'Dog',
            'age' => '3 years',
            'breed' => 'Beagle',
            'description' => 'Great with kids and other pets'
        ],
        [
            'id'=> 5,
            'image' => '/images/animal-pictures/cat2.jpg',
            'name' => 'Bella',
            'type' => 'Cat',
            'age' => '4 years',
            'breed' => 'Persian',
            'description' => 'Calm and loves lounging in sunny spots'
        ],
        [
            'id'=> 6,
            'image' => '/images/animal-pictures/dog3.jpg',
            'name' => 'Rocky',
            'type' => 'Dog',
            'age' => '1 year',
            'breed' => 'German Shepherd',
            'description' => 'Energetic and intelligent, needs active family'
        ],
        [
            'id'=> 7,
            'image' => '/images/animal-pictures/rabbit2.avif',
            'name' => 'Cocoa',
            'type' => 'Rabbit',
            'age' => '8 months',
            'breed' => 'Mini Rex',
            'description' => 'Soft fur and very curious'
        ],
        [
            'id'=> 8,
            'image' => '/images/animal-pictures/dog4.webp',
            'name' => 'Daisy',
            'type' => 'Dog',
            'age' => '5 years',
            'breed' => 'Lab Mix',
            'description' => 'Calm and loving companion'
        ],
        [
            'id'=> 9,
            'image' => '/images/animal-pictures/cat3.jpg',
            'name' => 'Simba',
            'type' => 'Cat',
            'age' => '2 years',
            'breed' => 'Maine Coon',
            'description' => 'Large and fluffy, gentle giant'
        ],
        [
            'id'=> 10,
            'image' => '/images/animal-pictures/dog5.jpg',
            'name' => 'Milo',
            'type' => 'Dog',
            'age' => '4 years',
            'breed' => 'Poodle',
            'description' => 'Hypoallergenic and very smart'
        ]
    ];
    
    // Pagination logic
    $page = request()->get('page', 1);
    $perPage = 3; // Show 3 animals per page
    $start = ($page - 1) * $perPage;
    $currentAnimals = array_slice($allAnimals, $start, $perPage);
    $totalPages = ceil(count($allAnimals) / $perPage);
    
    return view('welcome', [
        'animals' => $currentAnimals,
        'currentPage' => (int)$page,
        'totalPages' => $totalPages
    ]);
})->name('home');

// Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        return redirect('/dashboard');
    }

    return back()->withErrors(['email' => 'Login failed. Check your credentials.']);
});

// Register Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'wishlist' => []
    ]);

    Auth::login($user);
    
    return redirect('/dashboard')->with('success', 'Account created successfully!');
});

// Logout Route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');

// Adopt Page Route
Route::get('/adopt', function () {
    return view('adopt');
})->name('adopt.page'); 

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


// Wishlist Add Route
Route::post('/wishlist/add/{animalId}', function ($animalId, Request $request) {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Please login to add to wishlist');
    }
    
    $user = Auth::user();
    $wishlist = $user->wishlist ?? [];
    
    // Add animal ID if not already in wishlist
    if (!in_array($animalId, $wishlist)) {
        $wishlist[] = (int)$animalId;
        $user->wishlist = $wishlist;
        $user->save();
        
        return back()->with('success', 'Added to wishlist! ❤️');
    }
    
    return back()->with('info', 'Already in wishlist');
})->middleware('auth');

// Wishlist Remove Route
Route::post('/wishlist/remove/{animalId}', function ($animalId, Request $request) {
    $user = Auth::user();
    $wishlist = $user->wishlist ?? [];
    
    // Remove animal ID from wishlist
    $wishlist = array_filter($wishlist, function ($id) use ($animalId) {
        return $id != $animalId;
    });
    
    $user->wishlist = array_values($wishlist); // Reindex array
    $user->save();
    
    return back()->with('success', 'Removed from wishlist');
})->middleware('auth');

// Wishlist Page Route - ADD THIS
Route::get('/wishlist', function () {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Please login to view your wishlist');
    }
    
    $user = Auth::user();
    $wishlistIds = $user->wishlist ?? [];
    
    // Get all animals from homepage route
    $allAnimals = [
        [
            'id' => 1,
            'image' => '/images/animal-pictures/dog.avif',
            'name' => 'Max',
            'type' => 'Dog',
            'age' => '2 years',
            'breed' => 'Golden Retriever',
            'description' => 'Loves playing fetch and cuddling'
        ],
        [
            'id' => 2,
            'image' => '/images/animal-pictures/cat.avif',
            'name' => 'Luna',
            'type' => 'Cat',
            'age' => '6 months',
            'breed' => 'Domestic Shorthair',
            'description' => 'Very affectionate and playful'
        ],
        // Add all your animals here (same as homepage)
    ];
    
    // Filter animals in wishlist
    $wishlistAnimals = [];
    foreach ($allAnimals as $animal) {
        if (in_array($animal['id'], $wishlistIds)) {
            $wishlistAnimals[] = $animal;
        }
    }
    
    return view('wishlist', [
        'animals' => $wishlistAnimals,
        'wishlistCount' => count($wishlistIds)
    ]);
})->middleware('auth')->name('wishlist');