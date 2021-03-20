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

// melakukan query data
$karyawan = query("SELECT * FROM karyawan");

// pengondisian jika tombol cari ditekan
if ( isset($_POST["cari"]) ) {
  // eksekusi function cari
  $karyawan = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Halaman Admin</title>
    <script src="js/jquery-3.4.1.min.js"></script> <!-- penempatan JQuery harus lebih awal dari script yang lain -->
    <script src="js/script.js"></script>
    <style>
      .loader {
        width: 100px;
        position: absolute;
        top: 120px;
        left: 300px;
        z-index: -1;
        display: none;
      }

      /* menambahkan style untuk fitu print dari browser */
      @media print {
        .logout,
        .tambah,
        .cari,
        .aksi {
          display: none;
        }
      }
    </style>
  </head>
  <body>

    <!-- menambahkan link 'logout' untuk menghapus session -->
    <a href="6_logout.php" class="logout">Logout</a> <!-- menambahkan class "logout" untuk style print -->
    
    <h1>Daftar Karyawan</h1>
    <!-- menambahkan link 'Tambah Data Karyawan' ke halaman 1_tambah.php -->
    <a href="1_tambah.php" class="tambah">Tambah Data Karyawan</a> <!-- menambahkan class "tambah" untuk style print -->
    <br><br>

    <!-- menambahkan form untuk search -->

    <form action="" method="post" class="cari"> <!-- menambahkan class "cari" untuk style print -->
    <!-- ------------------------- -->
    <!-- ajax - memodifikasi form search dengan menambahkan attribute id pada input dan button untuk triger ajax -->
      <input type="text" name="keyword" size="40px" autofocus placeholder="masukkan keyword pencarian..." autocomplete="off" id="keyword">
      <!-- autofocus berfungsi agar element tersebut langsung aktif saat halaman dibuka -->
      <!-- placeholder berfungsi untuk menampilkan kata-kata contoh/perintah -->
      <!-- autocomplete berfungsi untuk memberikan saran kata yang pernah dimasukkan -->
      <button type="submit" name="cari" id="tombolCari">Cari!</button>
      <img src="img/loader.gif" class="loader"> <!-- hiasan loading -->
      <br><br>
    </form>

    <!-- ---------------------------------------------------------------------------------------------------- -->
    <div id="container"> <!-- menambahkan container untuk batasan ajax -->
    <table border="1" cellpadding="10" cellspacing="0">

      <tr>
        <th>No.</th>
        <th class="aksi">Aksi</th> <!-- menambahkan class "aksi" untuk style print -->
        <th>Gambar</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Usia</th>
        <th>Email</th>
      </tr>
      
      <!-- inisialisasi index -->
      <?php $i = 1; ?>
      <!-- mengambil setiap baris data sebagai $row dari $karyawan (data tabel dalam bentuk array) -->
      <?php foreach ( $karyawan as $row ) : ?> 

      <tr>
        <td><?= $i; ?></td>
        <td class="aksi"> <!-- menambahkan class "aksi" untuk style print -->
          <!-- menambahkan link 'ubah' untuk berpindah ke halaman 3_ubah.php dan mengirimkan data 'id' menggunakan $_GET["id"] -->
          <a href="3_ubah.php?id=<?= $row["id"]; ?>">ubah</a> | 
          <a href="2_hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah anda yakin data ini ingin DIHAPUS?');">hapus</a>
          <!-- menambahkan link 'hapus' untuk berpindah ke halaman 2_hapus.php dan mengirimkan data 'id' menggunakan $_GET["id"] -->
          <!-- menambahkan attribute onclick dengan function confirm untuk mengonfirmasi sebelum perintah dieksekusi -->
        </td>
        <td><img src="img/<?= $row["gambar"]; ?>" alt="<?= $row["nama"]; ?>" width="50px"></td>
        <td><?= $row["nik"]; ?></td>
        <td><?= $row["nama"]; ?></td>
        <td><?= $row["usia"]; ?></td>
        <td><?= $row["email"]; ?></td>
      </tr>
      
      <!-- increment index -->
      <?php $i++; ?>
      <!-- mengakhiri foreach -->
      <?php endforeach; ?>

    </table>
    </div> <!-- tag penutup container untuk batasan ajax -->
    <!-- ---------------------------------------------------------------------------------------------------- -->

  </body>
</html>