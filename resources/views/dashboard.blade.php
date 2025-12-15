@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Welcome, {{ Auth::user()->name }}!</h4>
                </div>
                <div class="card-body">
                    <p>Email: {{ Auth::user()->email }}</p>
                    
                    @php
                        $wishlistCount = count(Auth::user()->wishlist ?? []);
                    @endphp
                    
                    <p>Animals in your wishlist: <strong>{{ $wishlistCount }}</strong></p>
                    
                    @if($wishlistCount > 0)
                        <a href="{{ route('wishlist') }}" class="btn btn-warning">
                            <i class="fas fa-heart me-2"></i>View Wishlist
                        </a>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-success me-2">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                        <a href="{{ route('adopt.page') }}" class="btn btn-success">
                            <i class="fas fa-heart me-2"></i>Browse Pets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection