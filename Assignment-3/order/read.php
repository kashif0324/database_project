<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Orders</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Orders</h2>
<a href="create.php">Add New Order</a>
<table>
<tr><th>Order ID</th><th>User ID</th><th>Order Date</th><th>Total Amount</th><th>Status</th><th>Actions</th></tr>
<?php
// SQL query to fetch all orders
// Changed: Removed JOIN with user table as only user_id is needed.
// Changed: ORDER BY o.order_id ASC for ascending order.
$sql = "SELECT order_id, user_id, order_date, total_amount, status
        FROM `order`
        ORDER BY order_id ASC"; // Changed to ASC for ascending order

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>"; // Changed to display only user_id
        echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
        echo "<td>$" . htmlspecialchars(number_format($row['total_amount'], 2)) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td><a href='update.php?id=" . htmlspecialchars($row['order_id']) . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . htmlspecialchars($row['order_id']) . "' onclick=\"return confirm('Are you sure you want to delete this order?');\">Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No orders found.</td></tr>";
}
$conn->close();
?>
</table>
<a href='../index.php'>Back to Home</a>
</body>
</html>
