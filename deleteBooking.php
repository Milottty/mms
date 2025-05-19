<?php
include_once "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM bookings WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Booking deleted successfully.";
        header("Location: bookings.php");
        exit;
    } else {
        echo "Error deleting booking.";
    }
} else {
    echo "Invalid booking ID.";
}
?>
