<?php

include './db/connection.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location: ./forms/login.php');
}


if (isset($_POST['add_to_cart'])) {

  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = $_POST['product_quantity'];

  $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

  if (mysqli_num_rows($select_cart) > 0) {
    $message[] = 'product already pre-ordered!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, name, price, image, quantity) VALUES('$user_id','$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
    $message[] = 'product pre-ordered!';
  }
}

if (isset($_POST['update_cart'])) {
  $update_quantity = $_POST['cart_quantity'];
  $update_id = $_POST['cart_id'];
  mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
  $message[] = 'cart quantity updated!';
}

if (isset($_GET['remove'])) {
  $remove_id = $_GET['remove'];
  mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
  header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
  mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
  header('location:cart.php');
}

if (isset($_GET['update_stock'])) {
  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
  if (mysqli_num_rows($cart_query) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
      $product_id = $fetch_cart['product_id'];
      $product_quantity = $fetch_cart['quantity'];
      print_r($product_id);
      mysqli_query($conn, "UPDATE `product` SET `stock`= stock - '$product_quantity'  WHERE product_id = '$product_id'") or die('query failed');
    }
  }
  header('location:cart.php?delete_all');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping Cart</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

    <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
    }
  }
  ?>
    <nav class="navbar">
        <div class="logo"><a class="logo" href="./index.php">GYM RATS</a></div>
        <ul class="nav-links">
            <input type="checkbox" id="checkbox_toggle" />
            <label for="checkbox_toggle" class="hamburger">&#9776;</label>
            <div class="menu">
                <li><a href="./about/about.php">ABOUT</a></li>
                <li><a href="./forms/<?php echo isset($_SESSION['user_id']) ? "logout" : "login" ?>.php">
                        <?php echo (isset($_SESSION['user_id'])) ? "LOG-OUT" : "LOG-IN" ?>
                    </a></li>
                <li><a href="./cart.php">Pre-order</a></li>
                <li><a href="./mycart.php">My orders</a></li>
            </div>
        </ul>
    </nav>
    <div class="container">
        <div class="products">
            <h1 class="heading">Products</h1>
            <h2 class="heading1">Shop location: Laoag City/Puregold/2nd Floor</h2>
            <div class="box-container">

                <?php
        $select_product = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
        if (mysqli_num_rows($select_product) > 0) {
          while ($fetch_product = mysqli_fetch_assoc($select_product)) {
        ?>
                <form method="post" class="box" action="">
                    <img src="./assets/<?php echo $fetch_product['image']; ?>" alt="">
                    <div class="name" style="font-weight:bold;">
                        <?php echo $fetch_product['name']; ?>
                    </div>
                    <div class="price"> <span>&#8369;</span>
                        <?php echo $fetch_product['price']; ?>
                    </div>
                    <h2 class="name">Quantity <input type="number" min="1" max="<?php echo $fetch_product['stock'] ?>"
                            name="product_quantity" value="1"></h2>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_product['product_id']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="submit"
                        value="<?php echo $fetch_product['stock'] == 0 ? "Out of Stock" : "Pre-order" ?>"
                        name="add_to_cart" class="btn" <?php echo $fetch_product['stock'] == 0 ? "disabled" : "" ?>>
                </form>
                <?php
          };
        };
        ?>
            </div>
        </div>
    </div>
</body>

</html>