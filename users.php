<?php

require 'mysql.php';
require 'global.php';

// guardAuth();
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    setFlash('alert', 'success', 'Data users berhasil dihapus');
}

$sqlQuerySearch = '';

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

if (isset($_POST['search']) && $keyword) {
    $sqlQuerySearch = " WHERE nama LIKE '%$keyword%' OR username LIKE '%$keyword%'";
}
$sql = "SELECT * FROM users" . $sqlQuerySearch;
$users = query($sql)->fetch_all(MYSQLI_ASSOC);

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
        <div class="container py-5">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Daftar Data Users</div>
                <div class="card-body">
                    <?php require 'templates/alert.php' ?>
                    <a href="users_tambah.php" class="btn btn-primary mb-3">Buat User Baru</a>
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
                                <th scope="col">Nama</th>
                                <th scope="col">Username</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td>
                                        <span class="fw-bold"><?= $user['id']; ?></span>
                                    </td>
                                    <td><?= $user['nama']; ?></td>
                                    <td><?= $user['username']; ?></td>
                                    <td>
                                        <a href="users_edit.php?id=<?= $user['id']; ?>" class="badge text-bg-primary">edit</a>
                                        <form action="" method="post" class="d-inline-block">
                                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
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
        </div>
    </div>
</div>

</body>
</html>