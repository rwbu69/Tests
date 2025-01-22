<?php
session_start();
include '../db_connect.php';

if (isset($_GET['ID_Tiket'])) {
    $ID_Tiket = $_GET['ID_Tiket'];

    $sql = "SELECT 
                tiket.ID_Tiket, 
                tiket.ID_Penumpang, 
                tiket.ID_Jadwal, 
                tiket.Harga, 
                tiket.Tanggal_Pembelian, 
                penumpang.Nama, 
                penumpang.Alamat, 
                penumpang.Telepon, 
                penumpang.Email, 
                jadwal.Waktu_Berangkat, 
                jadwal.Waktu_Tiba, 
                jadwal.ID_Kendaraan 
            FROM 
                tiket
            JOIN penumpang ON tiket.ID_Penumpang = penumpang.ID_Penumpang
            JOIN jadwal ON tiket.ID_Jadwal = jadwal.ID_Jadwal
            WHERE tiket.ID_Tiket = '$ID_Tiket'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No ticket found with the given ID.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

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

    $penumpang_sql = "UPDATE penumpang 
                      SET Nama='$Nama', Alamat='$Alamat', Telepon='$Telepon', Email='$Email' 
                      WHERE ID_Penumpang='{$row['ID_Penumpang']}'";
    if (!$conn->query($penumpang_sql)) {
        echo "Error updating penumpang: " . $conn->error;
        exit();
    }

    $jadwal_sql = "UPDATE jadwal 
                   SET ID_Kendaraan='$ID_Kendaraan', Waktu_Berangkat='$Waktu_Berangkat', Waktu_Tiba='$Waktu_Tiba' 
                   WHERE ID_Jadwal='{$row['ID_Jadwal']}'";
    if (!$conn->query($jadwal_sql)) {
        echo "Error updating jadwal: " . $conn->error;
        exit();
    }

    $tiket_sql = "UPDATE tiket 
                  SET Harga='$Harga', Tanggal_Pembelian='$Tanggal_Pembelian' 
                  WHERE ID_Tiket='$ID_Tiket'";
    if ($conn->query($tiket_sql) === TRUE) {
        echo "Tiket updated successfully!";
        header("Location: view.php");
        exit();
    } else {
        echo "Error updating tiket: " . $conn->error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tiket</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h2 class="text-center mb-4">Edit Tiket</h2>

    <form action="edit.php?ID_Tiket=<?php echo $ID_Tiket; ?>" method="POST"
        class="border p-4 rounded bg-light shadow-sm">
        <div class="mb-3">
            <label for="Waktu_Berangkat" class="form-label">Waktu Berangkat:</label>
            <input type="datetime-local" name="Waktu_Berangkat" id="Waktu_Berangkat" class="form-control"
                value="<?php echo $row['Waktu_Berangkat']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Waktu_Tiba" class="form-label">Waktu Tiba:</label>
            <input type="datetime-local" name="Waktu_Tiba" id="Waktu_Tiba" class="form-control"
                value="<?php echo $row['Waktu_Tiba']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Nama" class="form-label">Nama Penumpang:</label>
            <input type="text" name="Nama" id="Nama" class="form-control" value="<?php echo $row['Nama']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Alamat" class="form-label">Alamat:</label>
            <input type="text" name="Alamat" id="Alamat" class="form-control" value="<?php echo $row['Alamat']; ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="Telepon" class="form-label">Telepon:</label>
            <input type="text" name="Telepon" id="Telepon" class="form-control" value="<?php echo $row['Telepon']; ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="Email" class="form-label">Email:</label>
            <input type="email" name="Email" id="Email" class="form-control" value="<?php echo $row['Email']; ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="ID_Kendaraan" class="form-label">Pilih Kendaraan:</label>
            <select name="ID_Kendaraan" id="ID_Kendaraan" class="form-select" required>
                <option value="">-- Select Vehicle --</option>
                <?php
                $kendaraan_sql = "SELECT ID_Kendaraan, Jenis, Plat_Nomor, Status FROM kendaraan";
                $kendaraan_result = $conn->query($kendaraan_sql);

                if ($kendaraan_result->num_rows > 0) {
                    while ($kendaraan = $kendaraan_result->fetch_assoc()) {
                        $selected = ($kendaraan['ID_Kendaraan'] == $row['ID_Kendaraan']) ? 'selected' : '';
                        echo "<option value='{$kendaraan['ID_Kendaraan']}' $selected>
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
            <input type="number" name="Harga" id="Harga" class="form-control" value="<?php echo $row['Harga']; ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="Tanggal_Pembelian" class="form-label">Tanggal Pembelian:</label>
            <input type="date" name="Tanggal_Pembelian" id="Tanggal_Pembelian" class="form-control"
                value="<?php echo $row['Tanggal_Pembelian']; ?>" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success w-100">Update Tiket</button>
    </form>

    <a href="view.php" class="d-block text-center mt-3 btn btn-primary mb-3">Kembali</a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>