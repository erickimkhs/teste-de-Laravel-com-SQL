@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>Register</h2>
    
    <!-- SHOW ERRORS IF ANY -->
    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 5px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form method="POST" action="/register">
        @csrf
        <input type="text" name="name" placeholder="Your Name" class="form-input" required>
        <input type="email" name="email" placeholder="Email" class="form-input" required>
        <input type="password" name="password" placeholder="Password" class="form-input" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-input" required>
        <button type="submit" class="submit-btn">Create Account</button>
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        Already have an account? <a href="/login">Login here</a><br>
        <a href="/">← Back to Home</a>
    </p>
</div>
@endsection