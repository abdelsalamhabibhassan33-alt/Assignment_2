<?php
require_once 'db_connection.php';


if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    $conn->exec("TRUNCATE TABLE orders");
    $conn->exec("TRUNCATE TABLE suppliers");
    
    header("Location: Dashboard.php?msg=DataCleared");
    exit();
}
?>
<h2>Are you sure you want to clear all data?</h2>
<a href="clear_data.php?confirm=true" style="color:red;">Yes, clear everything</a> | 
<a href="Dashboard.php">Cancel</a>