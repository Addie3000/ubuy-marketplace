<?php
session_start();
require '../includes/db.php';

//admin access only
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin', 'moderator'])) {
    header("Location: ../login.php");
    exit();}

//getting statistics
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
$stmt->execute();
$total_users = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM products");
$stmt->execute();
$total_listings = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders");
$stmt->execute();
$total_orders = $stmt->fetchColumn();
?>

<!--html doc-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>


<section id="admin-section">
    <div class="container">

        <div class="admin-header">
            <h2><i class="bi bi-shield-check"></i> Admin Dashboard</h2>
            <p>Logged in as: <span class="account-badge"><?php echo ucfirst($_SESSION['role']); ?></span></p>
        </div>

        <!-- Statistics section-->
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <i class="bi bi-people"></i>
                    <div>
                        <h4><?php echo $total_users; ?></h4>
                        <p>Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <i class="bi bi-tags"></i>
                    <div>
                        <h4><?php echo $total_listings; ?></h4>
                        <p>Total Listings</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <i class="bi bi-bag-check"></i>
                    <div>
                        <h4><?php echo $total_orders; ?></h4>
                        <p>Total Orders</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Links section -->
        <h5 class="dash-section-title">Admin Actions</h5>
        <div class="row g-3">

            <div class="col-6 col-md-3">
                <a href="users.php" class="dash-card">
                    <i class="bi bi-people"></i>
                    <p>Manage Users</p>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="listings.php" class="dash-card">
                    <i class="bi bi-tags"></i>
                    <p>Manage Listings</p>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="orders.php" class="dash-card">
                    <i class="bi bi-bag"></i>
                    <p>Manage Orders</p>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="../includes/logout.php" class="dash-card logout-card">
                    <i class="bi bi-box-arrow-right"></i>
                    <p>Logout</p>
                </a>
            </div>

        </div>
    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../assets/main.js"></script>

</body>
</html>