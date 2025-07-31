<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Add Order Item</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Add Order Item</h2>
<form method="POST">
    <label for="order_id">Order:</label>
    <select name="order_id" id="order_id" required>
        <option value="">Select Order</option>
        <?php
        $orders_result = $conn->query("SELECT order_id, order_date FROM `order` ORDER BY order_id DESC");
        if ($orders_result && $orders_result->num_rows > 0) {
            while ($order = $orders_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($order['order_id']) . "'>" . htmlspecialchars('Order ID: ' . $order['order_id'] . ' (Date: ' . $order['order_date'] . ')') . "</option>";
            }
        } else {
            echo "<option value=''>No orders found</option>";
        }
        ?>
    </select><br>

    <label for="product_id">Product:</label>
    <select name="product_id" id="product_id" required>
        <option value="">Select Product</option>
        <?php
        $products_result = $conn->query("SELECT product_id, product_name, price FROM product ORDER BY product_name ASC");
        if ($products_result && $products_result->num_rows > 0) {
            while ($product = $products_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($product['product_id']) . "'>" . htmlspecialchars($product['product_name'] . ' (ID: ' . $product['product_id'] . ' - Price: $' . number_format($product['price'], 2) . ')') . "</option>";
            }
        } else {
            echo "<option value=''>No products found</option>";
        }
        ?>
    </select><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" placeholder="Quantity" min="1" required><br>

    <label for="subtotal">Subtotal:</label>
    <input type="number" step="0.01" name="subtotal" id="subtotal" placeholder="Subtotal" min="0" required><br>

    <button type="submit" name="submit">Add Order Item</button>
</form>
<a href='read.php'>View Order Items</a>
<?php
if(isset($_POST['submit'])){
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $subtotal = $_POST['subtotal'];

    // Basic validation
    if (empty($order_id) || empty($product_id) || empty($quantity) || empty($subtotal)) {
        echo "All fields are required.";
    } else if (!is_numeric($order_id) || !is_numeric($product_id) || !is_numeric($quantity) || $quantity < 1 || !is_numeric($subtotal) || $subtotal < 0) {
        echo "Invalid input for Order ID, Product ID, Quantity, or Subtotal.";
    } else {
        // Check for duplicate entry (order_id, product_id combination must be unique)
        $sql_check_duplicate = "SELECT COUNT(*) FROM orderitem WHERE order_id = ? AND product_id = ?";
        if ($stmt_check = $conn->prepare($sql_check_duplicate)) {
            $stmt_check->bind_param("ii", $order_id, $product_id);
            $stmt_check->execute();
            $stmt_check->bind_result($count);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($count > 0) {
                echo "This product is already listed for this order. Please edit the existing item instead.";
            } else {
                $sql = "INSERT INTO orderitem (order_id, product_id, quantity, subtotal)
                        VALUES (?, ?, ?, ?)";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $subtotal);
                    if($stmt->execute()){
                        echo "Order Item added successfully";
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
        } else {
            echo "Error preparing duplicate check statement: " . $conn->error;
        }
    }
}
$conn->close();
?>
</body>
</html>
