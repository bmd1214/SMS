<?php


require_once '../../signup system/php/DataBaseConnection.php';

session_start();

//check the username
if(!(isset($_SESSION['userName']))){
    header("Location: ../log in system/php/login-interface.php");
}

$userName = $_SESSION['userName'];

$conn = new DataBaseConnection();

//query to get the user info
$result = mysqli_query($conn->getConnection(),"SELECT user_id FROM user WHERE user_name = '$userName'");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $userId = $row['user_id']; // save the id 
} else {
    echo " didn't find the user " ;
    exit;
}

if (isset($userId)) {
    $_SESSION['user_id'] = $userId; // store the id in the session
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/HomePage.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Home</title>
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo">Mingle! <br>
                <p class="motto">Welcome to Mingle, where friendships kindle</p>
            </div>
            <ul>
                <li><a href="../../signup system/php/editUser.php" target="_Self"><button>edit info</button></a></li>
                <li><a href="../../add post system/php/editPost.php" target="_Self"><button>edit post</button></a></li>
                <li><a href="../../post search/php/postComment.php" target="_blank"><button>Posts</button></a></li>
                <li><a href="../../add post system/php/postPage-interface.php" target="_self"><button>Add Post</button></a></li>
                <li><a href="#" target="_blank"><button>About Us</button></a></li>
                <li><a href="../../logout system/logout.php" target="_self"><button>log out</button></a></li>
                <li><a href="#" ><?php echo $userName; ?></a></li>

            </ul>
        </div>
    </nav>

    <div class="body">
        <h2>Welcome to my website Mingle, where stories and experience intermingle.</h2>
        <h3 >You can post and vote. you can comment and make friends all over the world.</h3>

    </div>

    <footer>
        <div class="footer-content">
            
            <ul class="social-logos">
                <li><a href="https://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://www.github.com"><i class="fa fa-github"></i></a></li>
                <li><a href="https://www.instagram.com"><i class="fa fa-instagram"></i></a></li>
                <li><a href="https://www.whatsapp.com"><i class="fa fa-whatsapp"></i></a></li>
                <li><a href="https://www.telegram.com"><i class="fa fa-telegram"></i></a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            
            <p>Contact Us : +218 917711221</p>
            <p>E-Mail : Example@gmail.com</p>
            <p>copyright &copy;2024 designed by <span>Anonymous person</span></p>

        </div>
    </footer>
</body>
</html>