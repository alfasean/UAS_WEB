<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin | Rentaljo</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css?v=2">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/8353bdf612.js" crossorigin="anonymous"></script>
</head>

<body>
	<div class="content-wrapper">
		<div class="container-xl">
			<div class="table-responsive">
				<div class="table-wrapper">
					<div class="table-title">
						<div class="row">
							<div class="col-sm-6">
								<h2><b>RENTALJO</b></h2>
							</div>
						</div>
					</div>

					<?php
					session_start();
					$servername = "localhost";
					$username = "root";
					$password = "";
					$dbname = "db_rental_motor";

					$conn = new mysqli($servername, $username, $password, $dbname);

					if ($conn->connect_error) {
						die("Koneksi database gagal: " . $conn->connect_error);
					}

					$no = 0;

					$query = "SELECT tb_sewa.*, tb_customer.nama_customer, tb_motor.merk FROM tb_sewa
							JOIN tb_customer ON tb_sewa.id_customer = tb_customer.id_customer
							JOIN tb_motor ON tb_sewa.id_motor = tb_motor.id_motor
							ORDER BY tb_sewa.tgl_pinjam DESC";
					$result = $conn->query($query);

					if ($result) {
						if ($result->num_rows > 0) {
							echo '<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th>No</th>
											<th>Customer Name</th>
											<th>Motorcycle Name</th>
											<th>Borrow Date</th>
											<th>Return Date</th>
											<th>Actions</th>
										</tr>
									</thead>';

									while ($row = $result->fetch_assoc()) {
										$no++;
										echo '<tr>
											<td>' . $no . '</td>
											<td>' . $row['nama_customer'] . '</td>
											<td>' . $row['merk'] . '</td>
											<td>' . $row['tgl_pinjam'] . '</td>
											<td>' . $row['tgl_kembali'] . '</td>';
									
										if ($row['metode_pembayaran'] == 'Transfer Bank') {
											echo '<td>
													<div class="d-flex">
														<a href="admin.php?p=detailsewa&menu_upd=' . $row['id_sewa'] . '" class="detail"><i class="fa-solid fa-circle-info"></i></a>
														<a href="admin.php?p=updatesewa&menu_upd=' . $row['id_sewa'] . '" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
														<a href="admin.php?p=bayar&menu_upd=' . $row['id_sewa'] . '" class="bayar"><i class="fa-solid fa-money"></i></a>
														<a href="deleteSewa.php?menu_del=' . $row['id_sewa'] . '" class="delete"><i class="fa-solid fa-trash"></i></a>
													</div>
												</td>';
										} else {
											echo '<td>
													<div class="d-flex">
														<a href="admin.php?p=detailsewa&menu_upd=' . $row['id_sewa'] . '" class="detail"><i class="fa-solid fa-circle-info"></i></a>
														<a href="admin.php?p=updatesewa&menu_upd=' . $row['id_sewa'] . '" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
														<a href="deleteSewa.php?menu_del=' . $row['id_sewa'] . '" class="delete"><i class="fa-solid fa-trash"></i></a>
													</div>
												</td>';
										}
									
										echo '</tr>';
									}

							echo '</table>';
						} else {
							echo 'Tidak ada data sewa.';
						}
					} else {
						echo 'Error: ' . $conn->error;
					}

					$conn->close();
					?>

				</div>
			</div>
		</div>
	</div>
</body>

</html>