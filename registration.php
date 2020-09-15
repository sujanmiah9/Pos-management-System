<?php
require_once "./dbcon.php";
SESSION_start();
$email_error = "";
if (isset($_POST['registration'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $input_error = array();
    if (empty($name)) {
        $input_error['name'] = "The require field is empty!";
    }
    if (empty($email)) {
        $input_error['email'] = "The require field is empty!";
    }
    if (empty($username)) {
        $input_error['username'] = "The require field is empty!";
    }
    if (empty($password)) {
        $input_error['password'] = "The require field is empty!";
    }
    if (empty($cpassword)) {
        $input_error['cpassword'] = "The require field is empty!";
    }

    //photo add
    $photo = explode('.', $_FILES['photo']['name']);
    $photo = end($photo);
    $photo_name = $username . '.' . $photo;

    if (count($input_error) == 0) {
        $check_email = mysqli_query($link, "SELECT * FROM `user` WHERE `email`='$email';");
        if (mysqli_num_rows($check_email) == 0) {
            $check_username = mysqli_query($link, "SELECT * FROM `user` WHERE `username`='$username';");
            if (mysqli_num_rows($check_username) == 0) {
                if (strlen($username) > 3) {
                    if (strlen($password) > 3) {
                        if ($password == $cpassword) {
                            $password = $password;
                            $query = "INSERT INTO `admin_user`(`name`, `email`, `username`, `password`, `photo`) VALUES ('$name', '$email', '$username', '$password','$photo_name');";
                            $result = mysqli_query($link, $query);
                            if ($result) {
                                $_SESSION['data_insert_success'] = "Data insert Successfully";
                                $filetem = $_FILES['photo']['tmp_name'];
                                move_uploaded_file($filetem, "images/" . $photo_name);
                                header('location:registration.php');
                            } else {
                                $_SESSION['data_insert_error'] = "Data insert Error";
                            }
                        } else {
                            $m_password = "Password does not match";
                        }
                    } else {
                        $len_password = "Password more than 8 character";
                    }
                } else {
                    $len_username = "Username More than 8 character";
                }
            } else {
                $username_error = "Username Already Exists";
            }
        } else {
            $email_error = "Email Already Exists";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Student Management System</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="css/uikit.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <br>
        <div class="container">
                    <?php
                    if (isset($_SESSION['data_insert_success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['data_insert_success'] . '</div>';
                    }
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-warring">' . $_SESSION['error'] . '</div>';
                    }
                    ?>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" class="text-center bg-dark text-white">Admin Registration Form</td>
                            </tr>
                            <tr>
                                <td><label for="name">Name </label></td>
                                <td><input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                                    <span class="error">
                                        <?php
                                        if (isset($input_error['name'])) {
                                            echo $input_error['name'];
                                        }
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="email">Email </label></td>
                                <td><input type="text" class="form-control" id="email" name="email"placeholder="Enter your email">
                                    <span class="error">
                                        <?php
                                        if (isset($input_error['email'])) {
                                            echo $input_error['email'];
                                        }
                                        if (isset($email_error)) {
                                            echo "$email_error";
                                        }
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="username">Username </label></td>
                                <td><input type="text" class="form-control" id="name" name="username" placeholder="Enter your username">
                                    <span class="error">
                                            <?php
                                            if (isset($input_error['username'])) {
                                                echo $input_error['username'];
                                            }
                                            if (isset($username_error)) {
                                                echo "$username_error";
                                            }
                                            if (isset($len_username)) {
                                                echo "$len_username";
                                            }
                                            ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="password">Password </label></td>
                                <td><input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                    <span class="error">
                                        <?php
                                        if (isset($input_error['password'])) {
                                            echo $input_error['password'];
                                        }
                                        if (isset($len_password)) {
                                            echo "$len_password";
                                        }
                                        ?>
                                    </span></td>
                            </tr>
                            <tr>
                                <td><label for="cpassword">Confirm Password </label></td>
                                <td><input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter your confirm password">
                                    <span class="error">
                                        <?php
                                        if (isset($input_error['cpassword'])) {
                                            echo $input_error['cpassword'];
                                        }
                                        if (isset($m_password)) {
                                            echo "$m_password";
                                        }
                                        ?>
                                    </span></td>
                            </tr>
                            <tr>
                                <td><label for="photo">Photo</label></td>
                                <td><input type="file" name="photo" id="photo"></td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <input type="submit" class="btn btn-outline-dark" name="registration" value="Registration">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <h4>If you have an account? then please <a href="index.php">login</a></h4>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
    </body>
</html>
