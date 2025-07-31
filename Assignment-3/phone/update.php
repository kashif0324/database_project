<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Update Phone Number</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Update Phone Number</h2>
<?php
$original_phone_no = $_GET['phone_no'] ?? null;
$current_user_id = '';
$current_phone_no = '';
$user_display_text = '';

if ($original_phone_no) {
    // Fetch current phone data
    $sql_select = "SELECT p.phone_no, u.user_id, u.first_name, u.last_name
                   FROM phone p
                   JOIN user u ON p.user_id = u.user_id
                   WHERE p.phone_no = ?";
    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("s", $original_phone_no);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        if ($result_select->num_rows == 1) {
            $row = $result_select->fetch_assoc();
            $current_phone_no = $row['phone_no'];
            $current_user_id = $row['user_id'];
            $user_display_text = htmlspecialchars($row['first_name'] . ' ' . $row['last_name'] . ' (ID: ' . $row['user_id'] . ')');
        } else {
            echo "Phone Number not found.";
            $original_phone_no = null; 
        }
        $stmt_select->close();
    } else {
        echo "Error preparing select statement: " . $conn->error;
    }
}

if(isset($_POST['submit']) && $original_phone_no){
    $new_phone_no = $_POST['phone_no'];

    
    if (empty($new_phone_no)) {
        echo "Phone Number is required.";
    } else {
        
        $sql_check_duplicate = "SELECT phone_no FROM phone WHERE phone_no = ? AND phone_no != ?";
        if ($stmt_check = $conn->prepare($sql_check_duplicate)) {
            $stmt_check->bind_param("ss", $new_phone_no, $original_phone_no);
            $stmt_check->execute();
            $stmt_check->store_result();
            if ($stmt_check->num_rows > 0) {
                echo "This phone number is already registered.";
            }
            
        }

        if ($stmt_check->num_rows == 0) { // Only proceed if no duplicate
            $sql_update = "UPDATE phone SET phone_no=? WHERE phone_no=?";
            if ($stmt_update = $conn->prepare($sql_update)) {
                $stmt_update->bind_param("ss", $new_phone_no, $original_phone_no);
                if($stmt_update->execute()){
                    echo "Phone Number updated successfully";
                    // Optional: Redirect after successful update, using the new phone_no
                    // header("Location: read.php");
                    // exit();
                } else {
                    echo "Error: " . $stmt_update->error;
                }
                $stmt_update->close();
            } else {
                echo "Error preparing update statement: " . $conn->error;
            }
        }
    }
}

// Display form only if original_phone_no is valid
if ($original_phone_no):
?>
<form method="POST">
    <label for="user_display">Associated User:</label>
    <input type="text" id="user_display" value="<?php echo htmlspecialchars($user_display_text); ?>" disabled><br>
    <small>User cannot be changed for an existing phone number.</small><br>

    <label for="phone_no">Phone Number:</label>
    <input type="text" name="phone_no" id="phone_no" value="<?php echo htmlspecialchars($current_phone_no); ?>" placeholder="e.g., +1-555-123-4567 or 03001234567" required><br>

    <button type="submit" name="submit">Update Phone Number</button>
</form>
<?php endif; ?>
<a href='read.php'>View Phone Numbers</a>
<?php $conn->close(); ?>
</body>
</html>
