<?php

require 'mysql.php';
require 'global.php';

function add()
{
    $file = $_FILES['image'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $keterangan = $_POST['keterangan'];

    if (isEmpty([$judul, $penulis, $penerbit])) {
        return setFlash('error_tambah', 'danger', 'Semua field wajib di-isi, kecuali keterangan.');
    }
    $path = uploadImage($file);
    if (!$path) return setFlash('error_tambah', 'danger', 'Gagal menyimpan.');

    query("INSERT INTO `buku` VALUES (null, '$judul', '$penulis', '$penerbit', '$path', '$keterangan')");
    setFlash('alert', 'success', 'Data buku berhasil disimpan');
    header("location: buku.php");
}

if (isset($_POST['tambah'])) {
    add();
}
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
        <div class="col-md-5">
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
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="-" value="<?= $_POST['judul'] ?? ''; ?>">
                            <label for="judul">Judul</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="penulis" name="penulis" placeholder="-" value="<?= $_POST['penulis'] ?? ''; ?>">
                            <label for="penulis">Penulis</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="-" value="<?= $_POST['penerbit'] ?? ''; ?>">
                            <label for="penerbit">Penerbit</label>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Cover</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <?php if ($error = getFlash('message_file')) : ?>
                                <div class="alert alert-<?= $error['type']; ?> " role="alert">
                                    <div><?= $error['message']; ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea rows="4" class="form-control" id="keterangan" name="keterangan" placeholder="-"><?= $_POST['keterangan'] ?? ''; ?></textarea>
                            <label for="keterangan">Keterangan</label>
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

</body>
</html>