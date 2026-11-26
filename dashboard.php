<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION["full_name"];
$account_type = $_SESSION["account_type"];
$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE buyer_id = ?");
$stmt->execute([$user_id]);
$order_count = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE seller_id=?");
$stmt->execute([$user_id]);
$listings_count=$stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY-Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">

</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <!--welcome section-->
    <section id="dashboard">
        <div class="container">
            <div class="dash-welcome">
                <div>
                    <h2>Welcome back, <?php echo htmlspecialchars($full_name);?>!</h2>
                    <p>Account type: <span class="account-badge"><?php echo ucfirst($account_type);?></span></p>
                </div>
            
            </div>

            <!--statistics section-->
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-bag-check"></i>
                        <div>
                            <h4><?php echo $order_count; ?></h4>
                            <p>Total Orders</p>
                        </div>
                    </div>
                </div>

                <?php if($account_type == 'seller'):?>
                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-tags"></i>
                            <div>
                                <h4><?php echo $listings_count;?></h4>
                                <p>My Listings</p>
                            </div>
                        </div>

                    </div>
                <?php endif; ?>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <h4>Active</h4>
                                <p>Account Status</p>
                            </div>
                        </div>
                    </div>
            </div>

            <!--Links section-->
            <h5 class="dash-section-title">Quick Actions</h5>
            <div class="row g-3">

            <div class="col-6 col-md-3">
                <a href="listings.php" class="dash-card">
                    <i class="bi bi-grid"></i>
                    <p>Browse Listings</p>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="cart.php" class="dash-card">
                    <i class="bi bi-cart4"></i>
                    <p>My Cart</p>
                </a>
            </div>

            <?php if ($account_type == 'seller'): ?>
            <div class="col-6 col-md-3">
                <a href="post_listing.php" class="dash-card">
                    <i class="bi bi-plus-square"></i>
                    <p>Post Listing</p>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="my_listings.php" class="dash-card">
                    <i class="bi bi-tags"></i>
                    <p>My Listings</p>
                </a>
            </div>
            <?php endif; ?>

            <div class="col-6 col-md-3">
                <a href="my_orders.php" class="dash-card">
                    <i class="bi bi-bag"></i>
                    <p>My Orders</p>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="includes/logout.php" class="dash-card logout-card">
                    <i class="bi bi-box-arrow-right"></i>
                    <p>Logout</p>
                </a>
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

