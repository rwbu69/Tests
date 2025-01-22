<?php
session_start();
include '../db_connect.php';

if (isset($_POST['submit'])) {
    $ID_Kendaraan = $_POST['ID_Kendaraan'];
    $Waktu_Berangkat = $_POST['Waktu_Berangkat'];
    $Waktu_Tiba = $_POST['Waktu_Tiba'];

    $sql = "INSERT INTO jadwal (ID_Kendaraan, Waktu_Berangkat, Waktu_Tiba) 
            VALUES ('$ID_Kendaraan', '$Waktu_Berangkat', '$Waktu_Tiba')";

    if ($conn->query($sql) === TRUE) {
        echo "New jadwal added successfully!";
        header("Location: view.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2 class="text-center mb-4">Tambah Jadwal Baru</h2>

    <form action="add.php" method="POST" class="border p-4 rounded bg-light shadow-sm">
        <div class="mb-3">
            <label for="ID_Kendaraan" class="form-label">Pilih Kendaraan:</label>
            <select name="ID_Kendaraan" id="ID_Kendaraan" class="form-select" required>
                <option value="" disabled selected hidden>Pilih Kendaraan</option>
                <?php
                $sql = "SELECT ID_Kendaraan, Jenis, Plat_Nomor, Status FROM kendaraan";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['ID_Kendaraan']}'>{$row['Jenis']} - {$row['Plat_Nomor']} - {$row['Status']}</option>";
                    }
                } else {
                    echo "<option value=''>No Active Vehicles</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="Waktu_Berangkat" class="form-label">Waktu Berangkat:</label>
            <input type="datetime-local" name="Waktu_Berangkat" id="Waktu_Berangkat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Waktu_Tiba" class="form-label">Waktu Tiba:</label>
            <input type="datetime-local" name="Waktu_Tiba" id="Waktu_Tiba" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success w-100">Tambah Jadwal</button>
    </form>

    <a href="view.php" class="d-block text-center mt-3 btn btn-primary mb-3">Kembali</a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>