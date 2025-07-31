<?php include '../includes/db.php'; ?>
<link rel="stylesheet" href="../css/style.css">
<h2>Add User </h2>
<form method="POST">
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="submit">Add User</button>
</form>

<?php
if(isset($_POST['submit'])){
    $sql = "INSERT INTO User (first_name, last_name, email, password) 
            VALUES ('{$_POST['first_name']}', '{$_POST['last_name']}', '{$_POST['email']}', '{$_POST['password']}')";
    if($conn->query($sql)){ echo "User added successfully"; } else { echo "Error: " . $conn->error; }
}
?>
<a href='./read.php'>Back to User Dashboard</a>