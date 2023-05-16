<?php
include './db/connection.php';
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

</head>

<body>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Add Product
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./product.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="insert">
                    <div class="modal-body insert">
                        <br>
                        <label for="img">Select image:</label>
                        <input type="file" id="img-upload" name="image" accept="image/*" onchange="loadFile(event)">
                        <br>
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" required>
                        <br>
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" required>
                        <br>
                        <label for="price">Stock:</label>
                        <input type="number" name="stock" id="stock" required>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" id="showModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="./product.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update">
                    <div class="modal-body update">
                        <input type="hidden" id='id' name="id" value="0">
                        <div class="preview">
                            <img width="100px" height="100px" id="preview" src="#" alt="item-image">
                        </div>
                        <br>
                        <label for="img">Select image:</label>
                        <input type="file" id="img-upload" name="image" accept="image/*" onchange="loadFile(event)">
                        <br>
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" required>
                        <br>
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" required>
                        <br>
                        <label for="price">Stock:</label>
                        <input type="number" name="stock" id="stock" required>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Save changes" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="box-container">

        <?php
        $select_product = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
        if (mysqli_num_rows($select_product) > 0) {
            while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                <div class="product" id=<?php echo $fetch_product['id'] ?>>
                    <button class="delete-btn" onclick="deleteProduct(this)">Delete</button>
                    <img data-bs-toggle="modal" data-bs-target="#showModal" onclick="showProduct(this)" width="100px"
                        height="100px" src="./assets/<?php echo $fetch_product['image']; ?>" alt="">
                    <div class="name">
                        <?php echo $fetch_product['name']; ?>
                    </div>
                    <div class="price"> <span>&#8369;</span>
                        <?php echo $fetch_product['price']; ?>
                    </div>
                    <input type="hidden" id="prod-img" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    <input type="hidden" id="prod-name" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" id="prod-price" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="hidden" id="prod-stock" name="product_stock" value="<?php echo $fetch_product['stock']; ?>">
                </div>

                <?php
            }
            ;
        }
        ;
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var loadFile = function (event) {
            var preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);

            console.log((event.target.files[0]));

            preview.onload = function () {
                URL.revokeObjectURL(preview.src) // free memory
            }
        };

        var loadFile = function (event) {
            var preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);

            console.log((event.target.files[0]));

            preview.onload = function () {
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
            let data = { id: id, delete: "" };

            $.ajax({
                url: "./product.php",
                type: "post",
                data: data,
                success: function (response) {

                    location.reload()
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });

        }


    </script>
</body>

</html>