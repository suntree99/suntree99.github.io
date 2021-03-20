<?php 

// settingan koneksi ke database | mysqli_connect("hostname", "username", "password", "database")
$connectDB = mysqli_connect("localhost", "root", "", "phpdasar");

// menghentikan pembacaan code jika koneksi gagal
if (!$connectDB) {
  exit;
}

// function query - mempersingkat perintah query
function query($query) {
  // mengambil variabel koneksi dari global
  global $connectDB;
  // (query) mengambil data tabel dari database dan menampungnya di variabel $result
  $result = mysqli_query($connectDB, $query);
  // membuat array kosong untuk menyimpan isi tabel
  $rows = [];
  // mengambil data dalam tabel dan menyimpan ke dalam array satu per satu
  while ( $adaData = mysqli_fetch_assoc($result) ) {
    $rows[] = $adaData;
  }
  return $rows;
}

// ----------------------------------------------------------------------------------------------------
// function tambah
function tambah($data) { // parameter $data disisi oleh $_POST dari form
  global $connectDB;
  $nama = htmlspecialchars($data["nama"]);
  $nik = htmlspecialchars($data["nik"]);
  $usia = htmlspecialchars($data["usia"]);
  $email = htmlspecialchars($data["email"]);
  // $gambar ditangani oleh function upload()
  // htmlspecialchar() berfungsi agar syntax html yang diinputkan user kedalam form tidak dieksekusi

  // -------------------------
  // menjalankan function upload
  $gambar = upload(); // jika benar menghasilkan/mengembalikan nama file
  if ( !$gambar ) {
    return false; // jika tidak ada gambar valid yang diupload maka mengembalikan nilai false
  }
  // -------------------------
  
  // query insert data, kosongkan id karena disi otomatis ('')
  // tambahkan kutip (') pada setiap variabel karena type-nya string
  $query = "INSERT INTO Karyawan VALUES
            ('', '$nama', '$nik', '$usia', '$email', '$gambar')";
  
  // mengeksekusi query tambah data
  mysqli_query($connectDB, $query);

  // mengecek perubahan data, jika berhasil bernilai positif (1) jika gagal bernilai negatif (-1)
  return mysqli_affected_rows($connectDB);
}

// ----------------------------------------------------------------------------------------------------
// function upload
function upload() { // file gambar dikelola oleh $_FILES berupa array multi-dimensi (dalam hal ini 2D)
  $namaFile = $_FILES["gambar"]["name"]; // array luarnya "gambar", array dalamnya "name" berisi nama file.
  $tmpName = $_FILES["gambar"]["tmp_name"]; // array dalamnya "tmp_name" berisi tempat penyimpanan sementara.

  // mengecek apakah tidak ada gambar yang dimasukkan
  $error = $_FILES["gambar"]["error"]; // array dalamnya "error", jika 0 maka tidak ada error.

  if ( $error === 4 ) { // error = 4 berarti tidak ada file yang diupload 
    echo "<script> 
            alert('Pilih gambar terlebih dahulu!');
          </script>";
    return false;
  }

  // mengecek apakah yang diupload adalah gambar (dengan ekstensi yang diizinkan)
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png']; // penentuan ekstensi gambar yang diizinkan
  $arrayTextGambar = explode('.', $namaFile); // memisahkan nama file dan ekstensinya
  $ekstensiGambar = strtolower(end($arrayTextGambar)); // mengambil ekstensi dan menjadikan huruf kecil

  // mengecek kecocokan ekstensi (dengan ekstensi yang diizinkan)
  if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
    echo "<script> 
            alert('Yang anda upload bukan gambar yang valid!');
          </script>";
    return false;
  } 

  // mengecek ukuran file (dengan ukuran yang diizinkan)
  $ukuranFile = $_FILES["gambar"]["size"]; // array dalamnya "size", berisi info ukuran file.

  if ( $ukuranFile > 1000000 ) { // ukuran dalam byte (1000000 byte = 1 MB)
    echo "<script> 
            alert('Ukurna gambar terlalu besar!');
          </script>";
    return false;
  }

  // jika lolos semua pengecekan, gambar siap diupload
  // generate nama gambar baru, agar tidak ada nama file yang sama dengan function uniqid()
  $namaFileBaru = uniqid(); // menghasilkan string unik (alfanumberik)
  $namaFileBaru .= '.'; // konkatenasi dengan dot (.)
  $namaFileBaru .= $ekstensiGambar; // konkatenasi dengan ekstensi gambar
  move_uploaded_file($tmpName, 'img/' . $namaFileBaru); // memindahkan file dari $tmpName ke folder 'img/' dengan $namaFileBaru

  return $namaFileBaru;
}

