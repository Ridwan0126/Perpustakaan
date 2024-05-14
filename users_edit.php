<?php

require 'mysql.php';
require 'global.php';


function update($id)
{
    $username = $_POST['username'];
    $nama = $_POST['nama'];

    if (isEmpty([$username, $nama])) {
        return setFlash('error_edit', 'danger', 'Semua field wajib di-isi.');
    }
    $user = query("SELECT id, username, nama FROM users WHERE id='$id' LIMIT 1");
    $userData = $user->fetch_assoc();
    if ($userData['username'] != $username & $user->num_rows > 0) return setFlash('error_edit', 'danger', 'Username sudah terdaftar, coba username lain!');

    query("UPDATE `users` SET nama='$nama', username='$username' WHERE id='$id'");
    setFlash('alert', 'success', 'Data users berhasil disimpan');
    header("location: users.php");
}

$id = $_GET['id'];

if (isset($_POST['edit'])) {
    update($id);
}

$user = query("SELECT id, username, nama FROM users WHERE id='$id' LIMIT 1");
$userData = $user->fetch_assoc();
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
                    Form Edit Data
                </div>
                <div class="card-body">
                    <?php if ($error = getFlash('error_edit')) : ?>
                        <div class="alert alert-<?= $error['type']; ?> " role="alert">
                            <div><?= $error['message']; ?></div>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="-" value="<?= $_POST['nama'] ?? $userData['nama']; ?>">
                            <label for="nama">Nama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="-" value="<?= $_POST['username'] ?? $userData['username']; ?>">
                            <label for="username">Username</label>
                        </div>
                        <button name="edit" class="btn btn-primary d-block mt-3 w-100 py-3 d-block fw-bold">Simpan</button>
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