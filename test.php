<?php
$img = $_FILES["image"]["name"];
// echo $_FILES["image"]["name"];
// echo $_POST['update-image'];

if ($img == '' || empty($img)) {
    $img = $_POST['update-image'];
}

echo $img;



// echo $img;

// $valid_extensions = array('jpeg', 'jpg', 'png');
// $path = './assets/';
// $post_image = null;
// $tmp = $_FILES["image"]["tmp_name"];
// $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// $final_image = rand(1000, 1000000) . $img;
// if (in_array($ext, $valid_extensions)) {
//     $path = $path . strtolower($final_image);
//     if (move_uploaded_file($tmp, $path)) {
//         $post_image = $final_image;
//     }
// }
// echo $post_image;
?>