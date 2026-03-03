<?php
date_default_timezone_set('Africa/Kigali');
require_once 'db_connection.php';

if (isset($_GET['action']) && $_GET['action'] == 'clear_confirmed') {
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
    $conn->exec("TRUNCATE TABLE orders");
    $conn->exec("TRUNCATE TABLE suppliers");
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");
    header("Location: Dashboard.php?msg=success");
    exit();
}

$date_today = date('Y-m-d');
$stmt = $conn->prepare("SELECT COUNT(*) as total_count, SUM(total) as total_sum FROM orders WHERE DATE(created_at) = ?");
$stmt->execute([$date_today]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt_recent = $conn->query("SELECT orders.*, suppliers.name as s_name FROM orders LEFT JOIN suppliers ON orders.supplier_id = suppliers.id ORDER BY created_at DESC LIMIT 5");
$recent_orders = $stmt_recent->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Musanze Market</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        function confirmClear() {
            if (confirm("Are you sure you want to delete ALL records?")) {
                window.location.href = "Dashboard.php?action=clear_confirmed";
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
    <h2>Dashboard</h2>

    <?php if(isset($_GET['msg'])): ?>
        <div style="background: #6d1b3b; color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
            Database cleared!
        </div>
    <?php endif; ?>

    <section>
        <h3>Today's Statistics</h3>
        <p><strong>Orders:</strong> <span><?php echo $stats['total_count'] ?? 0; ?></span></p>
        <p><strong>Total Value:</strong> <span><?php echo number_format($stats['total_sum'] ?? 0, 0); ?> RWF</span></p>
    </section>

    <section>
        <h3>Recent Activity</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recent_orders as $order): ?>
                    <tr>
                        <td><?php echo date('H:i', strtotime($order['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($order['s_name'] ?? 'N/A'); ?></td>
                        <td><?php echo number_format($order['total'], 0); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <div style="text-align: center; margin-top: 20px;">
        <button onclick="confirmClear()" style="background: #4a1a2c !important;">Clear Database</button>
    </div>
</main>

<footer>
    <p>&copy; 2026 Musanze Market</p>
</footer>

</body>
</html>