<?php
include './db/connection.php';

if (isset($_POST['insert'])) {
    $img = $_FILES["image"]["name"];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_image = image($img);
    $product_stock = $_POST['stock'];
    $insert_cart = mysqli_query($conn, "INSERT INTO `product`(`name`, `price`, `image`, `stock`) VALUES ('$product_name','$product_price','$product_image','$product_stock')") or die('query failed');
    header('location: admin.php');
}
if (isset($_POST['update'])) {
    $img = $_FILES["image"]["name"];
    $id = $_POST['id'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_image = image($img);
    $product_stock = $_POST['stock'];

    $update_cart = mysqli_query($conn, "UPDATE `product` SET `name`='$product_name',`price`='$product_price',`image`='$product_image',`stock`='$product_stock' WHERE product_id = '$id'") or die('query failed');
    header('location: admin.php');
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete_cart = mysqli_query($conn, "DELETE FROM `product` WHERE product_id = '$id'") or die('query failed');
    header('location: admin.php');
}

function image($img)
{
    $valid_extensions = array('jpeg', 'jpg', 'png');
    $path = './assets/';
    $post_image = null;
    $tmp = $_FILES["image"]["tmp_name"];
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $final_image = rand(1000, 1000000) . $img;
    if (in_array($ext, $valid_extensions)) {
        $path = $path . strtolower($final_image);
        if (move_uploaded_file($tmp, $path)) {
            $post_image = $final_image;
        }
    }
    return $post_image;
}

?>