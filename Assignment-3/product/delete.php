<?php include '../includes/db.php'; $id=$_GET['id'];
$sql = "DELETE FROM Product WHERE product_id=$id";
if($conn->query($sql)){ echo "Product deleted successfully"; } else { echo "Error: " . $conn->error; }
?>
<a href='./read.php'>Back to Product</a>