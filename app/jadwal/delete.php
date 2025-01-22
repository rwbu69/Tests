<?php
session_start();
include '../db_connect.php';
if (isset($_GET['ID_Jadwal'])) {
    $ID_Jadwal = $_GET['ID_Jadwal'];

    $sql = "DELETE FROM jadwal WHERE ID_Jadwal = '$ID_Jadwal'";

    if ($conn->query($sql) === TRUE) {
        echo "Jadwal deleted successfully!";
        header("Location: view.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>