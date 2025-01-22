<?php
session_start();
include '../db_connect.php';

if (isset($_GET['ID_Jadwal'])) {
    $ID_Jadwal = $_GET['ID_Jadwal'];

    $sql = "SELECT * FROM jadwal WHERE ID_Jadwal = '$ID_Jadwal'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found with ID_Jadwal = $ID_Jadwal";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

if (isset($_POST['submit'])) {
    $ID_Kendaraan = $_POST['ID_Kendaraan'];
    $Waktu_Berangkat = $_POST['Waktu_Berangkat'];
    $Waktu_Tiba = $_POST['Waktu_Tiba'];

    $sql = "UPDATE jadwal 
            SET ID_Kendaraan = '$ID_Kendaraan', 
                Waktu_Berangkat = '$Waktu_Berangkat', 
                Waktu_Tiba = '$Waktu_Tiba' 
            WHERE ID_Jadwal = '$ID_Jadwal'";

    if ($conn->query($sql) === TRUE) {
        echo "Jadwal updated successfully!";
        header("Location: view.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2 class="text-center mb-4">Edit Jadwal</h2>

    <form action="edit.php?ID_Jadwal=<?php echo $ID_Jadwal; ?>" method="POST"
        class="border p-4 rounded bg-light shadow-sm">
        <div class="mb-3">
            <label for="ID_Kendaraan" class="form-label">Pilih Kendaraan:</label>
            <select name="ID_Kendaraan" id="ID_Kendaraan" class="form-select" required>
                <option value="" disabled selected hidden>Pilih Kendaraan</option>
                <?php
                include '../db_connect.php';
                $sql = "SELECT ID_Kendaraan, Jenis, Plat_Nomor, Status FROM kendaraan";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($vehicle = $result->fetch_assoc()) {
                        $selected = ($vehicle['ID_Kendaraan'] == $row['ID_Kendaraan']) ? 'selected' : '';
                        echo "<option value='{$vehicle['ID_Kendaraan']}' $selected>{$vehicle['Jenis']} - {$vehicle['Plat_Nomor']} - {$vehicle['Status']}</option>";
                    }
                }
                ?>
            </select>
        </div>

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

        <button type="submit" name="submit" class="btn btn-success w-100">Update Jadwal</button>
    </form>

    <a href="view.php" class="d-block text-center mt-3 btn btn-primary mb-3">Kembali</a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>