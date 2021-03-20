<?php 

// -------------------------
// menjalankan session
session_start();

// pengondisian jika belum berhasil login, misalnya mencoba akses melalui url
if ( !isset($_SESSION["login"]) ) {
  header("Location: 5_login.php"); // mengembalikan ke halaman login
  exit;
}
// -------------------------

// menghubungkan code file functions.php ke dalam file ini
require 'functions.php';

// menangkap $_GET dari halaman index.php
$id = $_GET["id"];

// mengecek apakah data berhasil dihapus atau tidak
if ( hapus($id) > 0 ) {
  echo "
  <script>
    alert('Data BERHASIL dihapus');
    document.location.href = 'index.php';
  </script>";
} else {
  echo "
  <script>
    alert('Data GAGAL dihapus');
    document.location.href = 'index.php';
  </script>";
}

?>