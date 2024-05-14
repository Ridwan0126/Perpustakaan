<?php

require 'mysql.php';
require 'global.php';

function update($id, $bukuData)
{
    $file = $_FILES['image'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $keterangan = $_POST['keterangan'];

    if (isEmpty([$judul, $penulis, $penerbit])) {
        return setFlash('error_edit', 'danger', 'Semua field wajib di-isi, kecuali keterangan.');
    }

    $path = $bukuData['cover'];
    if ($file && $file['error'] == UPLOAD_ERR_OK) {
        $path = uploadImage($file);
        if (!$path) {
            return setFlash('error_edit', 'danger', 'Gagal menyimpan.');
        }
    }

    query("UPDATE `buku` SET judul='$judul', penulis='$penulis', penerbit='$penerbit', keterangan='$keterangan', cover='$path' WHERE id='$id'");
    setFlash('alert', 'success', 'Data buku berhasil disimpan');
    header("location: buku.php");
}

$id = $_GET['id'];

$buku = query("SELECT id, judul, penerbit, penulis, keterangan, cover FROM buku WHERE id='$id' LIMIT 1");
$bukuData = $buku->fetch_assoc();

if (isset($_POST['edit'])) {
    update($id, $bukuData);
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
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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
            <div class="card-group">

                <div class="card" style="width:300px">
        <img class="card-img-top" src='<?= $bukuData['cover'] ?>' alt="Card image" style="width:65%">
      </div>
      <div class="card" style="width:300px">
        <div class="card-body">
            <h3 class="card-title">Judul</h3>
          <h4 class="card-text"><?= $bukuData['judul'] ?></h4>
          <h5>Penulis</h5>
          <p class="card-text"><?= $bukuData['penulis'] ?></p>
          <h5>Penerbit</h5>
          <p class="card-text"><?= $bukuData['penerbit'] ?></p>
          <h5>Keterangan</h5>
          <p class="card-text"><?= $bukuData['keterangan'] ?></p>
        </div>
      </div>
            </div>
            <!-- asdasa -->
        </div>
    </div>
</div>

</body>
</html>