<?php session_start();
require 'includes/db.php';

//getting recent listings to display on home page
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name, u.full_name AS seller_name
                       FROM products p
                       JOIN categories c ON p.category_id = c.id
                       JOIN users u ON p.seller_id = u.id
                       WHERE p.status = 'active'
                       ORDER BY p.created_at DESC
                       LIMIT 4");
$stmt->execute();
$recent_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!--html doc-->

<!DOCTYPE html>
<html lang="en">
    <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">

         <title>UBUY Marketplace</title>
         <!--Bootstrap CSS-->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
         <!--Bootstrap icons-->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
         <!--css sheet-->
         <link rel="stylesheet" href="assets/style.css">

    </head>
    <body>
          <!--navbar-->
         <?php include 'includes/navbar.php'; ?>

          <!--Hero section-->

          <section id="hero">
            <div class="container">
                <div class="hero-content">
                  <h1>Buy & Sell Locally</h1>
                  <p>South Africa's trusted Marketplace for informal traders and sellers</p>  
                  <div class="hero-buttons">
                    <a href="register.php" class="btn-primary-custom">
                        <i class="bi bi-person-plus-fill"></i> Start Selling
                    </a>
                    <a href="listings.php" class="btn-secondary-custom">
                        <i class="bi bi-grid-fill"></i> Browse Listings
                    </a>
                  </div>
                </div>
            </div>
          </section>

          <!--Categories-->
          <section id="categories">
            <div class="container">
                <h2 class="section-title">Browse by Category</h2>
                <div class="row g-3 justify-content-center">
                    <div class="col-6 col-md-2">
                        <a href="listings.php?category=clothing" class="category-link">
                            <div class="category-card">
                                <i class="bi bi-bag-fill"></i>
                                <p>Clothing</p>
                            </div>
                        </a>
                    </div>
                

                    <div class="col-6 col-md-2">
                        <a href="listings.php?category=electronics" class="category-link">
                            <div class="category-card">
                                <i class="bi bi-phone-fill"></i>
                                <p>Electronics</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-2">
                        <a href="listings.php?category=food" class="category-link">
                            <div class="category-card">
                                <i class="bi bi-basket-fill"></i>
                                <p>Food</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-2">
                        <a href="listings.php?category=furniture" class="category-link">
                            <div class="category-card">
                                <i class="bi bi-house-fill"></i>
                                <p>furniture</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-2">
                        <a href="listings.php?category=services" class="category-link">
                            <div class="category-card">
                                <i class="bi bi-tools"></i>
                                <p>Services</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-2">
                        <a href="listings.php?category=other" class="category-link">
                            <div class="category-card">
                                <i class="bi bi-three-dots"></i>
                                <p>Other</p>
                            </div>
                        </a>
                    </div>

                </div>

            </div>

         </section>

         <!--recent listings section-->
         <section id="listings">
            <div class="container">
                <h2 class="section-title">Recent Listings</h2>
                <div class="row g-4">

                    <?php if (count($recent_products) > 0): ?>
                        <?php foreach ($recent_products as $product): ?>
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
            <?php else: ?>
                <div class="col-12">
                    <p style="text-align:center; color:#777;">No listings yet. Be the first to post one!</p>
                </div>
            <?php endif; ?>

        </div>

        <div class="text-center mt-4">
            <a href="listings.php" class="btn-view-all">View All Listings</a>
        </div>
    </div>
</section>


         <!-- About Us -->
        <section id="About-us">
            <div class="container">
                <h2 class="section-title">Why Choose UBUY Marketplace?</h2>
                <div class="row g-4">

                    <div class="col-12 col-md-4">
                        <div class="feature-card">
                            <i class="bi bi-shield-check"></i>
                            <h5>Verified Sellers</h5>
                            <p>Every seller is verified with a badge so you know who you are buying from</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="feature-card">
                            <i class="bi bi-lock"></i>
                            <h5>Secure Payments</h5>
                            <p>Safe payments protect both buyers and sellers from fraud</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="feature-card">
                            <i class="bi bi-truck"></i>
                            <h5>Local Delivery</h5>
                            <p>Delivery options that reach townships and non-urban areas</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--Footer section-->
        <?php include 'includes/footer.php'; ?>

        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!--jquery-->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!--javascript file-->
        <script src="assets/main.js"></script>

    </body>
</html>