// ----------------------------------------------------------------------------------------------------
// function hapus
function hapus($id) {
  global $connectDB;

  // mengeksekusi query delete data, jangan lupa tambahkan kekhususan (WHERE) agar tidak terdelete semua
  mysqli_query($connectDB, "DELETE FROM karyawan WHERE id = $id");
  
  // mengecek perubahan data
  return mysqli_affected_rows($connectDB);
}

// ----------------------------------------------------------------------------------------------------
// function ubah
function ubah($data) {
  global $connectDB;
  $id = $data["id"];
  $nama = htmlspecialchars($data["nama"]);
  $nik = htmlspecialchars($data["nik"]);
  $usia = htmlspecialchars($data["usia"]);
  $email = htmlspecialchars($data["email"]);
  $gambarLama = htmlspecialchars($data["gambarLama"]);

  // -------------------------
  // mengecek apakah user mengambil gambar baru atau tidak
  if ($_FILES['gambar']['error'] === 4 ) { // error = 4 berarti tidak ada file baru yang diupload
    $gambar = $gambarLama;
  } else {
    // menjalankan function upload
    $gambar = upload(); // jika benar menghasilkan/mengembalikan nama file
    if ( !$gambar ) {
      return false; // jika tidak ada gambar valid yang diupload maka mengembalikan nilai false
    }
  }
  // -------------------------

  // query update data, tambahkan kutip (') pada setiap variabel karena type-nya string
  // jangan lupa tambahkan kekhususan (WHERE) agar tidak terganti semua
  $query = "UPDATE Karyawan SET
            nama = '$nama',
            nik = '$nik',
            usia = '$usia',
            email = '$email',
            gambar = '$gambar'
            WHERE
            id = $id ";

  // mengeksekusi query update data
  mysqli_query($connectDB, $query);

  // mengecek perubahan data
  return mysqli_affected_rows($connectDB);
}

// ----------------------------------------------------------------------------------------------------
// function cari
function cari($keyword) { // parameter $keyword disisi oleh $_POST["keyword"] dari form search
  $query = "SELECT * FROM karyawan WHERE
            nama LIKE '%$keyword%' OR
            nik LIKE '%$keyword%' OR
            usia LIKE '%$keyword%' OR
            email LIKE '%$keyword%' ";

  // LIKE digunakan agar pencarian dilakukan dengan kata yang mengandung keyword
  // jika menggunakan sama dengan (=) maka keyword harus sama PERSIS dengan data yang dicari
  // % berfungsi agar karakter apapun sebelum/setelah keyword tidak berpengaruh
  // tambahkan kutip ('') karena variabel harus berupa string

  // mengembalikan hasil dengan menjalankan function query
  return query($query);
}

// ----------------------------------------------------------------------------------------------------
// function registrasi
function registrasi($data) { // parameter $data disisi oleh $_POST dari form registrasi
  global $connectDB;
  $username = strtolower(stripslashes($data["username"])); // strtolower menjadikan huruf kecil, stripslashes menghilangkan backslash (\)
  $password = mysqli_real_escape_string($connectDB, $data["password"]); // mysqli_real_escape_string memungkinkan user memasukan karakter kutip
  $password2 = mysqli_real_escape_string($connectDB, $data["password2"]);

  // mengecek username sudah ada atau belum
  $adaUser = mysqli_query($connectDB, "SELECT username FROM user WHERE username = '$username'");
  
  if ( mysqli_fetch_assoc($adaUser) ) { // jika ada data dari $adaUser, jalankan script
    echo "<script> 
          alert('Username sudah dipakai!');
          </script>";
    return false;    
  }

  // mengecek kecocokan password dan konfirmasi password
  if ( $password !== $password2 ) { // jika tidak sama, jalankan script
    echo "<script> 
          alert('Konfirmasi password tidak sesuai!');
          </script>";   
    return false;
  }

  // melakukan enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // menambahkan user baru ke database
  mysqli_query($connectDB, "INSERT INTO user VALUES('', '$username', '$password')");

  // mengecek perubahan data
  return mysqli_affected_rows($connectDB);
}

?>