<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Phone Number</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
$phone_no = $_GET['phone_no'] ?? null;

if ($phone_no) {
    $sql = "DELETE FROM phone WHERE phone_no=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $phone_no);
        if($stmt->execute()){
            echo "Phone Number deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No Phone Number provided for deletion.";
}
$conn->close();
?>
<br><a href='read.php'>Back to Phone Numbers</a>
</body>
</html>
