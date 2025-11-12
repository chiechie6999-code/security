<?php session_start(); ?>
<header>
    <div class="prospect-name">CCMart</div>
    <nav>
        <ul>
            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                echo '<li><a href="index.php">Home</a></li>';
                echo '<li><a href="logout.php">Log-out</a></li>';
            } else {
                if ($currentPage == 'login.php') {
                    echo '<li><a href="index.php">Home</a></li>';
                    echo '<li><a href="register.php">Register</a></li>';
                } elseif ($currentPage == 'register.php') {
                    echo '<li><a href="index.php">Home</a></li>';
                    echo '<li><a href="login.php">Log-in</a></li>';
                } else {
                    echo '<li><a href="index.php">Home</a></li>';
                    echo '<li><a href="register.php">Register</a></li>';
                    echo '<li><a href="login.php">Log-in</a></li>';
                }
            }
            ?>
        </ul>
    </nav>
</header>
