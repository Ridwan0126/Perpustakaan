<?php

require 'mysql.php';
require 'global.php';

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM buku WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    setFlash('alert', 'success', 'Data buku berhasil dihapus');
}

$sqlQuerySearch = '';

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

if (isset($_POST['search']) && $keyword) {
    $sqlQuerySearch = " WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%' OR penerbit LIKE '%$keyword%'";
}

$sql = "SELECT * FROM buku" . $sqlQuerySearch;
$buku = query($sql)->fetch_all(MYSQLI_ASSOC);

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
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
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
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Daftar Data Buku</div>
                <div class="card-body">
                    <?php require 'templates/alert.php' ?>
                    <a href="buku_tambah.php" class="btn btn-primary mb-3">Buat Buku Baru</a>
                    <form action="" class="py-2" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Cari..." name="keyword" value="<?= $keyword ?>" />
                            <button class="btn btn-outline-primary" type="submit" name="search" value="1">Cari</button>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Penulis</th>
                                <th scope="col">Penerbit</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($buku as $bk) : ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td>
                                        <span class="fw-bold"><?= $bk['id']; ?></span>
                                    </td>
                                    <td><?= $bk['judul']; ?></td>
                                    <td><?= $bk['penulis']; ?></td>
                                    <td><?= $bk['penerbit']; ?></td>
                                    <td>
                                        <a href="buku_edit.php?id=<?= $bk['id']; ?>" class="badge text-bg-primary">edit</a>
                                        <form action="" method="post" class="d-inline-block">
                                            <input type="hidden" name="id" value="<?= $bk['id']; ?>">
                                            <button name="hapus" class="badge text-bg-danger border-0">hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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