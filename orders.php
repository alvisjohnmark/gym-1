<?php
include './db/connection.php';
session_start();
$user_id = $_SESSION['user_id'];
$query = "Select * from cart";
$query1 = "Select * from user";
$result = mysqli_query($conn, $query);
$result1 = mysqli_query($conn, $query1);


if (isset($_GET['remove'])) {

    $id = $_GET['remove'];
    $myString = $_GET['remove'];
    $myArray = explode(',', $myString);
    $cart = (int) $myArray[0];
    $qnty = (int) $myArray[1];
    $product_id = (int) $myArray[2];
    print_r($cart);
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$cart'") or die('query failed');
    mysqli_query($conn, "UPDATE `product` SET `stock`= stock - '$qnty'  WHERE product_id = '$product_id'") or die('query failed');
    header('location:orders.php');
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
    header('location:orders.php');
  }
  

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>
    <!-- Button trigger modal -->
    <button type="button" class="btn">
        <a class="home-btn" href="./forms/login.php">Logout</a>
    </button>
    <button class="btn">
        <a class="home-btn" href="./admin.php">Admin</a>
    </button>

    <div class="container">
        <div class="shopping-cart">
            <h1 class="heading">Orders</h1>
            <table>
                <thead style="background-color:#79031d; border: 2px solid white;">
                    <th>User id</th>
                    <th>image</th>
                    <th>Product name</th>
                    <th>quantity</th>
                    <th>price</th>
                    <th>Paid</th>
                    <th>Cancel order</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                    <tr>
                        <td>
                            <?php echo $row['user_id'] ; ?>
                        </td>
                        <td><img src="./assets/<?php echo $row['image']; ?>" height="100" alt=""></td>
                        <td>
                            <?php echo $row['name']; ?>
                        </td>
                        <td>
                            <?php echo $row['quantity']; ?>
                        </td>
                        <td>₱
                            <?php echo $sub_total = ($row['price'] * $row['quantity']); ?>
                        </td>
                        <td><a href="./orders.php?remove=<?php echo $row['id']; ?>,<?php echo $row['quantity']; ?>,<?php echo $row['product_id']; ?>"
                                class="delete-btn" onclick="return confirm('are you sure?');">Paid</a></td>
                        </td>
                        <td><a href="./orders.php ? remove=<?php echo $row['id']; ?>" class="delete-btn"
                                onclick="return confirm('remove item from cart?');">Cancel</a></td>
                        </td>
                    </tr>
                    <?php
                        $grand_total += $sub_total;
                    }
                    ?>
                    <tr class=" table-bottom">
                        <td colspan="4">Total Sales:</td>
                        <td>Php
                            <?php echo $grand_total; ?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
    var loadFile = function(event) {
        var preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);

        console.log((event.target.files[0]));

        preview.onload = function() {
            URL.revokeObjectURL(preview.src) // free memory
        }
    };

    var loadFile = function(event) {
        var preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);

        console.log((event.target.files[0]));

        preview.onload = function() {
            URL.revokeObjectURL(preview.src) // free memory
        }
    };

    function showProduct(el) {
        const id = $(el).parents('.product').attr("id")
        const img = $(el).parents('.product').find("#prod-img").val()
        const name = $(el).parents('.product').find("#prod-name").val()
        const price = $(el).parents('.product').find("#prod-price").val()
        const stock = $(el).parents('.product').find("#prod-stock").val()

        $('#preview').attr("src", `./assets/${img}`)
        $('.update #name').val(name)
        $('.update #price').val(parseInt(price))
        $('.update #stock').val(parseInt(stock))
        $('.update #id').val(parseInt(id))
    }

    function confirmation() {

    }

    function deleteProduct(el) {
        const id = parseInt($(el).parents('.product').attr("id"));
        let data = {
            id: id,
            delete: ""
        };

        $.ajax({
            url: "./product.php",
            type: "post",
            data: data,
            success: function(response) {

                location.reload()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }
    </script>
</body>

</html>