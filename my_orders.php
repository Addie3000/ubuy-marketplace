<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT o.*, p.title, p.image, u.full_name AS seller_name 
                       FROM orders o
                       JOIN products p ON o.product_id = p.id
                       JOIN users u ON o.seller_id = u.id
                       WHERE o.buyer_id = ?
                       ORDER BY o.created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<section id="orders-section">
    <div class="container">

        <a href="dashboard.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>

        <h2 class="section-title">My Orders</h2>

        <?php if (count($orders) > 0): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <img src="uploads/products/<?php echo htmlspecialchars($order['image']); ?>"
                         alt="<?php echo htmlspecialchars($order['title']); ?>"
                         onerror="this.src='assets/images/placeholder.jpg'">
                    <div class="order-info">
                        <h6><?php echo htmlspecialchars($order['title']); ?></h6>
                        <p>Seller: <?php echo htmlspecialchars($order['seller_name']); ?></p>
                        <p>Total: <strong>R <?php echo number_format($order['total_price'], 2); ?></strong></p>
                        <p>Date: <?php echo date('d M Y', strtotime($order['created_at'])); ?></p>
                    </div>
                    <span class="order-status status-<?php echo $order['status']; ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </span>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="no-results">
                <i class="bi bi-bag-x"></i>
                <h5>No orders yet</h5>
                <p>Browse listings and place your first order</p>
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