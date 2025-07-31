<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Order Item</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
$order_id = $_GET['order_id'] ?? null;
$product_id = $_GET['product_id'] ?? null;

if ($order_id && $product_id) {
    $sql = "DELETE FROM orderitem WHERE order_id=? AND product_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $order_id, $product_id);
        if($stmt->execute()){
            echo "Order Item deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No Order ID or Product ID provided for deletion.";
}
$conn->close();
?>
<br><a href='read.php'>Back to Order Items</a>
</body>
</html>
