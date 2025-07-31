<?php include '../includes/db.php'; ?>
<link rel="stylesheet" href="../css/style.css">
<h2>Products</h2>
<a href="create.php">Add New Product</a>
<table>
<tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Category</th><th>Stock</th><th>Actions</th></tr>
<?php
$result = $conn->query("SELECT * FROM Product");
while($row = $result->fetch_assoc()){
    echo "<tr><td>".$row['product_id']."</td><td>".$row['product_name']."</td><td>".$row['description']."</td><td>".$row['price']."</td><td>".$row['category']."</td><td>".$row['stock']."</td>
    <td><a href='update.php?id=".$row['product_id']."'>Edit</a> | 
    <a href='delete.php?id=".$row['product_id']."'>Delete</a></td></tr>";
}
?>
</table>
<a href='../index.php'>Back to Home</a>