<?php include '../includes/db.php'; $id=$_GET['id']; ?>
<link rel="stylesheet" href="../css/style.css">
<h2>Update User</h2>
<form method="POST">
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="submit">Update</button>
</form>
<?php
if(isset($_POST['submit'])){
    $sql = "UPDATE User SET first_name='{$_POST['first_name']}', last_name='{$_POST['last_name']}', email='{$_POST['email']}', password='{$_POST['password']}' WHERE user_id=$id";
    if($conn->query($sql)){ echo "User updated successfully"; } else { echo "Error: " . $conn->error; }
}
?>
<a href='./read.php'>Back to User Dashboard</a>