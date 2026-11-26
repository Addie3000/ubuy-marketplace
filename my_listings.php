<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['account_type'] != 'seller') {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Deleting listing
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM orders WHERE product_id = ?");
    $stmt->execute([$delete_id]);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
    $stmt->execute([$delete_id, $user_id]);
    header("Location: my_listings.php");
    exit();
}

$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name 
                       FROM products p
                       JOIN categories c ON p.category_id = c.id
                       WHERE p.seller_id = ?
                       ORDER BY p.created_at DESC");
$stmt->execute([$user_id]);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings - UBUY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<section id="my-listings-section">
    <div class="container">

        <a href="dashboard.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>

        <div class="listings-top">
            <h2 class="section-title" style="margin:0;">My Listings</h2>
            <a href="post_listing.php" class="btn-primary-custom">
                <i class="bi bi-plus-circle"></i> Post New Listing
            </a>
        </div>

        <?php if (count($listings) > 0): ?>
            <div class="row g-4">
                <?php foreach ($listings as $listing): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card">
                            <img src="uploads/products/<?php echo htmlspecialchars($listing['image']); ?>"
                                 alt="<?php echo htmlspecialchars($listing['title']); ?>"
                                 onerror="this.src='assets/images/placeholder.jpg'">
                            <div class="product-info">
                                <span class="product-category"><?php echo htmlspecialchars($listing['category_name']); ?></span>
                                <h6><?php echo htmlspecialchars($listing['title']); ?></h6>
                                <span class="product-price">R <?php echo number_format($listing['price'], 2); ?></span>
                            </div>
                            <div class="product-footer">
                                <a href="product.php?id=<?php echo $listing['id']; ?>">View</a>
                            </div>
                            <div class="listing-actions">
                                <a href="my_listings.php?delete=<?php echo $listing['id']; ?>"
                                   class="delete-btn"
                                   onclick="return confirm('Are you sure you want to delete this listing?')">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="no-results">
                <i class="bi bi-tags"></i>
                <h5>No listings yet</h5>
                <p>Post your first item for sale</p>
                <a href="post_listing.php" class="btn-primary-custom">Post Listing</a>
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