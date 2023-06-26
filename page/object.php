<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM perumahan WHERE kd_perumahan='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE perumahan SET nama_perumahan='$_POST[nama_perumahan]' WHERE kd_perumahan='$_GET[key]'";
	} else {
		$sql = "INSERT INTO perumahan VALUES (NULL, '$_POST[nama_perumahan]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT kd_perumahan FROM perumahan WHERE nama_perumahan LIKE '%$_POST[nama_perumahan]%'");
		if ($q->num_rows) {
			echo alert("perumahan sudah ada!", "?page=perumahan");
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
  $connection->query("DELETE FROM perumahan WHERE kd_perumahan='$_GET[key]'");
	echo alert("Berhasil!", "?page=perumahan");
}
?>
<div class="row">
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM perumahan")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['nama']?></td>
	                            <td>
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
