<?php
session_start();
include '../db_connect.php';

$sql = "SELECT 
            tiket.ID_Tiket,
            tiket.Tanggal_Pembelian,
            tiket.Harga,
            jadwal.Waktu_Berangkat, 
            jadwal.Waktu_Tiba, 
            kendaraan.Jenis AS Jenis_Kendaraan, 
            penumpang.Nama AS Nama_Penumpang,
            penumpang.Telepon
        FROM 
            tiket
        JOIN 
            jadwal ON tiket.ID_Jadwal = jadwal.ID_Jadwal
        JOIN 
            kendaraan ON jadwal.ID_Kendaraan = kendaraan.ID_Kendaraan
        JOIN 
            penumpang ON tiket.ID_Penumpang = penumpang.ID_Penumpang";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tiket</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h2 class="text-center mb-4">Daftar Tiket</h2>

    <div class="d-flex justify-content-center gap-3 mb-4">
        <a href="../index.php" class="btn btn-primary">Home</a>
        <a href="add.php" class="btn btn-success">+ Tambah Tiket</a>
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'>
                <table class='table table-bordered table-striped'>
                    <thead class='table-primary'>
                        <tr>
                            <th>ID Tiket</th>
                            <th>Nama Penumpang</th>
                            <th>Telepon</th>
                            <th>Jenis Kendaraan</th>
                            <th>Waktu Berangkat</th>
                            <th>Waktu Tiba</th>
                            <th>Harga</th>
                            <th>Tanggal Pembelian</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID_Tiket']}</td>
                    <td>{$row['Nama_Penumpang']}</td>
                    <td>{$row['Telepon']}</td>
                    <td>{$row['Jenis_Kendaraan']}</td>
                    <td>{$row['Waktu_Berangkat']}</td>
                    <td>{$row['Waktu_Tiba']}</td>
                    <td>{$row['Harga']}</td>
                    <td>{$row['Tanggal_Pembelian']}</td>
                    <td>
                        <a href='edit.php?ID_Tiket={$row['ID_Tiket']}' class='btn btn-primary btn-sm'>Edit</a>
                        <a href='delete.php?ID_Tiket={$row['ID_Tiket']}' class='btn btn-danger btn-sm' 
                           onclick='return confirm(\"Are you sure you want to delete this ticket?\")'>Hapus</a>
                    </td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-center text-danger'>No records found.</p>";
    }

    $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>