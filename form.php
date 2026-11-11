<?php require 'validasi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registrasi Lomba Coding</title>
<style>
  body{font-family:Arial,sans-serif;background:#f3f4f6;margin:0;padding:24px}
  .card{max-width:520px;margin:auto;background:#fff;padding:24px 28px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.1)}
  h1{margin-top:0;font-size:22px}
  label.t{display:block;font-weight:bold;margin-top:14px}
  input[type=text],input[type=email],input[type=tel],input[type=number],select{width:100%;padding:8px;margin-top:4px;border:1px solid #bbb;border-radius:6px;box-sizing:border-box}
  .err{color:#d00;display:block;margin-top:3px}
  .ok{background:#e6f7ea;color:#166534;padding:12px;border-radius:6px}
  .pil{display:inline-block;margin:6px 14px 0 0;font-weight:normal}
  button{margin-top:20px;padding:10px 20px;background:#2563eb;color:#fff;border:0;border-radius:6px;cursor:pointer;font-size:15px}
  table{width:100%;border-collapse:collapse;margin-top:10px}
  td{padding:4px 6px;border-bottom:1px solid #d1fae5}
</style>
</head>
<body>
<div class="card">
  <h1>Registrasi Lomba Coding</h1>

  <?php if ($sukses): ?>
    <div class="ok">
      <strong>Berhasil, <?= htmlspecialchars($nama) ?>! Pendaftaran Anda tercatat.</strong>
      <table>
        <tr><td>Nama</td><td><?= htmlspecialchars($nama) ?></td></tr>
        <tr><td>Email</td><td><?= htmlspecialchars($email) ?></td></tr>
        <tr><td>No. HP</td><td><?= htmlspecialchars($hp) ?></td></tr>
        <tr><td>Umur</td><td><?= htmlspecialchars($umur) ?> tahun</td></tr>
        <tr><td>Repo GitHub</td><td><?= $repo !== "" ? htmlspecialchars($repo) : "-" ?></td></tr>
        <tr><td>Kategori</td><td><?= htmlspecialchars($kategori) ?></td></tr>
        <tr><td>Peserta</td><td><?= htmlspecialchars($peserta) ?></td></tr>
      </table>
    </div>
  <?php else: ?>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
      <p class="err">Data belum dapat disimpan. Perbaiki isian yang salah di bawah.</p>
    <?php endif; ?>

    <form method="post" action="" novalidate>
      <label class="t" for="nama">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>">
      <?= err($errors, 'nama') ?>

      <label class="t" for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
      <?= err($errors, 'email') ?>

      <label class="t" for="hp">Nomor HP</label>
      <input type="tel" id="hp" name="hp" placeholder="08123456789" value="<?= htmlspecialchars($hp) ?>">
      <?= err($errors, 'hp') ?>

      <label class="t" for="umur">Umur (<?= $umurMin ?>-<?= $umurMax ?> tahun)</label>
      <input type="number" id="umur" name="umur" value="<?= htmlspecialchars($umur) ?>">
      <?= err($errors, 'umur') ?>

      <label class="t" for="repo">URL Repositori GitHub (opsional)</label>
      <input type="text" id="repo" name="repo" placeholder="https://github.com/username/repo" value="<?= htmlspecialchars($repo) ?>">
      <?= err($errors, 'repo') ?>

      <label class="t" for="kategori">Kategori Lomba</label>
      <select id="kategori" name="kategori">
        <option value="">-- Pilih --</option>
        <?php foreach ($daftarKategori as $k): ?>
          <option value="<?= htmlspecialchars($k) ?>" <?= $kategori === $k ? "selected" : "" ?>><?= htmlspecialchars($k) ?></option>
        <?php endforeach; ?>
      </select>
      <?= err($errors, 'kategori') ?>

      <label class="t">Jenis Peserta</label>
      <?php foreach ($daftarPeserta as $p): ?>
        <label class="pil">
          <input type="radio" name="peserta" value="<?= htmlspecialchars($p) ?>" <?= $peserta === $p ? "checked" : "" ?>>
          <?= htmlspecialchars($p) ?>
        </label>
      <?php endforeach; ?>
      <?= err($errors, 'peserta') ?>

      <button type="submit">Daftar</button>
    </form>

  <?php endif; ?>
</div>
</body>
</html>