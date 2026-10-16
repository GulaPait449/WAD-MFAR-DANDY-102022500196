<?php
$koneksi = mysqli_connect("localhost", "root", "", "laundry");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


function h($teks) {
    return htmlspecialchars($teks);
}


if (isset($_POST['simpan'])) {
    $sql  = "INSERT INTO pesanan (nama, telepon, layanan_id, jumlah, alamat, status)
             VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ssidss",
        $_POST['nama'], $_POST['telepon'], $_POST['layanan_id'],
        $_POST['jumlah'], $_POST['alamat'], $_POST['status']);
    mysqli_stmt_execute($stmt);

    header("Location: PHP_WAD.php?pesan=Pesanan berhasil disimpan");
    exit;
}

if (isset($_POST['ubah'])) {
    $sql  = "UPDATE pesanan
             SET nama=?, telepon=?, layanan_id=?, jumlah=?, alamat=?, status=?
             WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ssidssi",
        $_POST['nama'], $_POST['telepon'], $_POST['layanan_id'],
        $_POST['jumlah'], $_POST['alamat'], $_POST['status'], $_POST['id']);
    mysqli_stmt_execute($stmt);

    header("Location: PHP_WAD.php?pesan=Pesanan berhasil diubah");
    exit;
}

if (isset($_GET['hapus'])) {
    $stmt = mysqli_prepare($koneksi, "DELETE FROM pesanan WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $_GET['hapus']);
    mysqli_stmt_execute($stmt);

    header("Location: PHP_WAD.php?pesan=Pesanan berhasil dihapus");
    exit;
}

$hasil   = mysqli_query($koneksi, "SELECT * FROM layanan ORDER BY harga");
$layanan = mysqli_fetch_all($hasil, MYSQLI_ASSOC);

$hasil = mysqli_query($koneksi,
    "SELECT pesanan.*, layanan.nama AS nama_layanan, layanan.harga, layanan.satuan
     FROM pesanan
     JOIN layanan ON pesanan.layanan_id = layanan.id
     ORDER BY pesanan.id DESC");

$edit = null;
if (isset($_GET['edit'])) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM pesanan WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $_GET['edit']);
    mysqli_stmt_execute($stmt);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$daftar_status = ["Baru", "Diproses", "Selesai", "Diambil"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Layanan Laundry</title>
  <link rel="stylesheet" href="CSS_WAD.css">
</head>
<body>
  <main class="container wide">

    <header class="hero">
      <h1>Daftar Layanan dan Tarif Laundry</h1>
      <p class="subtitle">Pilih layanan yang paling sesuai dengan kebutuhan Anda</p>
      <a class="link" href="Tes_HTML.html">&larr; Halaman pemesanan (HTML)</a>
    </header>

    <?php if (isset($_GET['pesan'])) { ?>
      <div class="alert ok"><?= h($_GET['pesan']) ?></div>
    <?php } ?>

    <section class="Card-grid">
      <?php foreach ($layanan as $l) { ?>
        <article class="card<?= $l['jenis'] == 'express' ? ' card-featured' : '' ?>" data-jenis="<?= h($l['jenis']) ?>">
          <h3><?= h($l['nama']) ?></h3>
          <p class="price">Rp<?= number_format($l['harga'], 0, ',', '.') ?> <span>/ <?= h($l['satuan']) ?></span></p>
          <p class="time">Estimasi waktu: <?= h($l['estimasi']) ?></p>
        </article>
      <?php } ?>
    </section>

    <section class="Pesan">
      <h3><?= $edit ? "Ubah Pesanan #" . $edit['id'] : "Pesan Layanan" ?></h3>

      <form method="POST" action="PHP_WAD.php">
        <?php if ($edit) { ?>
          <input type="hidden" name="id" value="<?= $edit['id'] ?>">
        <?php } else { ?>
          <input type="hidden" name="status" value="Baru">
        <?php } ?>

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" placeholder="Nama lengkap" value="<?= h($edit['nama'] ?? '') ?>" required>

        <label for="telepon">No. HP</label>
        <input type="tel" id="telepon" name="telepon" placeholder="08xxxxxxxxxx" value="<?= h($edit['telepon'] ?? '') ?>" required>

        <label for="layanan_id">Jenis Layanan</label>
        <select id="layanan_id" name="layanan_id" required>
          <option value="">-- Pilih layanan --</option>
          <?php foreach ($layanan as $l) { ?>
            <option value="<?= $l['id'] ?>"
              <?php if ($edit && $edit['layanan_id'] == $l['id']) echo "selected"; ?>>
              <?= h($l['nama']) ?>
            </option>
          <?php } ?>
        </select>

        <label for="jumlah">Jumlah (kg / pcs)</label>
        <input type="number" id="jumlah" name="jumlah" min="0.5" step="0.5" value="<?= $edit['jumlah'] ?? 1 ?>" required>

        <?php if ($edit) { ?>
          <label for="status">Status</label>
          <select id="status" name="status">
            <?php foreach ($daftar_status as $s) { ?>
              <option <?php if ($edit['status'] == $s) echo "selected"; ?>><?= $s ?></option>
            <?php } ?>
          </select>
        <?php } ?>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3"><?= h($edit['alamat'] ?? '') ?></textarea>

        <?php if ($edit) { ?>
          <button type="submit" name="ubah" class="btn">Simpan Perubahan</button>
        <?php } else { ?>
          <button type="submit" name="simpan" class="btn">Kirim Pesanan</button>
        <?php } ?>
      </form>
    </section>

    <h2>Data Pesanan</h2>
    <div class="table-wrap">
      <table>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>No. HP</th>
          <th>Layanan</th>
          <th>Jumlah</th>
          <th>Total</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($hasil)) { ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= h($r['nama']) ?></td>
            <td><?= h($r['telepon']) ?></td>
            <td><?= h($r['nama_layanan']) ?></td>
            <td><?= $r['jumlah'] ?> <?= h($r['satuan']) ?></td>
            <td>Rp<?= number_format($r['jumlah'] * $r['harga'], 0, ',', '.') ?></td>
            <td><?= h($r['status']) ?></td>
            <td class="aksi">
              <a class="btn btn-sm" href="PHP_WAD.php?edit=<?= $r['id'] ?>">Edit</a>
              <a class="btn btn-sm btn-danger" href="PHP_WAD.php?hapus=<?= $r['id'] ?>"
                 onclick="return confirm('Yakin hapus pesanan ini?')">Hapus</a>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>

  </main>
</body>
</html>