<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Order Items</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Order Items</h2>
<a href="create.php">Add New Order Item</a>
<table>
<tr><th>Order ID</th><th>Product ID</th><th>Quantity</th><th>Subtotal</th><th>Actions</th></tr>
<?php
// SQL query to fetch all order items
// Changed: Removed JOIN with product table as only product_id is needed.
// Changed: ORDER BY oi.order_id ASC for ascending order, then oi.product_id ASC.
$sql = "SELECT order_id, product_id, quantity, subtotal
        FROM orderitem
        ORDER BY order_id ASC, product_id ASC"; // Changed to ASC for ascending order

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>"; // Changed to display only product_id
        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
        echo "<td>$" . htmlspecialchars(number_format($row['subtotal'], 2)) . "</td>";
        echo "<td><a href='update.php?order_id=" . htmlspecialchars($row['order_id']) . "&product_id=" . htmlspecialchars($row['product_id']) . "'>Edit</a> | ";
        echo "<a href='delete.php?order_id=" . htmlspecialchars($row['order_id']) . "&product_id=" . htmlspecialchars($row['product_id']) . "' onclick=\"return confirm('Are you sure you want to delete this order item?');\">Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No order items found.</td></tr>";
}
$conn->close();
?>
</table>
<a href='../index.php'>Back to Home</a>
</body>
</html>
