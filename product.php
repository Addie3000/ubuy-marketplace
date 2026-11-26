<?php
session_start();
require 'includes/db.php';

//getting product id
if (!isset($_GET['id'])) {
    header("Location: listings.php");
    exit();
}
$product_id = $_GET['id'];

//getting product details
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name, u.full_name AS seller_name, u.province AS seller_province
                       FROM products p
                       JOIN categories c ON p.category_id = c.id
                       JOIN users u ON p.seller_id = u.id
                       WHERE p.id = ? AND p.status = 'active'");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

//redirecting when product not found
if (!$product) {
    header("Location: listings.php");
    exit();}
?>

<!--html doc-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['title']); ?> - UBUY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<section id="product-section">
    <div class="container">

        <!-- redirecting link -->
        <a href="listings.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Listings
        </a>

        <div class="product-detail-box">
            <div class="row g-4">

                <!-- Product image -->
                <div class="col-12 col-md-6">
                    <div class="product-img-box">
                        <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>"
                             alt="<?php echo htmlspecialchars($product['title']); ?>"
                             onerror="this.src='assets/images/placeholder.jpg'">
                    </div>
                </div>

                <!-- Product info -->
                <div class="col-12 col-md-6">
                    <div class="product-detail-info">

                        <span class="product-category">
                            <?php echo htmlspecialchars($product['category_name']); ?>
                        </span>

                        <h2><?php echo htmlspecialchars($product['title']); ?></h2>

                        <p class="detail-price">
                            R <?php echo number_format($product['price'], 2); ?>
                        </p>

                        <div class="seller-info">
                            <i class="bi bi-person-circle"></i>
                            <div>
                                <p>Sold by <strong><?php echo htmlspecialchars($product['seller_name']); ?></strong></p>
                                <p><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($product['seller_province']); ?></p>
                            </div>
                        </div>

                        <div class="product-description">
                            <h6>Description</h6>
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>

                        <!-- Add to Cart -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn-submit" style="display:block; text-align:center;">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="btn-submit" style="display:block; text-align:center;">
                                <i class="bi bi-box-arrow-in-right"></i> Login to Buy
                            </a>
                        <?php endif; ?>

                        <p class="posted-date">
                            <i class="bi bi-clock"></i> Posted: <?php echo date('d M Y', strtotime($product['created_at'])); ?>
                        </p>

                    </div>
                </div>

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



