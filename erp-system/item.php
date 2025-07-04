<?php
include 'db_connection.php';
include 'header.php';

// Function to validate form data
function validate_item_form($data) {
    $errors = [];
    if (empty($data['item_code'])) $errors[] = "Item code is required";
    if (empty($data['item_category'])) $errors[] = "Item category is required";
    if (empty($data['item_subcategory'])) $errors[] = "Item subcategory is required";
    if (empty($data['item_name'])) $errors[] = "Item name is required";
    if (empty($data['quantity']) || !is_numeric($data['quantity'])) $errors[] = "Valid quantity is required";
    if (empty($data['unit_price']) || !is_numeric($data['unit_price'])) $errors[] = "Valid unit price is required";
    return $errors;
}

// Insert item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $errors = validate_item_form($_POST);
    if (empty($errors)) {
        $sql = "INSERT INTO item (item_code, item_category, item_subcategory, item_name, quantity, unit_price) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdd", $_POST['item_code'], $_POST['item_category'], $_POST['item_subcategory'], $_POST['item_name'], $_POST['quantity'], $_POST['unit_price']);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Update item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_item'])) {
    $errors = validate_item_form($_POST);
    if (empty($errors)) {
        $sql = "UPDATE item SET item_code=?, item_category=?, item_subcategory=?, item_name=?, quantity=?, unit_price=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssddi", $_POST['item_code'], $_POST['item_category'], $_POST['item_subcategory'], $_POST['item_name'], $_POST['quantity'], $_POST['unit_price'], $_POST['id']);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Delete item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_item'])) {
    $sql = "DELETE FROM item WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch items
$sql = "SELECT * FROM item";
$result = $conn->query($sql);

// Fetch categories for dropdown
$category_sql = "SELECT * FROM item_category";
$category_result = $conn->query($category_sql);

// Fetch subcategories for dropdown
$subcategory_sql = "SELECT * FROM item_subcategory";
$subcategory_result = $conn->query($subcategory_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Item Management</h1>
    
    <!-- Item Form -->
    <form method="post" action="">
        <input type="hidden" name="id" id="item_id">
        <input type="text" name="item_code" id="item_code" placeholder="Item Code" required>
        <select name="item_category" id="item_category" required>
            <option value="">Select Category</option>
            <?php 
            $category_result->data_seek(0);
            while($category = $category_result->fetch_assoc()): 
            ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
            <?php endwhile; ?>
        </select>
        <select name="item_subcategory" id="item_subcategory" required>
            <option value="">Select Subcategory</option>
            <?php 
            $subcategory_result->data_seek(0);
            while($subcategory = $subcategory_result->fetch_assoc()): 
            ?>
                <option value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['sub_category']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="text" name="item_name" id="item_name" placeholder="Item Name" required>
        <input type="number" name="quantity" id="quantity" placeholder="Quantity" required>
        <input type="number" step="0.01" name="unit_price" id="unit_price" placeholder="Unit Price" required>
        <button type="submit" name="add_item" id="submit_button">Add Item</button>
    </form>

    <!-- Item List -->
    <table>
        <tr>
            <th>ID</th>
            <th>Item Code</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['item_code']; ?></td>
                <td><?php echo $row['item_category']; ?></td>
                <td><?php echo $row['item_subcategory']; ?></td>
                <td><?php echo $row['item_name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['unit_price']; ?></td>
                <td>
                    <button onclick="editItem(<?php echo htmlspecialchars(json_encode($row)); ?>)" class="btn btn-success">Update</button>
                    <form method="post" action="" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_item">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
    function editItem(item) {
        document.getElementById('item_id').value = item.id;
        document.getElementById('item_code').value = item.item_code;
        document.getElementById('item_category').value = item.item_category;
        document.getElementById('item_subcategory').value = item.item_subcategory;
        document.getElementById('item_name').value = item.item_name;
        document.getElementById('quantity').value = item.quantity;
        document.getElementById('unit_price').value = item.unit_price;
        document.getElementById('submit_button').name = 'update_item';
        document.getElementById('submit_button').textContent = 'Update Item';
    }
    </script>
</body>
</html>
