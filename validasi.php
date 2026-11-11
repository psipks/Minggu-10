<?php
// validasi.php - logika PHP (tanpa HTML). Dipanggil dari form.php.

function err($errors, $k) {
    if (isset($errors[$k])) {
        return "<small class='err'>" . htmlspecialchars($errors[$k]) . "</small>";
    }
    return "";
}

// Whitelist
$daftarKategori = ["Web Development", "Mobile App", "Algoritma", "Game Development"];
$daftarPeserta  = ["Individu", "Tim"];

// Rentang umur
$umurMin = 17;
$umurMax = 19;

$errors = [];
$sukses = false;
$nama = $email = $hp = $umur = $repo = $kategori = $peserta = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? "");
    $email    = trim($_POST['email'] ?? "");
    $hp       = trim($_POST['hp'] ?? "");
    $umur     = trim($_POST['umur'] ?? "");
    $repo     = trim($_POST['repo'] ?? "");
    $kategori = $_POST['kategori'] ?? "";
    $peserta  = $_POST['peserta'] ?? "";
    if (!is_string($kategori)) { $kategori = ""; }
    if (!is_string($peserta))  { $peserta = ""; }

    // Nama: wajib, 3-50 karakter
    if ($nama === "") {
        $errors['nama'] = "Nama wajib diisi.";
    } elseif (mb_strlen($nama) < 3 || mb_strlen($nama) > 50) {
        $errors['nama'] = "Nama harus 3-50 karakter.";
    }

    // Email: wajib, format valid
    if ($email === "") {
        $errors['email'] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid.";
    }

    // Nomor HP: wajib, REGEXP
    $opsiHp = ["options" => ["regexp" => "/^08[0-9]{8,11}$/"]];
    if ($hp === "") {
        $errors['hp'] = "Nomor HP wajib diisi.";
    } elseif (filter_var($hp, FILTER_VALIDATE_REGEXP, $opsiHp) === false) {
        $errors['hp'] = "Nomor HP harus diawali 08 dan 10-13 digit angka.";
    }

    // Umur: bilangan bulat 17-19, di luar rentang = peringatan & tidak disimpan
    $opsiUmur = ["options" => ["min_range" => $umurMin, "max_range" => $umurMax]];
    if ($umur === "") {
        $errors['umur'] = "Umur wajib diisi.";
    } elseif (filter_var($umur, FILTER_VALIDATE_INT) === false) {
        $errors['umur'] = "Umur harus berupa angka bulat.";
    } elseif (filter_var($umur, FILTER_VALIDATE_INT, $opsiUmur) === false) {
        $errors['umur'] = "Peringatan: umur di luar rentang! Peserta harus berumur $umurMin-$umurMax tahun, data tidak dapat disimpan.";
    }

    // URL repositori GitHub: opsional, bila diisi harus URL valid
    if ($repo !== "") {
        if (!filter_var($repo, FILTER_VALIDATE_URL)) {
            $errors['repo'] = "URL tidak valid (contoh: https://github.com/username/repo).";
        } elseif (!in_array(strtolower((string) parse_url($repo, PHP_URL_SCHEME)), ["http", "https"], true)) {
            $errors['repo'] = "URL harus diawali http:// atau https://.";
        }
    }

    // Whitelist select & radio
    if (!in_array($kategori, $daftarKategori, true)) {
        $errors['kategori'] = "Pilih kategori lomba yang tersedia.";
    }
    if (!in_array($peserta, $daftarPeserta, true)) {
        $errors['peserta'] = "Pilih jenis peserta.";
    }

    $sukses = empty($errors);
}