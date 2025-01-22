<?php
session_start();
include '../db_connect.php';

$sql = "SELECT 
            jadwal.ID_Jadwal, 
            jadwal.Waktu_Berangkat, 
            jadwal.Waktu_Tiba, 
            kendaraan.Jenis, 
            kendaraan.Kapasitas, 
            kendaraan.Status
        FROM 
            jadwal
        JOIN 
            kendaraan 
        ON 
            jadwal.ID_Kendaraan = kendaraan.ID_Kendaraan";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h2 class="text-center mb-4">Jadwal</h2>

    <div class="d-flex justify-content-center gap-3 mb-4">
        <a href="../index.php" class="btn btn-primary">Home</a>
        <a href="add.php" class="btn btn-success">+ Tambah Jadwal</a>
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'>
                <table class='table table-bordered table-striped'>
                    <thead class='table-primary'>
                        <tr>
                            <th>Waktu Berangkat</th>
                            <th>Waktu Tiba</th>
                            <th>Jenis Kendaraan</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Waktu_Berangkat']}</td>
                    <td>{$row['Waktu_Tiba']}</td>
                    <td>{$row['Jenis']}</td>
                    <td>{$row['Kapasitas']}</td>
                    <td>{$row['Status']}</td>
                    <td>
                        <a href='edit.php?ID_Jadwal={$row['ID_Jadwal']}' class='btn btn-primary btn-sm'>Edit</a>
                        <a href='delete.php?ID_Jadwal={$row['ID_Jadwal']}' class='btn btn-danger btn-sm' 
                           onclick='return confirm(\"Are you sure you want to delete this jadwal?\")'>Delete</a>
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