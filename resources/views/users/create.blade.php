<form method="POST" action="/users">
    @csrf

    <input type="text" name="name" placeholder="Nama"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>

    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>

    <button type="submit">Simpan</button>
</form>