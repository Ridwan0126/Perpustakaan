<?php

  
require 'global.php';


$sql = "SELECT *, tp.kode as tp_kode, tp.id as tp_id, op.nama as op_nama, an.nama as an_nama FROM transaksi_peminjaman as tp LEFT JOIN anggota as an ON an.id = tp.anggota_id LEFT JOIN users as op ON op.id = tp.operator_id";
$transaksiPeminjaman = query($sql)->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT buku_transaksi_peminjaman.id as id, buku_transaksi_peminjaman.buku_id, buku_transaksi_peminjaman.transaksi_peminjaman_id, buku_transaksi_peminjaman.jml_buku, buku.judul, buku.id as buku_id FROM buku_transaksi_peminjaman LEFT JOIN buku ON buku.id = buku_transaksi_peminjaman.buku_id";
$bukuTransaksiPeminjaman = query($sql)->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Perpusku</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <style>
        

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 10px;
        }

        .no-wrap {
            white-space: nowrap;
        }

        .col {
            text-transform: uppercase;
            text-align: center;
        }

        .title {
            font-size: 20px;
            font-weight: bolder;
            text-align: center;
        }
    </style>
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

            <h1 class="title">Laporan Transaksi Peminjaman Buku</h1>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th class="col">#</th>
                <th class="col">ID</th>
                <th class="col">Kode</th>
                <th class="col">Anggota</th>
                <th class="col">Operator</th>
                <th class="col" class="no-wrap">Di pinjam pada</th>
                <th class="col" class="no-wrap">Jatuh tempo pada</th>
                <th class="col" class="no-wrap">Di kembalikan pada</th>
                <th class="col">Denda</th>
                <th class="col">Buku</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($transaksiPeminjaman as $tr) : ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td>
                        <?= $tr['tp_id']; ?>
                    </td>
                    <td class="no-wrap"><?= $tr['tp_kode']; ?></td>
                    <td class="no-wrap">
                        <?= $tr['an_nama'] ?>
                    </td>
                    <td class="no-wrap"><?= $tr['op_nama'] ?></td>
                    <td class="no-wrap"><?= formatDate($tr['dipinjam_pada'], 'd/m/Y H:i'); ?></td>
                    <td class="no-wrap"><?= formatDate($tr['jatuh_tempo_pada'], 'd/m/Y'); ?></td>
                    <td class="no-wrap"><?= formatDate($tr['dikembalikan_pada'], 'd/m/Y H:i'); ?></td>
                    <td class="no-wrap">Rp. <?= formatRupiah($tr['denda']); ?></td>
                    <td>
                        <?php
                        $currentBuku = array_filter($bukuTransaksiPeminjaman, fn ($item) => $item['transaksi_peminjaman_id'] == $tr['tp_id']);
                        $ar = array_map(fn ($item) => sprintf("%s (%s)", $item['judul'], $item['jml_buku']), $currentBuku);
                        ?>
                        <?= join(', ', $ar) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


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