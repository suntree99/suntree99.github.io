var tanya = true;
while( tanya ){

	// menangkap pilihan player

	var p = prompt('Pilih : gajah, semut, orang');

	// menangkap pilihan komputer
	// membangkitkan bilangan random

	var comp = Math.random();

	if ( comp < 0.34) {
		comp = "gajah";
	} else if ( comp >= 0.34 && comp < 0.67 ) {
		comp = "orang";
	} else {
		comp = "semut";
	}
	console.log(comp);

	var hasil = ""

	// menentukan rules

	if ( p == comp ) {
		hasil = "Seri";
	} else if ( p == "gajah" ) {
		// if ( comp == "orang" ) {
		// 	hasil = "MENANG!";
		// } else {
		// 	hasil = "KALAH!";
		// }
		hasil = ( comp == "orang" ) ? "MENANG" : "KALAH";
	} else if ( p == "orang") {
		hasil = ( comp == "gajah" ) ? "KALAH" : "MENANG";
	} else if ( p == "semut" ) {
		hasil = ( comp == "gajah" ) ? "KALAH" : "MENANG";
	} else {
		hasil = "Memasukkan pilihan yang salah!!";
	}

	// tampilkan hasilnya

	alert("Kamu memilih : " + p + "\nKomputer memilih : " + comp + "\nMaka hasilnya : Kamu " + hasil);

	tanya = confirm("Main lagi?");

}

alert("Terima kasih sudah bermain.");