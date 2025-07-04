<?php
include 'db_connection.php';
include 'header.php';

// Function to get invoice report
function getInvoiceReport($conn, $start_date, $end_date) {
    $sql = "SELECT i.invoice_no, i.date, i.customer, i.item_count, i.amount
            FROM invoice i
            WHERE i.date BETWEEN ? AND ?
            ORDER BY i.date DESC";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get invoice item report
function getInvoiceItemReport($conn, $start_date, $end_date) {
    $sql = "SELECT i.invoice_no, i.date, i.customer, im.item_id, im.quantity, im.unit_price
            FROM invoice i
            JOIN invoice_master im ON i.invoice_no = im.invoice_no
            WHERE i.date BETWEEN ? AND ?
            ORDER BY i.date DESC, i.invoice_no";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get item report
function getItemReport($conn) {
    $sql = "SELECT DISTINCT im.item_id, SUM(im.quantity) as total_quantity
            FROM invoice_master im
            GROUP BY im.item_id
            ORDER BY im.item_id";
    
    return $conn->query($sql);
}

$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');

$invoice_report = null;
$invoice_item_report = null;
$item_report = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['invoice_report'])) {
        $invoice_report = getInvoiceReport($conn, $start_date, $end_date);
    } elseif (isset($_POST['invoice_item_report'])) {
        $invoice_item_report = getInvoiceItemReport($conn, $start_date, $end_date);
    }
}

$item_report = getItemReport($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Reports</h1>

    <h2>Invoice Report</h2>
    <form method="post" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
        <button type="submit" name="invoice_report">Generate Invoice Report</button>
    </form>

    <?php if ($invoice_report): ?>
    <table>
        <tr>
            <th>Invoice Number</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Item Count</th>
            <th>Invoice Amount</th>
        </tr>
        <?php while ($row = $invoice_report->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['invoice_no']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['customer']; ?></td>
            <td><?php echo $row['item_count']; ?></td>
            <td><?php echo number_format($row['amount'], 2); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>

    <h2>Invoice Item Report</h2>
    <form method="post" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
        <button type="submit" name="invoice_item_report">Generate Invoice Item Report</button>
    </form>

    <?php if ($invoice_item_report): ?>
    <table>
        <tr>
            <th>Invoice Number</th>
            <th>Invoiced Date</th>
            <th>Customer</th>
            <th>Item ID</th>
            <th>Quantity</th>
            <th>Unit Price</th>
        </tr>
        <?php while ($row = $invoice_item_report->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['invoice_no']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['customer']; ?></td>
            <td><?php echo $row['item_id']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['unit_price'], 2); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>

    <h2>Item Report</h2>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Total Quantity</th>
        </tr>
        <?php while ($row = $item_report->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['item_id']; ?></td>
            <td><?php echo $row['total_quantity']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>