 <!--navbar-->
            <nav class="navbar navbar-expand-lg sticky-top" id="mainNav">
                <div class="container">
                    <a class="navbar-brand" href="index.php">
                        <i class="bi bi-shop"></i> UBUY
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <form class="search-form" action="listings.php" method="GET">
                        <input type="search" name="q" placeholder="Search listings">
                        <button type="submit">
                            <i class="bi bi-search"></i>
                        </button> 
                        </form>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="listings.php">Browse</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">
                                <i class="bi bi-cart4"></i> cart
                                <span class="cart-badge">0</span>
                            </a>
                        </li>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">
                                    <i class="bi bi-person-circle"></i>
                                    <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn-login" href="includes/logout.php">Logout</a>
                            </li>
                        <?php else: ?>

                        <li class="nav-item"><a class="btn-login" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="btn-register" href="register.php">Register</a></li>

                        <?php endif; ?>

                    </ul>
                    
                    
                    </div>
                
                </div>
            </nav>