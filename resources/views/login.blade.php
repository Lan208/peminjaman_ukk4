<form method="POST" action="/login">
    @csrf

    <h2>Login Admin</h2>

    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>

    <button type="submit">Login</button>
</form>

@if(session('error'))
    <p>{{ session('error') }}</p>
@endif