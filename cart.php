<?php
session_start();
require 'includes/db.php';

//adding item to cart
if (isset($_GET['add'])) {
    $product_id = $_GET['add'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'title'=> $product['title'],
                'price' => $product['price'],
                'image'=> $product['image'],
                'quantity'=> 1
            ];
        }
    }
    header("Location: cart.php");
    exit();}

//removing item from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    header("Location: cart.php");
    exit();
}

//getting cart items
$cart  = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!--html doc-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<section id="cart-section">
    <div class="container">

        <h2 class="section-title">My Cart</h2>

        <?php if (count($cart) > 0): ?>

            <div class="row g-4">

                <!-- Cart Items -->
                <div class="col-12 col-md-8">
                    <?php foreach ($cart as $item): ?>
                        <div class="cart-item">
                            <img src="uploads/products/<?php echo htmlspecialchars($item['image']); ?>"
                                 alt="<?php echo htmlspecialchars($item['title']); ?>"
                                 onerror="this.src='assets/images/placeholder.jpg'">
                            <div class="cart-item-info">
                                <h6><?php echo htmlspecialchars($item['title']); ?></h6>
                                <p>R <?php echo number_format($item['price'], 2); ?> each</p>
                                <p>Quantity: <?php echo $item['quantity']; ?></p>
                                <p class="cart-item-subtotal">
                                    Subtotal: R <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                </p>
                            </div>
                            <a href="cart.php?remove=<?php echo $item['id']; ?>" class="cart-remove">
                                <i class="bi bi-trash"></i> Remove
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!--order summary-->
                <div class="col-12 col-md-4">
                    <div class="cart-summary">
                        <h5>Order Summary</h5>
                        <hr>
                        <div class="summary-row">
                            <span>Items (<?php echo count($cart); ?>)</span>
                            <span>R <?php echo number_format($total, 2); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery</span>
                            <span>R 50.00</span>
                        </div>
                        <hr>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>R <?php echo number_format($total + 50, 2); ?></span>
                        </div>
                        <a href="checkout.php" class="btn-submit" style="display:block; text-align:center; margin-top:16px;">
                            <i class="bi bi-credit-card"></i> Proceed to Checkout
                        </a>
                        <a href="listings.php" class="continue-shopping">
                            <i class="bi bi-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>

            </div>

        <?php else: ?>
            <div class="no-results">
                <i class="bi bi-cart-x"></i>
                <h5>Your cart is empty</h5>
                <p>Browse listings and add items to your cart</p>
                <a href="listings.php" class="btn-primary-custom">Browse Listings</a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/main.js"></script>
</body>
</html>