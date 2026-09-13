function muatDaftarBuku() {
    muatData("../data/buku.json", [
        "judul",
        "pengarang",
        "tahun",
        "stok"
    ]);
}

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarBuku();

    const tombolMuatUlang = document.getElementById("btn-muat-ulang");

    if (tombolMuatUlang) {
        tombolMuatUlang.addEventListener("click", muatDaftarBuku);
    }
});