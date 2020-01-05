<?php
session_start();

require 'connect.php';

$userName = $_SESSION['userName'];
$sql = "SELECT session_uid FROM student WHERE username = :username";
$stmt = openConnection()->prepare($sql);
$stmt->bindValue(':username', $userName);
//Execute sql
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row['session_uid']= $_COOKIE['PHPSESSID']){

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description">
    <meta name="keywords" content="Student"/>
    <meta name="author" content="Danny Eeraerts"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


</head>
<body>


<div class="container">
        <h1 class="my-3 text-center bg-orange text-light p-3">Your profile</h1>


        <div class="row mt-5">
            <div class="col-6 text-center">
                <img src="<?="images/".$_SESSION['avatar']?>" class="img-fluid" alt="Responsive image">
            </div>
            <div class ="col-6 mt-5">
                <div class="d-flex align-items-baseline">
                    Firstname:&nbsp; <h4><?=$_SESSION['first_name']?></h4>
                </div>
                <br>
                <div class="d-flex align-items-baseline">
                    Lastname:&nbsp; <h4><?= $_SESSION['last_name']?></h4>
                </div>
                <br>
                <div class="d-flex align-items-baseline">
                    Language:&nbsp; <h4><?= $_SESSION['preferred_language']?></h4>
                </div>
                <br>
                <div class="d-flex align-items-baseline">
                    Gender:&nbsp; <h4><?= $_SESSION['gender']?></h4>
                </div>
                <a class="btn bg-orange text-white btn-lg mt-5 " href="register.php" role="button">Update your profile?</a>
            </div>

        </div>


</div>
    <footer class="container fixed-bottom mb-3">

        <!-- Grid row-->
        <div class="row py-3 d-flex align-items-center bg-orange text-light">

            <!-- Grid column -->
            <div class="col-md-5 col-lg-5 text-center text-md-left">
                <p class="mb-0">&copy;&nbsp;<?php echo date("Y"); ?>&nbsp;EDWeb&photoStudio</p>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-7  text-center text-md-right ">

                <!-- Facebook -->
                <a href="#" class ="text-light mr-4">disclaimer</a>
                <a href="#" class ="text-light mr-4">privacy policy</a>
                <a href="#" class ="text-light mr-2">cookie policy</a>
            </div>

    </footer>
</body>
<?php }
else {
    echo "access denied";
}
?>

