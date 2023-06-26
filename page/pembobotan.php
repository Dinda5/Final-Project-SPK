<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM bobot WHERE kd_bobot='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE bobot SET kd_kriteria='$_POST[kd_kriteria]', kd_perumahan='$_POST[kd_perumahan]', nilai_bobot='$_POST[nilai_bobot]' WHERE kd_bobot='$_GET[key]'";
	} else {
		$sql = "INSERT INTO bobot VALUES (NULL, '$_POST[kd_perumahan]', '$_POST[kd_kriteria]', '$_POST[nilai_bobot]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT kd_bobot FROM bobot WHERE kd_perumahan=$_POST[kd_perumahan] AND kd_kriteria=$_POST[kd_kriteria] AND nilai_bobot LIKE '%$_POST[nilai_bobot]%'");
		if ($q->num_rows) {
			echo alert("bobot sudah ada!", "?page=pembobotan");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
		echo alert("Berhasil!", "?page=pembobotan");
	} else {
		echo alert("Gagal!", "?page=pembobotan");
	}
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM bobot WHERE kd_bobot='$_GET[key]'");
	echo alert("Berhasil!", "?page=pembobotan");
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
	                        <th>Kriteria</th>
	                        <th>Bobot</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT c.nama AS nama_perumahan, b.nama AS nama_kriteria, a.nilai_bobot, a.kd_bobot FROM bobot a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN perumahan c ON a.kd_perumahan=c.kd_perumahan")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['nama_kriteria']?></td>
	                            <td><?=$row['nilai_bobot']?></td>
	                           
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>

<script type="text/javascript">
$("#kriteria").chained("#perumahan");
</script>
