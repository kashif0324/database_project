<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Add Review</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Add Review</h2>
<form method="POST">
    <label for="user_id">User:</label>
    <select name="user_id" id="user_id" required>
        <option value="">Select User</option>
        <?php
        $users_result = $conn->query("SELECT user_id, first_name, last_name FROM user ORDER BY first_name ASC");
        if ($users_result && $users_result->num_rows > 0) {
            while ($user = $users_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($user['user_id']) . "'>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . " (ID: " . htmlspecialchars($user['user_id']) . ")</option>";
            }
        } else {
            echo "<option value=''>No users found</option>";
        }
        ?>
    </select><br>

    <label for="product_id">Product:</label>
    <select name="product_id" id="product_id" required>
        <option value="">Select Product</option>
        <?php
        $products_result = $conn->query("SELECT product_id, product_name FROM product ORDER BY product_name ASC");
        if ($products_result && $products_result->num_rows > 0) {
            while ($product = $products_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($product['product_id']) . "'>" . htmlspecialchars($product['product_name'] . ' (ID: ' . $product['product_id'] . ')') . "</option>";
            }
        } else {
            echo "<option value=''>No products found</option>";
        }
        ?>
    </select><br>

    <label for="rating">Rating (1-5):</label>
    <input type="number" name="rating" id="rating" placeholder="Rating (1-5)" min="1" max="5" required><br>

    <label for="comment">Comment:</label>
    <textarea name="comment" id="comment" placeholder="Your review comment"></textarea><br>

    <button type="submit" name="submit">Add Review</button>
</form>
<a href='read.php'>View Reviews</a>
<?php
if(isset($_POST['submit'])){
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Basic validation
    if (empty($user_id) || empty($product_id) || empty($rating)) {
        echo "User, Product, and Rating are required.";
    } else if (!is_numeric($user_id) || !is_numeric($product_id) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
        echo "Invalid input for User ID, Product ID, or Rating.";
    } else {
        $sql = "INSERT INTO review (user_id, product_id, rating, comment)
                VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iiis", $user_id, $product_id, $rating, $comment);
            if($stmt->execute()){
                echo "Review added successfully";
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
