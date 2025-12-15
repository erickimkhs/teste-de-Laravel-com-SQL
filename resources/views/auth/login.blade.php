@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>Login</h2>
    <form method="POST" action="/login">
        @csrf
        <input type="email" name="email" placeholder="Email" class="form-input" required>
        <input type="password" name="password" placeholder="Password" class="form-input" required>
        <button type="submit" class="submit-btn">Login</button>
    </form>
    <p style="text-align: center; margin-top: 20px;">
        No account? <a href="/register">Register here</a><br>
        <a href="/">← Back to Home</a>
    </p>
</div>
@endsection