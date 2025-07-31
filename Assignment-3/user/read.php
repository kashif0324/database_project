<?php include '../includes/db.php'; ?>
<link rel="stylesheet" href="../css/style.css">
<h2>Users</h2>
<a href="create.php">Add New User</a>
<table>
<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Actions</th></tr>
<?php
$result = $conn->query("SELECT * FROM User");
while($row = $result->fetch_assoc()){
    echo "<tr><td>".$row['user_id']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$row['email']."</td>
    <td><a href='update.php?id=".$row['user_id']."'>Edit</a> | 
    <a href='delete.php?id=".$row['user_id']."'>Delete</a></td></tr>";
}
?>
</table>
<a href='../index.php'>Back to Home</a>