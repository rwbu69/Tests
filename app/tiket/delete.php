<?php
session_start();
include '../db_connect.php';

if (isset($_GET['ID_Tiket'])) {
    $ID_Tiket = $_GET['ID_Tiket'];

    $retrieve_sql = "SELECT ID_Penumpang, ID_Jadwal FROM tiket WHERE ID_Tiket = '$ID_Tiket'";
    $result = $conn->query($retrieve_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ID_Penumpang = $row['ID_Penumpang'];
        $ID_Jadwal = $row['ID_Jadwal'];

        $delete_tiket_sql = "DELETE FROM tiket WHERE ID_Tiket = '$ID_Tiket'";
        if ($conn->query($delete_tiket_sql) === TRUE) {
            $delete_jadwal_sql = "DELETE FROM jadwal WHERE ID_Jadwal = '$ID_Jadwal'";
            if ($conn->query($delete_jadwal_sql) === TRUE) {
                $delete_penumpang_sql = "DELETE FROM penumpang WHERE ID_Penumpang = '$ID_Penumpang'";
                if ($conn->query($delete_penumpang_sql) === TRUE) {
                    echo "Tiket and related data deleted successfully!";
                    header("Location: view.php");
                    exit();
                } else {
                    echo "Error deleting penumpang: " . $conn->error;
                }
            } else {
                echo "Error deleting jadwal: " . $conn->error;
            }
        } else {
            echo "Error deleting tiket: " . $conn->error;
        }
    } else {
        echo "Tiket not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

$conn->close();
?>