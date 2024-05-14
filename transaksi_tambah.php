<?php

require 'mysql.php';
require 'global.php';

function add()
{
    $dipinjam_pada = $_POST['dipinjam_pada'];
    $jatuh_tempo_pada = $_POST['jatuh_tempo_pada'];
    $denda = $_POST['denda'];
    $keterangan = $_POST['keterangan'];
    $anggota_id = $_POST['anggota_id'];
    $buku_ids = $_POST['buku_ids'];

    $new_buku_ids = [];
    foreach ($buku_ids['id'] as $key => $bk_id) {
        if (isset($new_buku_ids[$bk_id])) {
            $new_buku_ids[$bk_id] += intval($buku_ids['jml_buku'][$key]);
        } else {
            $new_buku_ids[$bk_id] = intval($buku_ids['jml_buku'][$key]);
        }
    }

    if (isEmpty([$dipinjam_pada, $jatuh_tempo_pada, $denda, $anggota_id])) {
        return setFlash('error_tambah', 'danger', 'Semua field wajib di-isi, kecuali keterangan.');
    }

    $kode = generateCode("TRS");
    $operatorId = auth()['user']['id'];

    query("INSERT INTO `transaksi_peminjaman` VALUES (null, '$kode', '$dipinjam_pada', '$jatuh_tempo_pada', null, '$denda', '$keterangan', '$operatorId', '$anggota_id')");

    $transaksi_id = getConn()->insert_id;

    foreach ($new_buku_ids as $id => $jml_buku) {
        query("INSERT INTO `buku_transaksi_peminjaman` VALUES (null, '$id', '$transaksi_id', '$jml_buku')");
    }

    setFlash('alert', 'success', 'Data transaksi peminjaman buku berhasil disimpan');
    header("location: transaksi.php");
}

if (isset($_POST['tambah'])) {
    add();
}

$sql = "SELECT * FROM buku ORDER BY id";
$buku = query($sql)->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM anggota ORDER BY id";
$anggota = query($sql)->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Perpusku</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    
					
					<?php 
					$role=$_SESSION['user_role'];
					
					?>
					
					<?php if($role=='digital-marketing')
					{
                      include('includes/digi-menu.php');
					} ?>
					
					
					<?php if($role=='hr')
					{
                   include('includes/hr-menu.php');
					
					} ?>
					
					
					<?php if($role=='admin')
					{
                    include('includes/admin-menu.php');
					 } ?>
					
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">loser</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col py-3">
            <!-- asd -->

            <div class="container py-5">
    <div class="row">
        <div class="col-sm-7 col-md-8">
            <div class="card">
                <div class="card-header">
                    Form Tambah Data
                </div>
                <div class="card-body">
                    <?php if ($error = getFlash('error_tambah')) : ?>
                        <div class="alert alert-<?= $error['type']; ?> " role="alert">
                            <div><?= $error['message']; ?></div>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <div class="form-floating mb-3">
                            <input type="datetime-local" class="form-control" id="dipinjam_pada" name="dipinjam_pada" placeholder="-" value="<?= $_POST['dipinjam_pada'] ?? ''; ?>">
                            <label for="dipinjam_pada">Di pinjam pada</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="jatuh_tempo_pada" name="jatuh_tempo_pada" placeholder="-" value="<?= $_POST['jatuh_tempo_pada'] ?? ''; ?>">
                            <label for="jatuh_tempo_pada">Jatuh tempo pada</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="denda" name="denda" placeholder="-" value="<?= $_POST['denda'] ?? 0; ?>">
                            <label for="denda">Denda</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea rows="4" class="form-control" id="keterangan" name="keterangan" placeholder="-"><?= $_POST['keterangan'] ?? ''; ?></textarea>
                            <label for="keterangan">Keterangan</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" aria-label="Default select example" name="anggota_id">
                                <?php foreach ($anggota as $ang) : ?>
                                    <option value="<?= $ang['id'] ?>"><?= $ang['id'] . ' - ' . $ang['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="anggota_id">Anggota</label>
                        </div>
                        <div class="mb-3">
                            <label for="buku_id" class="form-label">Buku</label>
                            <div id="item-group">
                                <div class="input-group mb-2">
                                    <select class="form-select" aria-label="Default select example" name="buku_ids[id][]">
                                        <?php foreach ($buku as $bk) : ?>
                                            <option value="<?= $bk['id'] ?>"><?= $bk['id'] . ' - ' . $bk['judul']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" class="form-control" placeholder="Jumlah buku" value="1" min="1" name="buku_ids[jml_buku][]" />
                                    <button class="btn btn-outline-danger fw-bold remove-item-group-btn" type="button">🗑</button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-end">
                                <button class="btn btn-primary btn-sm fw-bold mt-2" id="add-item-group-btn" type="button">Tambah</button>
                            </div>
                        </div>

                        <button name="tambah" class="btn btn-primary d-block mt-3 w-100 py-3 d-block fw-bold">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

            
            <!-- asdasa -->
        </div>
    </div>
</div>
<script>
    const itemGroup = document.getElementById('item-group');
    const addItemGroupBtn = document.getElementById('add-item-group-btn');

    addItemGroupBtn.addEventListener('click', function() {
        itemGroup.append(itemGroup.firstElementChild.cloneNode(true));
    });

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-item-group-btn')) {
            if (document.querySelectorAll('.remove-item-group-btn').length > 1) {
                e.target.parentElement.remove();
            }
        }
    })
</script>
</body>
</html>