<!DOCTYPE html>
<html>
    <head>
        <title>Ubah Password</title>
    </head>
    <body>
        <h1>Ubah Password Admin</h1>
        <form action="{{ url('admin/profil/ubahpassword') }}" method="post">
            <p>Password : <input type="password" name="password"></p>
            <p>Konfirmasi password : <input type="password" name="password_confirmation"></p>
            <p><input type="submit" value="Ganti Password">
        </form>
    </body>
</html>