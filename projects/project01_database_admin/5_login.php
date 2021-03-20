<?php

// -------------------------
// menjalankan session
session_start();

// menghubungkan code file functions.php ke dalam file ini
require 'functions.php';

// -------------------------

// mengecek cookie
if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // mengambil username berdasarkan id dari cookie
  $result = mysqli_query($connectDB, "SELECT username FROM user WHERE id = $id");
  $row = mysqli_fetch_assoc($result); // mengambil rincian data dalam bentuk array asosiatif

  // pengondisian jika key dari cookie sama dengan username dari database (terenkripsi)
  if ( $key === hash('sha256', $row['username']) ) {
    // mengeset session dan menyimpannya ke dalam server
    $_SESSION['login'] = true;
  }
}
// -------------------------

// pengondisian jika sudah berhasil login
if ( isset($_SESSION["login"]) ) {
  header("Location: index.php"); // berpindak ke halaman index
  exit;
}
// -------------------------

// SESSION adalah mekanisme penyimpanan informasi ke dalam variabel superglobal $_SESSION
// agar bisa digunakan di LEBIH DARI SATU HALAMAN, SESSION disimpan di dalam SERVER

// COOKIE adalah informasi yang bisa diakses dimana saja di halaman web (browser)
// COOKIE disimpan di dalam BROWSER (CLIENT), sehingga bisa dimanipulasi (buat, edit, dan hapus)

// pengondisian jika tombol login diklik
if ( isset($_POST["login"]) ) {
  // menangkap username dan password yang diinput
  $username = $_POST["username"];
  $password = $_POST["password"];
  
  // melakukan queri dengan username yang diinput
  $result = mysqli_query($connectDB, "SELECT * FROM user WHERE username = '$username'");

  // pengondisian jika username ada di dalam database
  if ( mysqli_num_rows($result) === 1 ) { // jumlah rows dalam database, nilai 1 berarti ada
  
    // mengecek kecocokan password yang diinput ($password) dengan password di database ($row["password"])
    $row = mysqli_fetch_assoc($result);
    if ( password_verify($password, $row["password"]) ) { // jika cocok masuk ke halaman index.php
      
      // -------------------------
      // mengeset session dan menyimpannya ke dalam server
      $_SESSION["login"] = true;

      // pengondisian jika remember me dicentang
      if ( isset($_POST['remember']) ) {
        // mengeset cookie (key, value, durasi expired)
        setcookie('id', $row['id'], time()+60);
        setcookie('key', hash('sha256', $row['username']), time()+60); // melakukan generate username dengan hash(algoritma, string)    
      }
      // -------------------------

      header("Location: index.php");
      exit; // keluar dari pembacaan kode, kode di bawah tidak dieksekusi
    }
  }

  $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Halaman Login</title>
    <style>
      ul { list-style-type: none; }
      li { margin-bottom: 10px;}
      label { display: inline-block; width: 100px;}
      button { margin-left: 78px; margin-top: 10px;}
      #remember { margin-left: 104px; }
    </style>
  </head>
  <body>
    
    <h1>Halaman Login</h1>
    
    <?php if ( isset($error) ) : ?> <!-- jika setelah tombol login diklik menghasilkan $error  -->
      <p style="color:red; font-style:italic">username / password salah</p>
    <?php endif; ?>

    <form action="" method="post"> <!-- data $_POST dikirim ke halaman ini juga -->

      <ul>
        <li>
          <label for="username">Username :</label>
          <input type="text" name="username" id="username">
        </li>
        <li>
          <label for="password">Password :</label>
          <input type="password" name="password" id="password">
        </li>
        <!-- menambahkan check-box remember me -->
        <li>
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">Remember me</label>
        </li>
        <li>
          <button type="submit" name="login">Login</button>
        </li>
      </ul>

    </form>

    <p>Belum memiliki akun? registrasi <a href="4_registrasi.php">disini.</a></p>
    
  </body>
</html>