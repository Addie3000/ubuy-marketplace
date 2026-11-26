<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin', 'moderator'])) {
    header("Location: ../login.php");
    exit();}

//deleting listings
if (isset($_GET['delete']) && in_array($_SESSION['role'], ['admin', 'superadmin'])){
    $delete_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM orders WHERE product_id = ?");
    $stmt->execute([$delete_id]);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: listings.php");
    exit();
}
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name, u.full_name AS seller_name
                       FROM products p
                       JOIN categories c ON p.category_id = c.id
                       JOIN users u ON p.seller_id = u.id
                       ORDER BY p.created_at DESC");
$stmt->execute();
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!--html doc-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - Manage Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>



<section id="admin-section">
    <div class="container">

        <a href="index.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Admin Panel
        </a>

        <div class="admin-header">
            <h2><i class="bi bi-tags"></i> Manage Listings</h2>
        </div>

        <div class="admin-table-box">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Seller</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listings as $listing): ?>
                        <tr>
                            <td><?php echo $listing['id']; ?></td>
                            <td><?php echo htmlspecialchars($listing['title']); ?></td>
                            <td><?php echo htmlspecialchars($listing['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($listing['seller_name']); ?></td>
                            <td>R <?php echo number_format($listing['price'], 2); ?></td>
                            <td><span class="account-badge"><?php echo ucfirst($listing['status']); ?></span></td>
                            <td>
                                <?php if (in_array($_SESSION['role'], ['admin', 'superadmin'])): ?>
                                    <a href="listings.php?delete=<?php echo $listing['id']; ?>"
                                       class="delete-btn"
                                       onclick="return confirm('Delete this listing?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                <?php else: ?>
                                    <span style="color:#aaa; font-size:0.85rem;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../assets/main.js"></script>

</body>
</html>