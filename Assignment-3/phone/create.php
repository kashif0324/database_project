<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Add Phone Number</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Add Phone Number</h2>
<form method="POST">
    <label for="user_id">User:</label>
    <select name="user_id" id="user_id" required>
        <option value="">Select User</option>
        <?php
        $users_result = $conn->query("SELECT user_id, first_name, last_name FROM user ORDER BY first_name ASC");
        if ($users_result && $users_result->num_rows > 0) {
            while ($user = $users_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($user['user_id']) . "'>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . " (ID: " . htmlspecialchars($user['user_id']) . ")</option>";
            }
        } else {
            echo "<option value=''>No users found</option>";
        }
        ?>
    </select><br>

    <label for="phone_no">Phone Number:</label>
    <input type="text" name="phone_no" id="phone_no" placeholder="e.g., +1-555-123-4567 or 03001234567" required><br>

    <button type="submit" name="submit">Add Phone Number</button>
</form>
<a href='read.php'>View Phone Numbers</a>
<?php
if(isset($_POST['submit'])){
    $user_id = $_POST['user_id'];
    $phone_no = $_POST['phone_no'];

    // Basic validation
    if (empty($user_id) || empty($phone_no)) {
        echo "User and Phone Number are required.";
    } else if (!is_numeric($user_id)) {
        echo "Invalid User ID.";
    } else {
        // Check if phone number already exists
        $sql_check = "SELECT phone_no FROM phone WHERE phone_no = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $phone_no);
            $stmt_check->execute();
            $stmt_check->store_result();
            if ($stmt_check->num_rows > 0) {
                echo "This phone number is already registered.";
            }
            $stmt_check->close();
        }

        if ($stmt_check->num_rows == 0) { // Only proceed if no duplicate
            $sql = "INSERT INTO phone (user_id, phone_no)
                    VALUES (?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("is", $user_id, $phone_no);
                if($stmt->execute()){
                    echo "Phone Number added successfully";
                    // Optional: Redirect after successful insertion
                    // header("Location: read.php");
                    // exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        }
    }
}
$conn->close();
?>
</body>
</html>
