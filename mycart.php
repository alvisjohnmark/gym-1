<?php
session_start();

include("./db/connection.php");
include("./db/functions.php");
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: ./forms/login.php');
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
    header('location:mycart.php');
  }
  
  if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:mycart.php');
  }
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>My cart</title>
</head>

<body>
    <nav class="navbar">
        <div class="logo"><a class="logo" href="./index.php">GYM RATS</a></div>
        <ul class="nav-links">
            <input type="checkbox" id="checkbox_toggle" />
            <label for="checkbox_toggle" class="hamburger">&#9776;</label>
            <div class="menu">
                <li><a href="./cart.php">Pre-order</a></li>
            </div>
        </ul>
    </nav>

    <div class="container">
        <div class="shopping-cart">
            <div class="note">
                <h1 style="text-align:center; color:white;">Note: Pick-up your product in our physical store</h1>
                <h1 style="text-align:center; color:white;">Shop location: Laoag City/Puregold/2nd Floor</h1>
            </div>
            <br><br>
            <h1 class="heading">My orders</h1>

            <table>
                <thead style="background-color:#79031d">
                    <th>image</th>
                    <th>name</th>
                    <th>product price</th>
                    <th>quantity</th>
                    <th>total:</th>
                    <th>Remove/Delete</th>
                </thead>
                <tbody>
                    <?php
                $cart_query = mysqli_query($conn, "SELECT * FROM cart inner join product on cart.product_id = product.product_id WHERE cart.user_id = '$user_id'") or die('query failed');
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
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?> ">
                                <input type="number" min="1" max="<?php echo $fetch_cart['stock'] ?>"
                                    name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit" name="update_cart" value="update" class="option-btn">
                            </form>
                        </td>
                        <td>₱
                            <?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
                        </td>
                        <td><a href="./mycart.php ? remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn"
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
                        <td><a href="mycart.php ? delete_all" onclick="return confirm('delete all from cart?');"
                                class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">delete all</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>