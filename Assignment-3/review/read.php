<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Reviews</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Reviews</h2>
<a href="create.php">Add New Review</a>
<table>
<tr><th>Review ID</th><th>User ID</th><th>Product ID</th><th>Rating</th><th>Comment</th><th>Actions</th></tr>
<?php
// SQL query to fetch all reviews
// Changed: Removed JOINs with user and product tables as only IDs are needed.
// Changed: ORDER BY r.review_id ASC for ascending order.
$sql = "SELECT review_id, user_id, product_id, rating, comment
        FROM review
        ORDER BY review_id ASC"; // Changed to ASC for ascending order

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['review_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>"; // Changed to display only user_id
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>"; // Changed to display only product_id
        echo "<td>" . htmlspecialchars($row['rating']) . "/5</td>";
        echo "<td>" . htmlspecialchars(substr($row['comment'], 0, 75)) . (strlen($row['comment']) > 75 ? '...' : '') . "</td>";
        echo "<td><a href='update.php?id=" . htmlspecialchars($row['review_id']) . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . htmlspecialchars($row['review_id']) . "' onclick=\"return confirm('Are you sure you want to delete this review?');\">Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No reviews found.</td></tr>";
}
$conn->close();
?>
</table>
<a href='../index.php'>Back to Home</a>
</body>
</html>
