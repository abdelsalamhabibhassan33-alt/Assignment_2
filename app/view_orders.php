<?php
date_default_timezone_set('Africa/Kigali');
require_once 'db_connection.php';

if (isset($_GET['action']) && $_GET['action'] == 'clear_confirmed') {
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
    $conn->exec("TRUNCATE TABLE orders");
    $conn->exec("TRUNCATE TABLE suppliers");
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");
    header("Location: view_orders.php?msg=success");
    exit();
}

$stmt = $conn->query("SELECT orders.*, suppliers.name as s_name FROM orders LEFT JOIN suppliers ON orders.supplier_id = suppliers.id ORDER BY created_at DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders - Musanze Market</title>
    <link rel="stylesheet" href="../market-app/assets/css/style.css">
    <script>
        function confirmClear() {
            if (confirm("Delete everything?")) {
                window.location.href = "view_orders.php?action=clear_confirmed";
            }
        }
    </script>
</head>
<body>

<header>
    <h1>Musanze Market</h1>
    <nav> |
    <a href="index.html">Home</a> |
    <a href="Dashboard.php">Dashboard</a> |
    <a href="supplier.php">Register Supplier</a> |
    <a href="order.php">Create Order</a> |
    <a href="view_orders.php">View Orders</a>
</nav>
</header>

<main>
    <section>
        <h2>Order History</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Location</th>
                        <th>Qty</th>
                        <th>Total (RWF)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?php echo date('M d, y', strtotime($order['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($order['s_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['pickup_location']); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><strong><?php echo number_format($order['total'], 0); ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <button onclick="confirmClear()" style="background: #4a1a2c !important; font-size: 0.8rem;">Clear All Records</button>
        </div>
    </section>
</main>

<footer>
    <p>&copy; 2026 Musanze Market</p>
</footer>

</body>
</html>