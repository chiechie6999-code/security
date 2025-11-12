<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCMart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="prospect-name">CCMart</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
                    <li><a href="php/logout.php">Log-out</a></li>
                <?php else: ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Log-in</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Welcome to CCMart</h1>
    </main>

    <footer>
        <p>&copy; 2024 CCMart. All rights reserved.</p>
    </footer>
</body>
</html>