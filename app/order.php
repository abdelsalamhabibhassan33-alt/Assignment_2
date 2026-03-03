<?php
require_once 'db_connection.php';

$stmt = $conn->query("SELECT id, name FROM suppliers");
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_id = $_POST['supplier'];
    $qty = $_POST['quantity'];
    $price = $_POST['unit_price'];
    $total = $qty * $price;
    $location = $_POST['pickup_location'];

    $stmt = $conn->prepare("INSERT INTO orders (supplier_id, quantity, unit_price, total, pickup_location) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$supplier_id, $qty, $price, $total, $location]);
    $message = "Order created successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order - Musanze Market</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
        <h2>Create New Order</h2>
        
        <?php if(isset($message)): ?>
            <p style="color: #6d1b3b; font-weight: bold; margin-bottom: 15px;"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="order.php" method="POST" id="orderForm">
            <div class="form-group">
                <label for="supplier">Select Supplier</label>
                <select name="supplier" id="supplier" required>
                    <option value="">-- Choose Supplier --</option>
                    <?php foreach($suppliers as $s): ?>
                        <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="pickup_location">Pickup Location</label>
                <input type="text" name="pickup_location" id="pickup_location" placeholder="e.g. Musanze Main Market" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" step="0.01" required oninput="calculateTotal()">
            </div>

            <div class="form-group">
                <label for="unit_price">Unit Price (RWF)</label>
                <input type="number" name="unit_price" id="unit_price" step="0.01" required oninput="calculateTotal()">
            </div>

            <div class="form-group">
                <label for="total">Total Amount (RWF)</label>
                <input type="text" name="total" id="total" readonly style="background: #eee !important; font-weight: bold;">
            </div>

            <button type="submit" class="btn-order" style="width: 100%; border: none; margin-top: 10px;">Submit Order</button>
        </form>
    </section>
</main>

<script>
function calculateTotal() {
    const qty = document.getElementById('quantity').value || 0;
    const price = document.getElementById('unit_price').value || 0;
    const total = qty * price;
    document.getElementById('total').value = total.toLocaleString() + " RWF";
}
</script>

<footer>
    <p>&copy; 2026 Musanze Market</p>
</footer>

</body>
</html>