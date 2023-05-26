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
  $message[] = 'cart quantity updated successfully!';
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
      mysqli_query($conn, "UPDATE `product` SET `stock`= stock - '$product_quantity'  WHERE id = '$product_id'") or die('query failed');
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

    <div class="container">
        <div class="homepage">
            <h1><a href="./index.php">Home</a></h1>
        </div>

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
                    <h2 class="name">Quantity <input type="number" min="1" name="product_quantity" value="1"></h2>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_product['product_id']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="submit" value="Pre-order" name="add_to_cart" class="btn">
                </form>
                <?php
          };
        };
        ?>

            </div>

        </div>

        <div class="shopping-cart">

            <h1 class="heading">Cart</h1>

            <table>
                <thead style="background-color:#79031d">
                    <th>image</th>
                    <th>name</th>
                    <th>price</th>
                    <th>quantity</th>
                    <th>total price</th>
                    <th>Remove/Delete</th>
                </thead>
                <tbody>
                    <?php
          $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
          $grand_total = 0;
          if (mysqli_num_rows($cart_query) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
          ?>
                    <tr>
                        <td><img src="./assets/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                        <td>
                            <?php echo $fetch_cart['name']; ?>
                        </td>
                        <td>₱
                            <?php echo $fetch_cart['price']; ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" min="1" name="cart_quantity"
                                    value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit" name="update_cart" value="update" class="option-btn">
                            </form>
                        </td>
                        <td>₱
                            <?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
                        </td>
                        <td><a href="./cart.php ? remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn"
                                onclick="return confirm('remove item from cart?');">remove</a></td>
                    </tr>
                    <?php
              $grand_total += $sub_total;
            }
          } else {
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
          }
          ?>
                    <tr class="table-bottom">
                        <td colspan="4">Total :</td>
                        <td>Php
                            <?php echo $grand_total; ?>
                        </td>
                        <td><a href="cart.php ? delete_all" onclick="return confirm('delete all from cart?');"
                                class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">delete all</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>