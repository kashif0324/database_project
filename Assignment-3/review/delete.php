<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Review</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM review WHERE review_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            echo "Review deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No Review ID provided for deletion.";
}
$conn->close();
?>
<br><a href='read.php'>Back to Reviews</a>
</body>
</html>
