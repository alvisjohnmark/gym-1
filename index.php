<?php
session_start();

include("./db/connection.php");
include("./db/functions.php");

// $user_data = check_login($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<title>Home</title>
</head>

<body>
    <nav class="navbar">

        <div class="logo">GYM RATS</div>
        <ul class="nav-links">
            <input type="checkbox" id="checkbox_toggle" />
            <label for="checkbox_toggle" class="hamburger">&#9776;</label>
            <div class="menu">
                <li><a href="/about/about.html">ABOUT</a></li>
                <li><a href="./forms/login.php">LOG-IN</a></li>
                <li><a href="./forms/login.php">LOG-OUT</a></li>
                <li><a href="./cart.php">ADD-TO-CART</a></li>
                <li><a href="./admin.php">ADMIN</a></li>
            </div>

        </ul>

    </nav>
    <section class="hero-section">
        <div class="content">
            <h1>HIGH PROTEIN SUPLEMENTS AT YOUR SERVICE</h1>
            <p>QUALITY SUPLEMENTS MADE WITH REAL INGREDIENTS</p>
            <button><a href="./cart.php">Buy now!</a></button>
        </div>
    </section>

    <section class="products">
        <div class="container">
            <h2>Products:</h2>
            <div class="cards">
                <div class="card">
                    <img src="./assets/d1.jpg">
                    <h4>Chocolate Protein Shake</h4>
                </div>
                <div class="card">
                    <img src="./assets/d2.jpg">
                    <h4>Mango Protein Shake</h4>
                </div>
                <div class="card">
                    <img src="./assets/d3.jpg">
                    <h4>Strawberry Protein Shake</h4>
                </div>
                <div class="card">
                    <img src="./assets/d4.jpg">
                    <h4>Cinnamon Protein Shake</h4>
                </div>
                <div class="card">
                    <img src="./assets/whey1.jpg">
                    <h4>White Chocolate Whey</h4>
                </div>
                <div class=" card">
                    <img src="./assets/whey2.jpg">
                    <h4>Milk Chocolate Whey</h4>
                </div>
                <div class="card">
                    <img src="./assets/whey3.jpg">
                    <h4>Unflavored Whey</h4>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer-container">
            <div class="socials">
                <ul>
                    <li><a href="#" class="links">Facebook<i class="fa fa-facebook-f"></i></a></li>
                    <li><a href="#" class="links">Instagram<i class="fa fa-instagram"></i></a></li>
                    <li><a href="#" class="links">Twitter<i class="fa fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>