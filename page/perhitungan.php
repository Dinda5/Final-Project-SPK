<div class="row">
	<div class="col-md-12">
	<?php if (isset($_GET["perumahan"])) {
		$sqlKriteria = "";
		$namaKriteria = [];
		$queryKriteria = $connection->query("SELECT a.kd_kriteria, a.nama FROM kriteria a JOIN bobot b USING(kd_kriteria) WHERE b.kd_perumahan=$_GET[perumahan]");
		while ($kr = $queryKriteria->fetch_assoc()) {
			$sqlKriteria .= "SUM(
				IF(
					c.kd_kriteria=".$kr["kd_kriteria"].",
					IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization/nilai.nilai), 0
				)
			) AS ".strtolower(str_replace(" ", "_", $kr["nama"])).",";
			$namaKriteria[] = strtolower(str_replace(" ", "_", $kr["nama"]));
		}
		$sql = "SELECT
			(SELECT nama_perumahan FROM daftar_perumahan WHERE nik=perum.nik) AS nama,
			(SELECT nik FROM daftar_perumahan WHERE nik=perum.nik) AS nik,
			(SELECT tahun FROM daftar_perumahan WHERE nik=perum.nik) AS tahun,
			$sqlKriteria
			SUM(
				IF(
						c.sifat = 'max',
						nilai.nilai / c.normalization,
						c.normalization / nilai.nilai
				) * c.nilai_bobot
			) AS rangking
		FROM
			nilai
			JOIN daftar_perumahan perum USING(nik)
			JOIN (
				SELECT
						nilai.kd_kriteria AS kd_kriteria,
						kriteria.sifat AS sifat,
						(
							SELECT nilai_bobot FROM bobot WHERE kd_kriteria=kriteria.kd_kriteria AND kd_perumahan=perumahan.kd_perumahan
						) AS nilai_bobot,
						ROUND(
							IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1
						) AS normalization
					FROM nilai
					JOIN kriteria USING(kd_kriteria)
					JOIN perumahan ON kriteria.kd_perumahan=perumahan.kd_perumahan
					WHERE perumahan.kd_perumahan=$_GET[perumahan]
				GROUP BY nilai.kd_kriteria
			) c USING(kd_kriteria)
		WHERE kd_perumahan=$_GET[perumahan]
		GROUP BY nilai.nik
		ORDER BY rangking DESC"; ?>
	  <div class="panel panel-info">
	      <div class="panel-heading"><h3 class="text-center"><h2 class="text-center"><?php $query = $connection->query("SELECT * FROM perumahan WHERE kd_perumahan=$_GET[perumahan]"); echo $query->fetch_assoc()["nama"]; ?></h2></h3></div>
	      <div class="panel-body">
	          <table class="table table-condensed table-hover">
	              <thead>
	                  <tr>
							<th>Ranking</th>
							<th>NIK</th>
							<th>Nama</th>
							<?php //$query = $connection->query("SELECT nama FROM kriteria WHERE kd_perumahan=$_GET[perumahan]"); while($row = $query->fetch_assoc()): ?>
								<!-- <th><?//=$row["nama"]?></th> -->
							<?php //endwhile ?>
							<th>Nilai</th>
	                  </tr>
	              </thead>
	              <tbody>
				  <?php $no = 1; ?>
					<?php $query = $connection->query($sql); while($row = $query->fetch_assoc()): ?>
					<?php
					$rangking = number_format((float) $row["rangking"], 8, '.', '');
					$q = $connection->query("SELECT nik FROM hasil WHERE nik='$row[nik]' AND kd_perumahan='$_GET[perumahan]'");
					if (!$q->num_rows) {
					$connection->query("INSERT INTO hasil VALUES(NULL, '$_GET[perumahan]', '$row[nik]', '".$rangking."', '$row[nilai]')");
					}
					?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$row["nik"]?></td>
						<td><?=$row["nama"]?></td>
						<?php for($i=0; $i<count($namaKriteria); $i++): ?>
						<!-- <th><?//=number_format((float) $row[$namaKriteria[$i]], 8, '.', '');?></th> -->
						<?php endfor ?>
						<td><?=$rangking?></td>
					</tr>
					<?php endwhile;?>
	              </tbody>
	          </table>
	      </div>
	  </div>
	<?php } else { ?>
		<h1>perumahan belum dipilih...</h1>
	<?php } ?>
	</div>
</div>
