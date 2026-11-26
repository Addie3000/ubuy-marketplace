<?php
session_start();
require 'includes/db.php';

//Access for logged in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();}

if ($_SESSION['account_type'] != 'seller') {
    header("Location: dashboard.php");
    exit();}

//Getting categories
$stmt = $pdo->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!--html doc-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBUY - Post Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<!--Post listing section-->
<section id="post-listing-section">
    <div class="container">
        <div class="post-box">

            <div class="post-header">
                <i class="bi bi-plus-circle"></i>
                <h2>Post New Listing</h2>
                <p>Fill in the details of your item</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="form-error" style="text-align:center; margin-bottom:15px;">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form action="includes/post_listing_action.php" method="POST" enctype="multipart/form-data">

                <!-- filling Title -->
                <div class="form-group">
                    <label>Item Title</label>
                    <div class="input-wrap">
                        <i class="bi bi-tag"></i>
                        <input type="text" name="title" placeholder="e.g. Black Mens T-Shirt" required maxlength="100">
                    </div>
                </div>

                <!-- choosing Category -->
                <div class="form-group">
                    <label>Category</label>
                    <div class="input-wrap">
                        <i class="bi bi-grid"></i>
                        <select name="category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- setting Price -->
                <div class="form-group">
                    <label>Price (R)</label>
                    <div class="input-wrap">
                        <i class="bi bi-cash"></i>
                        <input type="number" name="price" placeholder="e.g. 150.00" required min="1" step="0.01">
                    </div>
                </div>

                <!-- writing Description -->
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="desc-input" placeholder="Describe your item..." required maxlength="500"></textarea>
                </div>

                <!-- uploading Image -->
                <div class="form-group">
                    <label>Product Image</label>
                    <div class="input-wrap">
                        <i class="bi bi-image"></i>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-circle"></i> Post Listing
                </button>

                <p class="login-link">
                    <a href="dashboard.php">Cancel</a>
                </p>

            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/main.js"></script>
</body>
</html>