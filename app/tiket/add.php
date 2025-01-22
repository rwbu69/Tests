<?php
session_start();
include '../db_connect.php';

if (isset($_POST['submit'])) {
    $Waktu_Berangkat = $_POST['Waktu_Berangkat'];
    $Waktu_Tiba = $_POST['Waktu_Tiba'];
    $Nama = $_POST['Nama'];
    $Alamat = $_POST['Alamat'];
    $Telepon = $_POST['Telepon'];
    $Email = $_POST['Email'];
    $ID_Kendaraan = $_POST['ID_Kendaraan'];
    $Harga = $_POST['Harga'];
    $Tanggal_Pembelian = $_POST['Tanggal_Pembelian'];

    $penumpang_sql = "INSERT INTO penumpang (Nama, Alamat, Telepon, Email) 
                      VALUES ('$Nama', '$Alamat', '$Telepon', '$Email')";
    if ($conn->query($penumpang_sql) === TRUE) {
        $ID_Penumpang = $conn->insert_id;
    } else {
        echo "Error inserting penumpang: " . $conn->error;
        exit();
    }

    $jadwal_sql = "INSERT INTO jadwal (ID_Kendaraan, Waktu_Berangkat, Waktu_Tiba) 
                   VALUES ('$ID_Kendaraan', '$Waktu_Berangkat', '$Waktu_Tiba')";
    if ($conn->query($jadwal_sql) === TRUE) {
        $ID_Jadwal = $conn->insert_id;
    } else {
        echo "Error inserting jadwal: " . $conn->error;
        exit();
    }

    $tiket_sql = "INSERT INTO tiket (ID_Penumpang, ID_Jadwal, Harga, Tanggal_Pembelian) 
                  VALUES ('$ID_Penumpang', '$ID_Jadwal', '$Harga', '$Tanggal_Pembelian')";
    if ($conn->query($tiket_sql) === TRUE) {
        echo "Tiket added successfully!";
        header("Location: view.php");
        exit();
    } else {
        echo "Error inserting tiket: " . $conn->error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tiket</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2 class="text-center mb-4">Tambah Tiket</h2>

    <form action="add.php" method="POST" class="border p-4 rounded bg-light shadow-sm">
        <div class="mb-3">
            <label for="Waktu_Berangkat" class="form-label">Waktu Berangkat:</label>
            <input type="datetime-local" name="Waktu_Berangkat" id="Waktu_Berangkat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Waktu_Tiba" class="form-label">Waktu Tiba:</label>
            <input type="datetime-local" name="Waktu_Tiba" id="Waktu_Tiba" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Nama" class="form-label">Nama Penumpang:</label>
            <input type="text" name="Nama" id="Nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Alamat" class="form-label">Alamat:</label>
            <input type="text" name="Alamat" id="Alamat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Telepon" class="form-label">Telepon:</label>
            <input type="text" name="Telepon" id="Telepon" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Email" class="form-label">Email:</label>
            <input type="email" name="Email" id="Email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ID_Kendaraan" class="form-label">Pilih Kendaraan:</label>
            <select name="ID_Kendaraan" id="ID_Kendaraan" class="form-select" required>
                <option value="" disabled selected hidden>Pilih Kendaraan</option>
                <?php
                $kendaraan_sql = "SELECT ID_Kendaraan, Jenis, Plat_Nomor, Status FROM kendaraan";
                $kendaraan_result = $conn->query($kendaraan_sql);

                if ($kendaraan_result->num_rows > 0) {
                    while ($kendaraan = $kendaraan_result->fetch_assoc()) {
                        echo "<option value='{$kendaraan['ID_Kendaraan']}'>
                        {$kendaraan['Jenis']} - Plat: {$kendaraan['Plat_Nomor']} - Status: {$kendaraan['Status']}
                      </option>";
                    }
                } else {
                    echo "<option value=''>No vehicles available</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="Harga" class="form-label">Harga:</label>
            <input type="number" name="Harga" id="Harga" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Tanggal_Pembelian" class="form-label">Tanggal Pembelian:</label>
            <input type="date" name="Tanggal_Pembelian" id="Tanggal_Pembelian" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success w-100">Tambah Tiket</button>
    </form>

    <a href="view.php" class="d-block text-center mt-3 btn btn-primary mb-3">Kembali</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>