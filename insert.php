<?php
<?php
include "config.php";

$full_name = $_POST['full_name'];
$age = $_POST['last_name'];


$stmt = $conn->prepare("INSERT INTO customers (full_name, last_name) VALUES (?,?)");
$stmt->execute([$first_name, $last_name]);

header("Location: customers.php");
?>