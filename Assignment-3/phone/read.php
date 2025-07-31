<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Phone Numbers</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Phone Numbers</h2>
<a href="create.php">Add New Phone Number</a>
<table>
<tr><th>Phone Number</th><th>User ID</th><th>Actions</th></tr>
<?php

$sql = "SELECT phone_no, user_id
        FROM phone
        ORDER BY phone_no ASC"; 

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['phone_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>"; 
        echo "<td><a href='update.php?phone_no=" . htmlspecialchars($row['phone_no']) . "'>Edit</a> | ";
        echo "<a href='delete.php?phone_no=" . htmlspecialchars($row['phone_no']) . "' onclick=\"return confirm('Are you sure you want to delete this phone number?');\">Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No phone numbers found.</td></tr>";
}
$conn->close();
?>
</table>
<a href='../index.php'>Back to Home</a>
</body>
</html>
