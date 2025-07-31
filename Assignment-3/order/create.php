<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Add Order</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Add Order</h2>
<form method="POST">
    <label for="user_id">User:</label>
    <select name="user_id" id="user_id" required>
        <option value="">Select User</option>
        <?php
        $users_result = $conn->query("SELECT user_id, first_name, last_name FROM user ORDER BY first_name");
        if ($users_result && $users_result->num_rows > 0) {
            while ($user = $users_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($user['user_id']) . "'>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . " (ID: " . htmlspecialchars($user['user_id']) . ")</option>";
            }
        } else {
            echo "<option value=''>No users found</option>";
        }
        ?>
    </select><br>

    <label for="order_date">Order Date:</label>
    <input type="date" name="order_date" id="order_date" required><br>

    <label for="total_amount">Total Amount:</label>
    <input type="number" step="0.01" name="total_amount" id="total_amount" placeholder="Total Amount" required><br>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="">Select Status</option>
        <option value="Pending">Pending</option>
        <option value="Processing">Processing</option>
        <option value="Shipped">Shipped</option>
        <option value="Delivered">Delivered</option>
        <option value="Cancelled">Cancelled</option>
    </select><br>

    <button type="submit" name="submit">Add Order</button>
</form>
<a href='read.php'>View Orders</a>
<?php
if(isset($_POST['submit'])){
    $user_id = $_POST['user_id'];
    $order_date = $_POST['order_date'];
    $total_amount = $_POST['total_amount'];
    $status = $_POST['status'];

    // Basic validation (can be expanded)
    if (empty($user_id) || empty($order_date) || empty($total_amount) || empty($status)) {
        echo "All fields are required.";
    } else if (!is_numeric($user_id) || $total_amount < 0) {
        echo "Invalid input for User ID or Total Amount.";
    } else {
        $sql = "INSERT INTO `order` (user_id, order_date, total_amount, status)
                VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isds", $user_id, $order_date, $total_amount, $status);
            if($stmt->execute()){
                echo "Order added successfully";
                // Optional: Redirect after successful insertion
                // header("Location: read.php");
                // exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
}
$conn->close();
?>
</body>
</html>
