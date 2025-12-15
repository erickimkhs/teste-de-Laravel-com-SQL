<div class="animal-card">
    <img src="{{ $image }}" alt="{{ $name }}" class="animal-image">
    <div class="animal-info">
        <h3>{{ $name }}</h3>
        <p><strong>Type:</strong> {{ $type }}</p>
        <p><strong>Age:</strong> {{ $age }}</p>
        <p><strong>Breed:</strong> {{ $breed }}</p>
        <p>{{ $description }}</p>
        
        <!-- Wishlist Button -->
        @auth
            @php
                // Safely get wishlist as array
                $userWishlist = Auth::user()->wishlist ?? [];
                
                // If it's a string, decode it
                if (is_string($userWishlist)) {
                    $userWishlist = json_decode($userWishlist, true) ?? [];
                }
                
                // Ensure it's an array
                if (!is_array($userWishlist)) {
                    $userWishlist = [];
                }
                
                $inWishlist = in_array($id, $userWishlist);
            @endphp
            
            @if($inWishlist)
                <form method="POST" action="/wishlist/remove/{{ $id }}" class="wishlist-form">
                    @csrf
                    <button type="submit" class="wishlist-btn wishlist-remove">
                        ❤️ Remove from Wishlist
                    </button>
                </form>
            @else
                <form method="POST" action="/wishlist/add/{{ $id }}" class="wishlist-form">
                    @csrf
                    <button type="submit" class="wishlist-btn wishlist-add">
                        🤍 Add to Wishlist
                    </button>
                </form>
            @endif
        @else
            <a href="/login" class="wishlist-btn wishlist-login">
                🔒 Login to Save
            </a>
        @endauth
    </div>
</div>