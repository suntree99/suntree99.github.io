<?php 

// menghubungkan code file functions.php ke dalam file ini
require 'functions.php';

// pengondisian jika tombol register ditekan
if ( isset($_POST["register"]) ) {

  // mengecek apakah registrasi berhasil dilakukan atau tidak
  if ( registrasi($_POST) > 0 ) {
    echo "<script>
          alert('User baru BERHASIL ditambahkan');
          </script>";
  } else {
    echo mysqli_error($connectDB);
  }
}

?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Halaman Registrasi</title>
    <style>
      ul { list-style-type: none; }
      li { margin-bottom: 10px;}
      label { display: block; }
      button { margin-left: 50px; margin-top: 10px;}
    </style>
  </head>
  <body>
    
    <h1>Halaman Registrasi</h1>

    <form action="" method="post">

      <ul>
        <li>
          <label for="username">Username :</label>
          <input type="text" name="username" id="username" required>
        </li>
        <li>
          <label for="password">Password :</label>
          <input type="password" name="password" id="password" required>
        </li>
        <li>
          <label for="password2">Konfimasi Password :</label>
          <input type="password" name="password2" id="password2" required>
        </li>
        <li>
          <button type="submit" name="register">Register!</button>
        </li>
      </ul>
    
    </form>

    <a href="5_login.php">Kembali ke Halaman Login</a>

  </body>
</html>  