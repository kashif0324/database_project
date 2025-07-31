<?php
include '../includes/db.php';
$review_id = ''; 
$current_user_id = '';
$current_product_id = '';
$current_rating_for_form = ''; 
$current_comment_for_form = ''; 
$errors = [];

$users_result = $conn->query("SELECT user_id, first_name, last_name FROM user ORDER BY first_name ASC");
if (!$users_result) {
    die("Error fetching users: " . $conn->error);
}

$products_result = $conn->query("SELECT product_id, product_name FROM product ORDER BY product_name ASC");
if (!$products_result) {
    die("Error fetching products: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $review_id = trim($_GET["id"]);

    $sql_select = "SELECT user_id, product_id, rating, comment FROM review WHERE review_id = ?";
    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("i", $review_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        if ($result_select->num_rows == 1) {
            $row = $result_select->fetch_assoc();
            $current_user_id = $row['user_id'];
            $current_product_id = $row['product_id'];
            $current_rating_for_form = $row['rating'];
            $current_comment_for_form = $row['comment'];
        } else {
            echo "Review not found.";
            $review_id = null;
        }
        $stmt_select->close();
    } else {
        echo "Error preparing select statement for initial load: " . $conn->error;
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Get the review_id from the hidden input field
    $review_id = $_POST['review_id'] ?? null;
    $user_id = $_POST['user_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $comment = $_POST['comment'] ?? '';

    $current_user_id = $user_id;
    $current_product_id = $product_id;
    $current_rating_for_form = $rating;
    $current_comment_for_form = $comment;

   
    if (empty($user_id)) {
        $errors['user_id'] = "Please select a user.";
    } else if (!filter_var($user_id, FILTER_VALIDATE_INT)) {
        $errors['user_id'] = "Invalid User ID.";
    }

    if (empty($product_id)) {
        $errors['product_id'] = "Please select a product.";
    } else if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
        $errors['product_id'] = "Invalid Product ID.";
    }

    if (empty($rating)) {
        $errors['rating'] = "Please enter a rating.";
    } else if (!filter_var($rating, FILTER_VALIDATE_INT) || $rating < 1 || $rating > 5) {
        $errors['rating'] = "Rating must be an integer between 1 and 5.";
    }

   
    if (empty($errors)) {
        $sql_update = "UPDATE review SET user_id=?, product_id=?, rating=?, comment=? WHERE review_id=?";
        if ($stmt_update = $conn->prepare($sql_update)) {
            $stmt_update->bind_param("iiisi", $user_id, $product_id, $rating, $comment, $review_id);
            if($stmt_update->execute()){
                echo "Review updated successfully!";
                // Redirect to read.php after successful update
                header("Location: read.php");
                exit();
            } else {
                echo "Error updating review: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            echo "Error preparing update statement: " . $conn->error;
        }
    }
}

// Redirect if no ID is provided on initial load or if review_id is invalid
if (empty($review_id) && $_SERVER["REQUEST_METHOD"] == "GET") {
    header("location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Review</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Update Review</h2>
<form method="POST">
    <!-- Hidden field to pass the review ID for identification -->
    <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review_id); ?>">

    <label for="user_id">User:</label>
    <select name="user_id" id="user_id" required
            class="<?php echo isset($errors['user_id']) ? 'input-error' : ''; ?>">
        <option value="">Select User</option>
        <?php
        // Reset pointer for users_result to reuse it
        $users_result->data_seek(0);
        while ($user = $users_result->fetch_assoc()): ?>
            <option value="<?php echo htmlspecialchars($user['user_id']); ?>"
                <?php echo ($user['user_id'] == $current_user_id) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'] . ' (ID: ' . $user['user_id'] . ')'); ?>
            </option>
        <?php endwhile; ?>
    </select><br>
    <?php if (isset($errors['user_id'])): ?>
        <span class="error-message"><?php echo $errors['user_id']; ?></span><br>
    <?php endif; ?>

    <label for="product_id">Product:</label>
    <select name="product_id" id="product_id" required
            class="<?php echo isset($errors['product_id']) ? 'input-error' : ''; ?>">
        <option value="">Select Product</option>
        <?php
        // Reset pointer for products_result to reuse it
        $products_result->data_seek(0);
        while ($product = $products_result->fetch_assoc()): ?>
            <option value="<?php echo htmlspecialchars($product['product_id']); ?>"
                <?php echo ($product['product_id'] == $current_product_id) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($product['product_name'] . ' (ID: ' . $product['product_id'] . ')'); ?>
            </option>
        <?php endwhile; ?>
    </select><br>
    <?php if (isset($errors['product_id'])): ?>
        <span class="error-message"><?php echo $errors['product_id']; ?></span><br>
    <?php endif; ?>

    <label for="rating">Rating (1-5):</label>
    <input type="number" name="rating" id="rating"
           value="<?php echo htmlspecialchars($current_rating_for_form); ?>"
           placeholder="Rating (1-5)" min="1" max="5" required
           class="<?php echo isset($errors['rating']) ? 'input-error' : ''; ?>"><br>
    <?php if (isset($errors['rating'])): ?>
        <span class="error-message"><?php echo $errors['rating']; ?></span><br>
    <?php endif; ?>

    <label for="comment">Comment:</label>
    <textarea name="comment" id="comment" placeholder="Your review comment"
              class="<?php echo isset($errors['comment']) ? 'input-error' : ''; ?>"><?php echo htmlspecialchars($current_comment_for_form); ?></textarea><br>
    <?php if (isset($errors['comment'])): ?>
        <span class="error-message"><?php echo $errors['comment']; ?></span><br>
    <?php endif; ?>

    <button type="submit" name="submit">Update Review</button>
</form>
<a href='read.php'>View Reviews</a>
<?php $conn->close(); ?>
</body>
</html>
