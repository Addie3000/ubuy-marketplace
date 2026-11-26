<?php
session_start();
require 'includes/db.php';

//search and category filter
$search   = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

if ($search && $category) {
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name, u.full_name AS seller_name 
                           FROM products p 
                           JOIN categories c ON p.category_id = c.id 
                           JOIN users u ON p.seller_id = u.id 
                           WHERE p.status = 'active' 
                           AND p.title LIKE ? 
                           AND c.name = ?");
    $stmt->execute(["%$search%", $category]);}

elseif ($search) {
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name, u.full_name AS seller_name 
                           FROM products p 
                           JOIN categories c ON p.category_id = c.id 
                           JOIN users u ON p.seller_id = u.id 
                           WHERE p.status = 'active' 
                           AND p.title LIKE ?");
    $stmt->execute(["%$search%"]);}

elseif ($category) {
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name, u.full_name AS seller_name 
                           FROM products p 
                           JOIN categories c ON p.category_id = c.id 
                           JOIN users u ON p.seller_id = u.id 
                           WHERE p.status = 'active' 
                           AND c.name = ?");
    $stmt->execute([$category]);}

else {
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name, u.full_name AS seller_name 
                           FROM products p 
                           JOIN categories c ON p.category_id = c.id 
                           JOIN users u ON p.seller_id = u.id 
                           WHERE p.status = 'active' 
                           ORDER BY p.created_at DESC");
    $stmt->execute();}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - Browse Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<!--Header section-->
<section id="listings-header">
    <div class="container">
        <h2>Browse Listings</h2>
        <p>Find what you are looking for</p>
    </div>
</section>

<!--Filter Section-->
<section id="listings-filter">
    <div class="container">
        <form action="listings.php" method="GET" class="filter-form">

            <input type="text" name="q" placeholder="Search listings" value="<?php echo htmlspecialchars($search); ?>">

            <select name="category">
                <option value="">All Categories</option>
                <option value="Clothing" <?php if($category=='Clothing')echo 'selected'; ?>>Clothing</option>
                <option value="Electronics" <?php if($category=='Electronics') echo 'selected'; ?>>Electronics</option>
                <option value="Food" <?php if($category=='Food') echo 'selected'; ?>>Food</option>
                <option value="Furniture" <?php if($category=='Furniture') echo 'selected'; ?>>Furniture</option>
                <option value="Services" <?php if($category=='Services') echo 'selected'; ?>>Services</option>
                <option value="Other" <?php if($category=='Other') echo 'selected'; ?>>Other</option>
            </select>

            <button type="submit">
                <i class="bi bi-search"></i> Search
            </button>

            <?php if ($search || $category): ?>
                <a href="listings.php" class="clear-filter">Clear</a>
            <?php endif; ?>

        </form>
    </div>
</section>

<!--Listing grid-->
<section id="listings-grid">
    <div class="container">

        <?php if (count($products) > 0): ?>
            <p class="results-count"><?php echo count($products); ?> listings found</p>
            <div class="row g-4">
                <?php foreach ($products as $product): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card">
                            <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['title']); ?>"
                                 onerror="this.src='assets/images/placeholder.jpg'">
                            <div class="product-info">
                                <span class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                                <h6><?php echo htmlspecialchars($product['title']); ?></h6>
                                <p>Seller: <?php echo htmlspecialchars($product['seller_name']); ?></p>
                                <span class="product-price">R <?php echo number_format($product['price'], 2); ?></span>
                            </div>
                            <div class="product-footer">
                                <a href="product.php?id=<?php echo $product['id']; ?>">View Listing</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="no-results">
                <i class="bi bi-search"></i>
                <h5>No listings found</h5>
                <p>Try a different category</p>
                <a href="listings.php" class="btn-primary-custom">View All Listings</a>
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
