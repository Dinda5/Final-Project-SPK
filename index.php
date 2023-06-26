<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["is_logged"])) {
  header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perumahan</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.chained.min.js"></script>
    <style>
        body {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><?php $str = (isset($_GET["page"])) ? (($_GET["page"] == "nilai") ? "persyaratan" : $_GET["page"]) : "home"; echo strtoupper($str)?></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="?page=home">Beranda <span class="sr-only">(current)</span></a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" style="font-weight: bold; color: green;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hasil Perhitungan <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <?php $query = $connection->query("SELECT * FROM perumahan"); while ($row = $query->fetch_assoc()): ?>
                              <li><a href="?page=perhitungan&perumahan=<?=$row["kd_perumahan"]?>"><?=$row["nama"]?></a></li>
                            <?php endwhile; ?>
                          </ul>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Input <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="?page=object">Data Object</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=perumahan">Data Perumahan</a></li>
                            <li><a href="?page=kriteria">Kriteria</a></li>
                            <li><a href="?page=pembobotan">Pembobotan</a></li>
                            <li><a href="?page=penilaian">Penjabaran Kriteria</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=nilai">Perhitungan</a></li>
                          </ul>
                        </li>
                
                        <!-- <li><a href="?page=pengumuman">Pengumuman</a></li> -->
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="#">|</a></li>
                        <li><a href="#" style="font-weight: bold; color: red;"><?= ucfirst($_SESSION["username"]) ?></a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="row">
            <div class="col-md-12">
              <?php include page($_PAGE); ?>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
