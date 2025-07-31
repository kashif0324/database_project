<?php include '../includes/db.php'; $id=$_GET['id']; ?>
<link rel="stylesheet" href="../css/style.css">
<h2>Update Product</h2>
<form method="POST">
    <input type="text" name="product_name" placeholder="Product Name" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br>
    <input type="text" name="category" placeholder="Category"><br>
    <input type="number" name="stock" placeholder="Stock" required><br>
    <button type="submit" name="submit">Update</button>
</form>
<?php
if(isset($_POST['submit'])){
    $sql = "UPDATE Product SET product_name='{$_POST['product_name']}', description='{$_POST['description']}', price='{$_POST['price']}', category='{$_POST['category']}', stock='{$_POST['stock']}' WHERE product_id=$id";
    if($conn->query($sql)){ echo "Product updated successfully"; } else { echo "Error: " . $conn->error; }
}
?>
<a href='./read.php'>Back to Product</a>