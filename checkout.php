<?php
session_start();
require 'includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: cart.php");
    exit();
}

$cart  = $_SESSION['cart'];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
$delivery = 50;
$grandtotal = $total + $delivery;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - UBUY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<section id="checkout-section">
    <div class="container">

        <h2 class="section-title">Checkout</h2>

        <div class="row g-4">

            <!-- Checkout Form -->
            <div class="col-12 col-md-7">
                <div class="checkout-box">

                    <h5><i class="bi bi-truck"></i> Delivery Details</h5>
                    <hr>

                    <form action="includes/checkout_action.php" method="POST">

                        <div class="form-group">
                            <label>Full Name</label>
                            <div class="input-wrap">
                                <i class="bi bi-person"></i>
                                <input type="text" name="full_name" placeholder="Enter full name" required
                                       value="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Street Address</label>
                            <div class="input-wrap">
                                <i class="bi bi-house"></i>
                                <input type="text" name="address" placeholder="Enter street address" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>City</label>
                            <div class="input-wrap">
                                <i class="bi bi-geo-alt"></i>
                                <input type="text" name="city" placeholder="Enter city" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Province</label>
                            <div class="input-wrap">
                                <i class="bi bi-map"></i>
                                <select name="province" required>
                                    <option value="" disabled selected>Select province</option>
                                    <option value="Eastern Cape">Eastern Cape</option>
                                    <option value="Free State">Free State</option>
                                    <option value="Gauteng">Gauteng</option>
                                    <option value="KwaZulu-Natal">KwaZulu-Natal</option>
                                    <option value="Limpopo">Limpopo</option>
                                    <option value="Mpumalanga">Mpumalanga</option>
                                    <option value="Northern Cape">Northern Cape</option>
                                    <option value="North West">North West</option>
                                    <option value="Western Cape">Western Cape</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <div class="input-wrap">
                                <i class="bi bi-telephone"></i>
                                <input type="tel" name="phone" placeholder="Enter phone number" required>
                            </div>
                        </div>

                        <h5 class="mt-4"><i class="bi bi-credit-card"></i> Payment Details</h5>
                        <hr>

                        <!--payment section -->
                        <div class="payment-notice">
                            <i class="bi bi-info-circle"></i>
                            <p>This is a mock payment for demonstration purposes only. No real payment will be processed.</p>
                        </div>

                        <div class="form-group">
                            <label>Card Number</label>
                            <div class="input-wrap">
                                <i class="bi bi-credit-card"></i>
                                <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <div class="input-wrap">
                                        <i class="bi bi-calendar"></i>
                                        <input type="text" name="expiry" placeholder="MM/YY" maxlength="5">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>CVV</label>
                                    <div class="input-wrap">
                                        <i class="bi bi-lock"></i>
                                        <input type="text" name="cvv" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check-circle"></i> Place Order — R <?php echo number_format($grandtotal, 2); ?>
                        </button>

                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-12 col-md-5">
                <div class="cart-summary">
                    <h5>Order Summary</h5>
                    <hr>
                    <?php foreach ($cart as $item): ?>
                        <div class="summary-row">
                            <span><?php echo htmlspecialchars($item['title']); ?> x<?php echo $item['quantity']; ?></span>
                            <span>R <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="summary-row">
                        <span>Delivery</span>
                        <span>R <?php echo number_format($delivery, 2); ?></span>
                    </div>
                    <hr>
                    <div class="summary-total">
                        <span>Total</span>
                        <span>R <?php echo number_format($grandtotal, 2); ?></span>
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