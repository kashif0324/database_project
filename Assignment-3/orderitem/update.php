<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Update Order Item</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Update Order Item</h2>
<?php
$order_id = $_GET['order_id'] ?? null;
$product_id = $_GET['product_id'] ?? null;
$current_quantity = '';
$current_subtotal = '';
$order_display_text = '';
$product_display_text = '';

if ($order_id && $product_id) {
    // Fetch current order item data
    $sql_select = "SELECT oi.quantity, oi.subtotal, o.order_date, p.product_name, p.price
                   FROM orderitem oi
                   JOIN `order` o ON oi.order_id = o.order_id
                   JOIN product p ON oi.product_id = p.product_id
                   WHERE oi.order_id = ? AND oi.product_id = ?";
    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("ii", $order_id, $product_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        if ($result_select->num_rows == 1) {
            $row = $result_select->fetch_assoc();
            $current_quantity = $row['quantity'];
            $current_subtotal = $row['subtotal'];
            $order_display_text = 'Order ID: ' . htmlspecialchars($order_id) . ' (Date: ' . htmlspecialchars($row['order_date']) . ')';
            $product_display_text = htmlspecialchars($row['product_name'] . ' (ID: ' . $product_id . ' - Price: $' . number_format($row['price'], 2) . ')');
        } else {
            echo "Order Item not found.";
            $order_id = null; // Invalidate IDs if not found
            $product_id = null;
        }
        $stmt_select->close();
    } else {
        echo "Error preparing select statement: " . $conn->error;
    }
}

if(isset($_POST['submit']) && $order_id && $product_id){
    $new_quantity = $_POST['quantity'];
    $new_subtotal = $_POST['subtotal'];

    // Basic validation
    if (empty($new_quantity) || empty($new_subtotal)) {
        echo "All fields are required.";
    } else if (!is_numeric($new_quantity) || $new_quantity < 1 || !is_numeric($new_subtotal) || $new_subtotal < 0) {
        echo "Invalid input for Quantity or Subtotal.";
    } else {
        $sql_update = "UPDATE orderitem SET quantity=?, subtotal=? WHERE order_id=? AND product_id=?";
        if ($stmt_update = $conn->prepare($sql_update)) {
            $stmt_update->bind_param("idii", $new_quantity, $new_subtotal, $order_id, $product_id);
            if($stmt_update->execute()){
                echo "Order Item updated successfully";
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

// Display form only if order_id and product_id are valid
if ($order_id && $product_id):
?>
<form method="POST">
    <label for="order_id_display">Order:</label>
    <input type="text" id="order_id_display" value="<?php echo htmlspecialchars($order_display_text); ?>" disabled><br>
    <small>Order and Product cannot be changed for an existing Order Item.</small><br>

    <label for="product_id_display">Product:</label>
    <input type="text" id="product_id_display" value="<?php echo htmlspecialchars($product_display_text); ?>" disabled><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($current_quantity); ?>" placeholder="Quantity" min="1" required><br>

    <label for="subtotal">Subtotal:</label>
    <input type="number" step="0.01" name="subtotal" id="subtotal" value="<?php echo htmlspecialchars($current_subtotal); ?>" placeholder="Subtotal" min="0" required><br>

    <button type="submit" name="submit">Update Order Item</button>
</form>
<?php endif; ?>
<a href='read.php'>View Order Items</a>
<?php $conn->close(); ?>
</body>
</html>
