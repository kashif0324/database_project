<?php include '../includes/db.php'; ?>
<link rel="stylesheet" href="../css/style.css">
<h2>Add Product</h2>
<form method="POST">
    <input type="text" name="product_name" placeholder="Product Name" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br>
    <input type="text" name="category" placeholder="Category"><br>
    <input type="number" name="stock" placeholder="Stock" required><br>
    <button type="submit" name="submit">Add Product</button>
</form>
<?php
if(isset($_POST['submit'])){
    $sql = "INSERT INTO Product (product_name, description, price, category, stock) 
            VALUES ('{$_POST['product_name']}', '{$_POST['description']}', '{$_POST['price']}', '{$_POST['category']}', '{$_POST['stock']}')";
    if($conn->query($sql)){ echo "Product added successfully"; } else { echo "Error: " . $conn->error; }
}
?>
<a href='./read.php'>Back to Product</a>