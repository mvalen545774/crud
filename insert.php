<?php

require 'config.php';

if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $product = $_POST['product'];
    $amount = $_POST['amount'];

    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);

    $users_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO orders (users_id, product, amount) VALUES (?, ?, ?)");
    $stmt->execute([$users_id, $product, $amount]);

    header("Location: landing.php");

    echo "User and Order added succesfully";
    exit();
}
?>
