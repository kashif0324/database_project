<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Order</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM `order` WHERE order_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            echo "Order deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No Order ID provided for deletion.";
}
$conn->close();
?>
<br><a href='read.php'>Back to Orders</a>
</body>
</html>
