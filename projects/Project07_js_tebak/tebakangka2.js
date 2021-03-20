var tanya = true;
while ( tanya ) {

  // menangkap pilihan komputer
  // membangkitkan bilangan random

  var comp = Math.random();

  if ( comp < 0.1) {
    comp = 1;
  } else if ( comp >= 0.1 && comp < 0.2 ) {
    comp = 2;
  } else if ( comp >= 0.2 && comp < 0.3 ) {
    comp = 3;
  } else if ( comp >= 0.3 && comp < 0.4 ) {
    comp = 4;
  } else if ( comp >= 0.4 && comp < 0.5 ) {
    comp = 5;
  } else if ( comp >= 0.5 && comp < 0.6 ) {
    comp = 6;
  } else if ( comp >= 0.6 && comp < 0.7 ) {
    comp = 7;
  } else if ( comp >= 0.7 && comp < 0.8 ) {
    comp = 8;
  } else if ( comp >= 0.8 && comp < 0.9 ) {
    comp = 9;
  } else {
    comp = 10;
  }

  console.log("Pilihan komputer : " + comp);

  // tampilan awal

  alert("Tebak angka dari 1-10\nKamu punya 3 kesempatan");

  // menangkap pilihan player

  var hasil = ""x

  parseInt(angka);
  var angka = prompt('Masukkan angka tebakan : ');

  console.log("Pilihan kamu : " + angka)

  // menentukan rules

  if ( angka == comp ) {
    hasil = "TEPAT";
    alert("Kamu memilih : " + angka + "\nTebakan kamu : " + hasil + "\n\nSELAMAT!!!");
  }
  else {
    angka = prompt('Masukkan angka tebakan : ');
    console.log("Pilihan kamu : " + angka)

    var kesempatan = 3;
    while( kesempatan > 0) {

      if ( angka > 10 ) {
        hasil = "melebihi batas tebakan";
      } else if ( angka < comp ) {
        hasil = "terlalu RENDAH";
      } else if ( angka > comp ) {
        hasil = "terlalu TINGGI";
      } else {
        hasil = "Memasukkan pilihan yang salah!!";
      }

      kesempatan--;
    if (kesempatan > 0) {
      alert("Kamu memilih : " + angka + "\nTebakan kamu : " + hasil + "\n\nAyo masih ada " + kesempatan + " kesempatan lagi.");
    } else {
      alert("Kamu memilih : " + angka + "\nTebakan kamu : " + hasil + "\n\nKesempatan kamu sudah habis.");
    }
  }

tanya = confirm("Main lagi?");
}

alert("Terima kasih sudah bermain.");
}
