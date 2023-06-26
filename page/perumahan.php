<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM daftar_perumahan WHERE nik='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE daftar_perumahan SET nik='$_POST[nik]', nama_perumahan='$_POST[nama_perumahan]', alamat='$_POST[alamat]', tahun='".date("Y")."' WHERE nik='$_GET[key]'";
	} else {
		$sql = "INSERT INTO daftar_perumahan VALUES ('$_POST[nik]', '$_POST[nama_perumahan]', '$_POST[alamat]', '".date("Y")."')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT nik FROM daftar_perumahan WHERE nik=$_POST[nik]");
		if ($q->num_rows) {
			echo alert($_POST["nik"]." sudah terdaftar!", "?page=perumahan");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
    echo alert("Berhasil!", "?page=perumahan");
  } else {
		echo alert("Gagal!", "?page=perumahan");
  }
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM perumahan WHERE nik=$_GET[key]");
	echo alert("Berhasil!", "?page=perumahan");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
	                <div class="form-group">
	                    <label for="nik">NIK</label>
	                    <input type="text" name="nik" class="form-control" <?= (!$update) ?: 'value="'.$row["nik"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="nama_perumahan">Nama Perumahan</label>
	                    <input type="text" name="nama_perumahan" class="form-control" <?= (!$update) ?: 'value="'.$row["nama_perumahan"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="alamat">Alamat</label>
	                    <input type="text" name="alamat" class="form-control" <?= (!$update) ?: 'value="'.$row["alamat"].'"' ?>>
	                </div>
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=perumahan" class="btn btn-info btn-block">Batal</a>
									<?php endif; ?>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR PERUMAHAN</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>NIK</th>
	                        <th>Nama Perumahan</th>
	                        <th>Alamat</th>
	                        <th>Tahun</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM daftar_perumahan")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['nik']?></td>
	                            <td><?=$row['nama_perumahan']?></td>
	                            <td><?=$row['alamat']?></td>
	                            <td><?=$row['tahun']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=perumahan&action=update&key=<?=$row['nik']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=perumahan&action=delete&key=<?=$row['nik']?>" class="btn btn-danger btn-xs">Hapus</a>
	                                </div>
	                            </td>
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
