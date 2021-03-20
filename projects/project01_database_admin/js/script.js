// memanggil JQuery(document) dengan tanda dollar ($) atau (JQuery) diikuti tanda kurung
$(document).ready(function () {
  // .ready akan mengeksekusi script di dalamnya seteleh dokumen selesai dibaca (ready)

  $("#tombolCari").hide(); // hilangkan tombol cari, untuk livesearching tidak diperlukan

  // event ketika keyword ditulis
  $("#keyword").on("keyup", function () {
    $(".loader").show(); // munculkan icon loader, hanya hiasan

    // memanggil ajax menggunakan .load() dari JQuery, kelemahan hanya bisa menggunakan GET tidak bisa POST
    // $('#container').load('ajax/karyawan.php?keyword=' + $("#keyword").val());

    // memanggil ajax menggunakan $.get() dari JQuery
    $.get("ajax/karyawan.php?keyword=" + $("#keyword").val(), function (data) {
      $("#container").html(data); // mengisi #container dengan .html() -> seperti innerHTML
      $(".loader").hide(); // loader dihilangkan
    });
  });
});
