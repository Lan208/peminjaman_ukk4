<form method="POST" action="/users/{{ $user->id }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $user->name }}"><br>
    <input type="email" name="email" value="{{ $user->email }}"><br>

    <select name="role">
        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
    </select><br>

    <button type="submit">Update</button>
</form>