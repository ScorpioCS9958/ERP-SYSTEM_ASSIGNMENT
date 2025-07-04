<?php
include 'db_connection.php';
include 'header.php';

// Function to validate form data
function validate_customer_form($data) {
    $errors = [];
    if (empty($data['title'])) $errors[] = "Title is required";
    if (empty($data['first_name'])) $errors[] = "First name is required";
    if (empty($data['last_name'])) $errors[] = "Last name is required";
    if (empty($data['contact_no']) || !preg_match("/^[0-9]{10}$/", $data['contact_no'])) $errors[] = "Valid contact number is required";
    if (empty($data['district'])) $errors[] = "District is required";
    return $errors;
}

// Insert or update customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_customer']) || isset($_POST['update_customer']))) {
    $errors = validate_customer_form($_POST);
    if (empty($errors)) {
        if (isset($_POST['update_customer'])) {
            $sql = "UPDATE customer SET title=?, first_name=?, middle_name=?, last_name=?, contact_no=?, district=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $_POST['title'], $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['contact_no'], $_POST['district'], $_POST['id']);
        } else {
            $sql = "INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $_POST['title'], $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['contact_no'], $_POST['district']);
        }
        $stmt->execute();
        $stmt->close();
    }
}

// Delete customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_customer'])) {
    $sql = "DELETE FROM customer WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $stmt->close();
}

// Fetch customers
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

// Fetch districts for dropdown
$district_sql = "SELECT * FROM district WHERE active='yes'";
$district_result = $conn->query($district_sql);

// Initialize variables for form fields
$id = $title = $first_name = $middle_name = $last_name = $contact_no = $district = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_customer'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district = $_POST['district'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Customer Management</h1>
    
    <!-- Customer Form -->
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <select name="title" required>
            <option value="">Select Title</option>
            <option value="Mr" <?php if ($title == 'Mr') echo 'selected'; ?>>Mr</option>
            <option value="Mrs" <?php if ($title == 'Mrs') echo 'selected'; ?>>Mrs</option>
            <option value="Miss" <?php if ($title == 'Miss') echo 'selected'; ?>>Miss</option>
            <option value="Dr" <?php if ($title == 'Dr') echo 'selected'; ?>>Dr</option>
        </select>
        <input type="text" name="first_name" placeholder="First Name" value="<?php echo $first_name; ?>" required>
        <input type="text" name="middle_name" placeholder="Middle Name" value="<?php echo $middle_name; ?>">
        <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>" required>
        <input type="text" name="contact_no" placeholder="Contact Number" value="<?php echo $contact_no; ?>" required>
        <select name="district" required>
            <option value="">Select District</option>
            <?php while($district_row = $district_result->fetch_assoc()): ?>
                <option value="<?php echo $district_row['id']; ?>" <?php if ($district == $district_row['id']) echo 'selected'; ?>><?php echo $district_row['district']; ?></option>
            <?php endwhile; ?>
        </select>
        <?php if ($id): ?>
            <button type="submit" name="update_customer">Update Customer</button>
        <?php else: ?>
            <button type="submit" name="add_customer">Add Customer</button>
        <?php endif; ?>
    </form>

    <!-- Customer List -->
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Contact No</th>
            <th>District</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['middle_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['contact_no']; ?></td>
                <td><?php echo $row['district']; ?></td>
                <td>
                    <form method="post" action="" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="title" value="<?php echo $row['title']; ?>">
                        <input type="hidden" name="first_name" value="<?php echo $row['first_name']; ?>">
                        <input type="hidden" name="middle_name" value="<?php echo $row['middle_name']; ?>">
                        <input type="hidden" name="last_name" value="<?php echo $row['last_name']; ?>">
                        <input type="hidden" name="contact_no" value="<?php echo $row['contact_no']; ?>">
                        <input type="hidden" name="district" value="<?php echo $row['district']; ?>">
                        <button type="submit" name="edit_customer" class="btn btn-success">Update</button>
                    </form>
                    <form method="post" action="" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_customer">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
