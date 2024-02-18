<?php

require_once 'DataBaseConnection.php';
require_once 'User.php';

session_start();

// check if the user id isset 
if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}
else{
    echo "there is somthing wrong with the id";
    exit;
}

    $userName = $_SESSION['userName'];

    $conn = new DataBaseConnection();

    //get the user's information to display in the edit form
    $user = mysqli_query($conn->getConnection(), "SELECT * FROM user WHERE user_name = '$userName'" );

    //if the user exist
    if ($user) {
        $row = mysqli_fetch_assoc($user);

        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $userName = $row['user_name'];
        $address = $row['address'];
        $phone = $row['phone_number'];
        $birth = $row['date_of_birth'];
        $usertype = $row['user_type_id'];
        $email = $row['email'];
        $password = $row['password'];
        $gender = $row['gender_id'];

    } else {
        echo " there was something wrong " ; // user not found
        exit;
    }
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

    $userUpdate = new User($fname, $lname, $userName, $address, $phone, $birth, $usertype, $email, $fpassword, $spassowrd, $gender);
    $userUpdate->updateUser($userId); // send the id to update the user info

    header("Location: ../../homePage/php/HomePage.php");

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
                <li><a href="../../homePage/php/HomePage.php" target="_blank"><button>Home</button></a></li>
                <li><a href="#" ><button>About Us</button></a></li>
            </ul>
        </div>
    </nav>


    <div class="class1">
        <form action="" method="post" >
            <h1>Edit info</h1>
                <div class="box1" >
                <label for="" >First Name</label>
                <input type="text" name="fName" value="<?php echo $fname; ?>" placeholder="">
                <label for="" >Last Name</label>
                <input type="text" name="lName" value="<?php echo $lname; ?>" placeholder="">
                <label for="" >User Name</label>
                <input type="text" name="userName" value="<?php echo $userName; ?>" placeholder="">
                <label for="">Address</label>
                <input type="text" name="address" value="<?php echo $address; ?>"  placeholder="">
                <label for="">Phone Number</label>
                <input type="text" name="phoneNumber" value="<?php echo $phone; ?>" placeholder="">
                <label for="">Date Of birth</label>
                <input type="date" name="birthDate" value="<?php echo $birth; ?>">

                <label for="">User Type</label>
                <select name="userType" id="">
                    <option name="userType" value=""></option>
                    <option name="userType" value="1">Admin</option>
                    <option name="userType" value="2">VIP</option>
                    <option name="userType" value="3">User</option>
                </select>

                <label for="">Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" required placeholder="">
                <label for="">Password</label>
                <input type="password" name="password1" value="<?php echo $password; ?>" placeholder="">
                <label for="">Confirm Password</label>
                <input type="password" name="password2" value="<?php echo $password; ?>" placeholder="">
             </div>
             <div class="box2">
                <td>gender: <input type="radio" name="gender" value="1" checked >male</td>
                <td><input type="radio" name="gender" value="2" >female</td><br>
                <input type="submit" value="Save">
            </div>
        </form>
    </div>
</body>
</html>