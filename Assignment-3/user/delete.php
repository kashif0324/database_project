<?php include '../includes/db.php'; $id=$_GET['id'];
$sql = "DELETE FROM User WHERE user_id=$id";
if($conn->query($sql)){ echo "User deleted successfully"; } else { echo "Error: " . $conn->error; }
?>
<a href='./read.php'>Back to Usre Dashboard</a>