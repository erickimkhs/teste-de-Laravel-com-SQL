@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>Pet Adoption Center</h1>
    <p>Find your new best friend</p>
    <a href="{{ route('adopt.page') }}">
        <button class="adopt-btn">ADOPT ONE NOW!</button>
    </a>
</div>

<div class="animal-grid">
    <!-- Loop through animals from web.php -->
    @foreach($animals as $animal)
        <!-- Use component template for EACH animal -->
        @include('components.animal-card', $animal)
    @endforeach
</div>

<!-- ========== PAGINATION SECTION ========== -->
@if($totalPages > 1)
<div class="pagination">
    @if($currentPage > 1)
        <a href="?page={{ $currentPage - 1 }}" class="pagination-btn">← Previous</a>
    @endif
    
    <span class="page-info">
        Page {{ $currentPage }} of {{ $totalPages }}
    </span>
    
    @if($currentPage < $totalPages)
        <a href="?page={{ $currentPage + 1 }}" class="pagination-btn">Next →</a>
    @endif
</div>
@endif
<!-- ========== END PAGINATION SECTION ========== -->

@endsection
