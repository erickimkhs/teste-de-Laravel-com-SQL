@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="text-align: center; color: #2E8B57; margin: 40px 0;">
        ❤️ My Wishlist
    </h1>
    
    @if(count($animals) > 0)
        <div class="animal-grid">
            @foreach($animals as $animal)
                @include('components.animal-card', $animal)
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 60px;">
            <p style="font-size: 18px; color: #666;">Your wishlist is empty.</p>
            <a href="/" class="wishlist-btn" style="display: inline-block; width: auto; padding: 10px 30px;">
                Browse Pets
            </a>
        </div>
    @endif
    
    <div style="text-align: center; margin: 40px 0;">
        <a href="/" class="auth-btn">← Back to Home</a>
    </div>
</div>
@endsection