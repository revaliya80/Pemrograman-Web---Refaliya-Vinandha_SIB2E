function muatDaftarAnggota() {
    muatData("../data/anggota.json", [
        "no_anggota",
        "nama",
        "alamat",
        "no_hp"
    ]);
}

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);