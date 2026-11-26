<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<section id="confirm-section">
    <div class="container">
        <div class="confirm-box">
            <i class="bi bi-check-circle-fill"></i>
            <h2>Order Placed Successfully</h2>
            <p>Thank you for your purchase. Your order has been received and is being processed.</p>
            <div class="confirm-buttons">
                <a href="my_orders.php" class="btn-primary-custom">View My Orders</a>
                <a href="listings.php" class="btn-secondary-custom">Continue Shopping</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/main.js"></script>

</body>
</html>