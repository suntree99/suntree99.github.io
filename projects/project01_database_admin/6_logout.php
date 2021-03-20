<?php 

// menjalankan session
session_start();

// menghapus session "login"
$_SESSION=[];
session_unset(); // mengosongkan session
session_destroy(); // menghancurkan session

// -------------------------
// menghapus dan menghabiskan cookie
setcookie('id', '', time()-3600); // ganti value dengan kosong (''), dan kurangi waktunya dengan cukup banyak
setcookie('key', '', time()-3600); // ganti value dengan kosong (''), dan kurangi waktunya dengan cukup banyak
// -------------------------

// mengembalikan ke halaman login
header("Location: 5_login.php");
exit;

?>