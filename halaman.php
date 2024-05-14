<?php 

session_start();

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
        <div class="col-auto col-md-2 col-xl-2 px-sm-2 px-0 bg-dark">
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
        <div class="container">
  <div align="center">
  <!--Panel Form pencarian -->
  <div class="row">
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading"><b>Pencarian</b></div>
        <div class="panel-body">
          <form class="form-inline" >
            <div class="form-group">
              <select class="form-control" id="Kolom" name="Kolom" required="">
                <?php
                  $kolom=(isset($_GET['Kolom']))? $_GET['Kolom'] : "";
                ?>
                <option value="judul" <?php if ($kolom=="judul") echo "selected"; ?>>judul</option>
                <option value="penulis" <?php if ($kolom=="penulis") echo "selected";?>>penulis</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="KataKunci" name="KataKunci" placeholder="Kata kunci.." required="" value="<?php if (isset($_GET['KataKunci']))  echo $_GET['KataKunci']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="dashboard.php" class="btn btn-danger">Reset</a>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Tabel data Siswa -->
  <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th>No.</th>
        <th>judul</th>
        <th>penulis</th>
        <th>Jenis Kelamin</th>
      </tr>
    </thead>  
    <tbody>
      <?php
      require 'mysql.php';

     
      $page = (isset($_GET['page']))? (int) $_GET['page'] : 1;
      
      $kolomCari=(isset($_GET['Kolom']))? $_GET['Kolom'] : "";
     
      $kolomKataKunci=(isset($_GET['KataKunci']))? $_GET['KataKunci'] : "";

      // Jumlah data per dashboard
      $limit = 10;

      $limitStart = ($page - 1) * $limit;
      
      //kondisi jika parameter pencarian kosong
      if($kolomCari=="" && $kolomKataKunci==""){
        $SqlQuery = mysqli_query($conn, "SELECT * FROM buku LIMIT ".$limitStart.",".$limit);
      }else{
        //kondisi jika parameter kolom pencarian diisi
        $SqlQuery = mysqli_query($conn, "SELECT * FROM buku WHERE $kolomCari LIKE '%$kolomKataKunci%' LIMIT ".$limitStart.",".$limit);
      }
      
      $no = $limitStart + 1;
      
      while($row = mysqli_fetch_array($SqlQuery)){ 
      ?>
      
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo $row['judul']; ?></td>
          <td><?php echo $row['penerbit']; ?></td>
          <td><?php echo $row['penulis']; ?></td>
          <td><a href="keteranganbuku.php?id=<?php echo $row['id']; ?>" class="badge text-bg-primary">Detail</a></td>

        </tr>
      <?php           
      }
      ?>
    </tbody>      
  </table>
  <div align="right">
    <ul class="pagination">
      <?php
        // Jika page = 1, maka LinkPrev disable
        if($page == 1){ 
      ?>        
        <!-- link Previous Page disable --> 
        <li class="disabled"><a href="#">Previous</a></li>
      <?php
        }
        else{ 
          $LinkPrev = ($page > 1)? $page - 1 : 1;  

          if($kolomCari=="" && $kolomKataKunci==""){
          ?>
            <li ><a  href="dashboard.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
       <?php     
          }else{
        ?> 
          <li><a href="dashboard.php?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $LinkPrev;?>" >Previous</a></li>
         <?php
           } 
        }
      ?>

      <?php
        //kondisi jika parameter pencarian kosong
        if($kolomCari=="" && $kolomKataKunci==""){
          $SqlQuery = mysqli_query($conn, "SELECT * FROM buku");
        }else{
          //kondisi jika parameter kolom pencarian diisi
          $SqlQuery = mysqli_query($conn, "SELECT * FROM buku WHERE $kolomCari LIKE '%$kolomKataKunci%'");
        }     
      
        //Hitung semua jumlah data yang berada pada tabel Sisawa
        $JumlahData = mysqli_num_rows($SqlQuery);
        
        // Hitung jumlah dashboard yang tersedia
        $jumlahPage = ceil($JumlahData / $limit); 
        
        // Jumlah link number 
        $jumlahNumber = 1; 

        // Untuk awal link number
        $startNumber = ($page > $jumlahNumber)? $page - $jumlahNumber : 1; 
        
        // Untuk akhir link number
        $endNumber = ($page < ($jumlahPage - $jumlahNumber))? $page + $jumlahNumber : $jumlahPage; 
        
        for($i = $startNumber; $i <= $endNumber; $i++){
          $linkActive = ($page == $i)? ' class="active"' : '';

          if($kolomCari=="" && $kolomKataKunci==""){
      ?>
          <li<?php echo $linkActive; ?>><a href="dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

      <?php
        }else{
          ?>
          <li<?php echo $linkActive; ?>><a href="dashboard.php?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
          <?php
        }
      }
      ?>
      
      <!-- link Next Page -->
      <?php       
       if($page == $jumlahPage){ 
      ?>
        <li class="disabled"><a href="#">Next</a></li>
      <?php
      }
      else{
        $linkNext = ($page < $jumlahPage)? $page + 1 : $jumlahPage;
       if($kolomCari=="" && $kolomKataKunci==""){
          ?>
            <li><a href="dashboard.php?page=<?php echo $linkNext; ?>">Next</a></li>
       <?php     
          }else{
        ?> 
           <li><a href="dashboard.php?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $linkNext; ?>">Next</a></li>
      <?php
        }
      }
      ?>
    </ul>
  </div>
</div>
        </div>
    </div>
</div>

</body>
</html>