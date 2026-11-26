<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - UBUY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!--Navigation Bar-->
    <?php include 'includes/navbar.php'; ?>

    <!--Register section-->
    <section id="register-section">
        <div class="container">
            <div class="register-box">
                <div class="register-header">
                    <!--error message from URL-->
                    <?php if (isset($_GET['error'])): ?>
                        <div class="form-error" style="text-align:center; margin-bottom:15px;">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>
                    <i class="bi bi-person-plus-fill"></i>
                    <h2>Create Account</h2>
                    <p>Join UBUY and start buying or selling today</p>                    
                </div>

                <!--Account type-->
                <form action="includes/register_action.php" method="POST" id="registerForm">
                    <div class="account-type">
                        <p>I want to:</p>
                        <div class="type-options">
                            <label class="type-card">
                                <input type="radio" name="account_type" value="buyer" checked>
                                <div class="type-content">
                                    <i class="bi bi-bag-check"></i>
                                    <span>Buy Items</span>
                                </div>
                            </label>
                            <label class="type-card">
                                <input type="radio" name="account_type" value="seller">
                                <div class="type-content">
                                    <i class="bi bi-shop"></i>
                                    <span>Sell Items</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!--Full name-->
                    <div class="form-group">
                        <label>Full Name</label>
                        <div class="input-wrap">
                            <i class="bi bi-person"></i>
                            <input type="text" name="full_name" placeholder="Enter you Full Name" required minlength="4" maxlength="30">
                            
                        </div>
                    </div>

                    <!--email-->
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>

                        </div>
                    </div>

                    <!--Phone number-->
                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="input-wrap">
                            <i class="bi bi-telephone"></i>
                            <input type="tel" name="phone" placeholder="Enter Cell phone number" required minlength="10">
                        </div>
                    </div>

                    <!--Province selection-->
                    <div class="form-group">
                        <label>Province</label>
                        <div class="input-wrap">
                            <i class="bi bi-geo-alt"></i>
                            <select name="Province" required>
                                <option value="" disabled selected>Select your province</option>
                                <option value="Eastern Cape">Eastern Cape</option>
                                <option value="Free State">Free State</option>
                                <option value="Guateng">Gauteng</option>
                                <option value="Kwazulu-Natal">Kwazulu-Natal</option>
                                <option value="Limpopo">Linmpopo</option>
                                <option value="Mpumalanga">Mpumalanga</option>
                                <option value="Northern Cape">Northern Cape</option>
                                <option value="North West">North West</option>
                                <option value="Western Cape">Western Cape</option>
                            </select>
                        </div>
                    </div>

                    <!--password-->
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="password" placeholder="Create a Password" required>
                            <i class="bi bi-eye toggle-password" id="togglePassword"></i>

                        </div>
                    </div>

                    <!--Password confirmation-->
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" name="confirm_password" id="confirmPassword" placeholder="Retype your password" required>
                            <i class="bi bi-eye toggle-password" id="toggleConfirm"></i>

                        </div>
                    </div>

                    <!--error message-->
                    <div id="formError" class="form-error"></div>

                    <!--submit-->
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i> Create Account
                    </button>
                    <p class="login-link">
                        Already have an account? <a href="login.php">Login Here</a>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <!--footer-->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/main.js"></script>

</body>