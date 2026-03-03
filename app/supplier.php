<?php
require_once 'db_connection.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO suppliers (name, phone) VALUES (?, ?)");
    $stmt->execute([$_POST["name"], $_POST["phone"]]);
    $message = "Supplier added successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Supplier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h1>Register Supplier</h1>
    <nav> |
    <a href="../public/index.html">Home</a> |
    <a href="../app/Dashboard.php">Dashboard</a> |
    <a href="../app/supplier.php">Register Supplier</a> |
    <a href="../app/order.php">Create Order</a> |
    <a href="../app/view_orders.php">View Orders</a>
</nav>
</header>


<main>

    <form action="#" method="POST">

        <label for="name">Supplier Name</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="phone">Phone Number</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <button type="submit">Save Supplier</button>

    </form>

</main>

<footer>
    <p>&copy; 2026 Musanze Market Order System</p>
</footer>

</body>
</html>