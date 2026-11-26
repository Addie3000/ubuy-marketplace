<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $buyer_id = $_SESSION['user_id'];
    $cart     = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    if (count($cart) == 0) {
        header("Location: ../cart.php");
        exit();
    }

    // Saving each cart item as an order
    foreach ($cart as $item) {

        // Getting seller ID from product
        $stmt = $pdo->prepare("SELECT seller_id, price FROM products WHERE id = ?");
        $stmt->execute([$item['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $total_price = $product['price'] * $item['quantity'];

            $stmt = $pdo->prepare("INSERT INTO orders 
                (buyer_id, seller_id, product_id, total_price, status) 
                VALUES (?, ?, ?, ?, 'pending')");

            $stmt->execute([
                $buyer_id,
                $product['seller_id'],
                $item['id'],
                $total_price
            ]);
        }
    }

    // Clearing the cart
    unset($_SESSION['cart']);

    // Redirecting to confirmation
    header("Location: ../order_confirmation.php");
    exit();
}
?>