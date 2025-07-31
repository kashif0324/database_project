<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Update Order</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Update Order</h2>
<?php
$order_id = $_GET['id'] ?? null;
$current_user_id = ''; // To store the user_id associated with the order

if ($order_id) {
    // Fetch current order data
    $sql_select = "SELECT user_id, order_date, total_amount, status FROM `order` WHERE order_id = ?";
    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("i", $order_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        if ($result_select->num_rows == 1) {
            $row = $result_select->fetch_assoc();
            $current_user_id = $row['user_id'];
            $order_date = $row['order_date'];
            $total_amount = $row['total_amount'];
            $status = $row['status'];
        } else {
            echo "Order not found.";
            $order_id = null; // Invalidate order_id if not found
        }
        $stmt_select->close();
    } else {
        echo "Error preparing select statement: " . $conn->error;
    }
}

if(isset($_POST['submit']) && $order_id){
    $user_id = $_POST['user_id'];
    $order_date = $_POST['order_date'];
    $total_amount = $_POST['total_amount'];
    $status = $_POST['status'];

    // Basic validation
    if (empty($user_id) || empty($order_date) || empty($total_amount) || empty($status)) {
        echo "All fields are required.";
    } else if (!is_numeric($user_id) || $total_amount < 0) {
        echo "Invalid input for User ID or Total Amount.";
    } else {
        $sql_update = "UPDATE `order` SET user_id=?, order_date=?, total_amount=?, status=? WHERE order_id=?";
        if ($stmt_update = $conn->prepare($sql_update)) {
            $stmt_update->bind_param("isdsi", $user_id, $order_date, $total_amount, $status, $order_id);
            if($stmt_update->execute()){
                echo "Order updated successfully";
                // Optional: Redirect after successful update
                // header("Location: read.php");
                // exit();
            } else {
                echo "Error: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            echo "Error preparing update statement: " . $conn->error;
        }
    }
}

// Display form only if order_id is valid
if ($order_id):
?>
<form method="POST">
    <label for="user_id">User:</label>
    <select name="user_id" id="user_id" required>
        <option value="">Select User</option>
        <?php
        $users_result = $conn->query("SELECT user_id, first_name, last_name FROM user ORDER BY first_name");
        if ($users_result && $users_result->num_rows > 0) {
            while ($user = $users_result->fetch_assoc()) {
                $selected = ($user['user_id'] == $current_user_id) ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($user['user_id']) . "' " . $selected . ">" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . " (ID: " . htmlspecialchars($user['user_id']) . ")</option>";
            }
        } else {
            echo "<option value=''>No users found</option>";
        }
        ?>
    </select><br>

    <label for="order_date">Order Date:</label>
    <input type="date" name="order_date" id="order_date" value="<?php echo htmlspecialchars($order_date ?? ''); ?>" required><br>

    <label for="total_amount">Total Amount:</label>
    <input type="number" step="0.01" name="total_amount" id="total_amount" value="<?php echo htmlspecialchars($total_amount ?? ''); ?>" placeholder="Total Amount" required><br>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="">Select Status</option>
        <option value="Pending" <?php echo (($status ?? '') == 'Pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="Processing" <?php echo (($status ?? '') == 'Processing') ? 'selected' : ''; ?>>Processing</option>
        <option value="Shipped" <?php echo (($status ?? '') == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
        <option value="Delivered" <?php echo (($status ?? '') == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
        <option value="Cancelled" <?php echo (($status ?? '') == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
    </select><br>

    <button type="submit" name="submit">Update Order</button>
</form>
<?php endif; ?>
<a href='read.php'>View Orders</a>
<?php $conn->close(); ?>
</body>
</html>
