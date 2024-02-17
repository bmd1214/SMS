<?php
session_start();

require_once 'User.php';
require_once 'Validation.php';


// Check if the user is already logged in, redirect to home page if true
if(isset($_SESSION['userName'])) {
    header("Location: ../../homePage/php/HomePage.php");
    exit();
}

// handle the sign up method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $userName = $_POST['userName'];
    $address = $_POST['address'];
    $phone = $_POST['phoneNumber'];
    $birth = $_POST['birthDate'];
    $usertype = $_POST['userType'];
    $email = $_POST['email'];
    $fpassword = $_POST['password1'];
    $spassowrd = $_POST['password2'];
    $gender = $_POST['gender'];


    $user = new User($fname, $lname, $userName, $address, $phone, $birth, $usertype, $email, $fpassword, $spassowrd, $gender) ;
    $user->insertUser();

    if(true) {
        // Set session variables
        $_SESSION['userName'] = $userName;

        // Redirect to home page after successful signup
        header("Location: ../../homePage/php/HomePage.php");
        exit();
    }else {
        echo "Invalid username or password";
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/signup.css">
    <title>Sign Up</title>
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo">Mingle!</div>
            <ul>
                <li><a href="../../log in system/php/login-interface.php" target="_blank"><button>Log in</button></a></li>
                <li><a href="#" ><button>About Us</button></a></li>
            </ul>
        </div>
    </nav>


    <div class="class1">
        <form action="" method="post" >
            <h1>Sign Up</h1>
                <div class="box1" >
                <label for="" >First Name</label>
                <input type="text" name="fName" placeholder="">
                <label for="" >Last Name</label>
                <input type="text" name="lName" placeholder="">
                <label for="" >User Name</label>
                <input type="text" name="userName" placeholder="">
                <label for="">Address</label>
                <input type="text" name="address" placeholder="">
                <label for="">Phone Number</label>
                <input type="text" name="phoneNumber" placeholder="">
                <label for="">Date Of birth</label>
                <input type="date" name="birthDate">

                <label for="">User Type</label>
                <select name="userType" id="">
                    <option name="userType" value=""></option>
                    <option name="userType" value="1">Admin</option>
                    <option name="userType" value="2">VIP</option>
                    <option name="userType" value="3">User</option>
                </select>

                <label for="">Email</label>
                <input type="email" name="email" required placeholder="">
                <label for="">Password</label>
                <input type="password" name="password1" placeholder="">
                <label for="">Confirm Password</label>
                <input type="password" name="password2" placeholder="">
             </div>
             <div class="box2">
                <td>gender: <input type="radio" name="gender" value="1" >male</td>
                <td><input type="radio" name="gender" value="2" >female</td><br>
                <input type="submit" value="Sign Up">
            </div>
        </form>
    </div>
    <p>Already have an account? <a href="login.html">Login here</a></p>
</body>
</html>