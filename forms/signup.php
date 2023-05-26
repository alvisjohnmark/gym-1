<?php

include '../db/connection.php';

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, ($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, ($_POST['cpassword']));

    $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass'") or die('failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'user already exist!';
    } else {
        mysqli_query($conn, "INSERT INTO `user`(name, email, password) VALUES('$name', '$email', '$pass')") or die('failed');
        $message[] = 'registered successfully!';
        header('location: login.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="../css/form.css">

</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
        }
    }
    ?>

    <div class="form-container">

        <form action="" method="post">
            <h3>Register</h3>
            <label for="name">Name</label>
            <input type="text" name="name" required class="box">
            <label for="email">Email</label>
            <input type="email" name="email" required class="box">
            <label for="password">Password</label>
            <input type="password" name="password" required class="box">
            <label for="cpassword">Confirm Password</label>
            <input type="password" name="cpassword" required class="box">
            <input type="submit" name="submit" class="btn" value="register">
            <p>already have an account? <a href="login.php">login here</a></p>
        </form>

    </div>

</body>

</html>