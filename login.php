<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UBUY - Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <?php include 'includes/navbar.php'; ?>

        <!-- Login section -->
        <section id="login-section">
            <div class="conatiner">
                <div class="login-box">

                <div class="login-header">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="form-error" style="text-align:center; margin-bottom:15px;">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <i class="bi bi-box-arrow-in-right"></i>
                    <h2>Welcome Back</h2>
                    <p>Login to your UBUY account</p>
                </div>
                <form action="includes/login_action.php" method="POST" id="loginForm">
                    
                    <!--Email-->
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>

                        </div>
                    </div>

                    <!--password-->
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="loginPassword" placeholder="Enter Your password" required>
                            <i class="bi bi-eye toggle-password" id="toggleLoginPassword"></i>

                        </div>
                    </div>

                    <!Error message>
                    <div id="loginError" class="form-error"></div>

                    <!--submit-->
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                    <p class="login-link">
                        Don't have an account? <a href="register.php">Register here</a>
                        
                    </p>

                </form>
                </div>
            </div>
        </section>
        <?php include 'includes/footer.php'; ?>

        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!--jquery-->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!--javascript file-->
        <script src="assets/main.js"></script>
    </body>
</html>