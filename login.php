<?php
session_start();

require 'connect.php';

$_SESSION['success_message'] ="";
$_SESSION['error_message']="";

function Sanitize($data){
    $data = trim($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['userName'])) {
        $_SESSION['userName'] = Sanitize($_POST['userName']);
        $userName = $_SESSION['userName'];
        $sql = "SELECT session_uid, first_name, last_name, username, email, hashed_password, preferred_language, gender, avatar FROM student WHERE username = :username";
        $stmt = openConnection()->prepare($sql);
        $stmt->bindValue(':username', $userName);
        //Execute sql
        $stmt->execute();

        //Fetch the row.
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (count($row) == 0) {
            $_SESSION['error_message'] = "user or password are not correct";
        } elseif (password_verify($_POST['password'], $row['hashed_password'])) {
                $_SESSION['session_uid'] = $_COOKIE['PHPSESSID'];
                $sessionID = $_SESSION['session_uid'];
                $sql = "UPDATE student SET session_uid = :sessionid WHERE username = :username";
                $stmt = openConnection()->prepare($sql);
                $stmt->bindValue(':username', $userName);
                $stmt->bindValue(':sessionid', $sessionID);
                //Execute sql
                $stmt->execute();
                $_SESSION['success_message'] = "you are loged in";
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['gender'] = $row['gender'];
                $_SESSION['preferred_language'] = $row['preferred_language'];
                $_SESSION['avatar'] = $row['avatar'];

                sleep(5);
                header("location: profile.php");
        }
        else {
            $_SESSION['error_message'] = "user and/or password are not correct";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
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

<body class="text-center">
<div class="container">
    <h1 class="my-3 text-center bg-orange text-light p-3">Login in</h1>

    <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
        <div class="alert alert-success mb-0">
            <?= $_SESSION['success_message']; ?></div>
        <?php
        $_SESSION['success_message']="";
    }
    ?>

    <?php if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) { ?>
        <div class="alert alert-danger mb-0">
            <h3><?= $_SESSION['error_message']; ?></h3></div>
        <?php
        $_SESSION['error_message']="";
    }
    ?>

    <form class="d-flex flex-column" method="post" action="<?= $_SERVER['PHP_SELF'];?>" novalidate autocomplete="off" >
        <div class ="align-items-center align-content-center">
              <img class="mb-4" src="images/logo.jpg" alt="" width="125" height="125">
              <div class="form-row">
                    <!-- input Username-->
                  <div class="form-group required offset-3 col-6">
                       <label for="inputUserName" class="sr-only">user name</label>
                       <input type="text" name="userName" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                  </div>
                      <!-- input Password-->
                  <div class="form-group required offset-3 col-6">
                       <label for="inputPassword" class="sr-only">Password</label>
                       <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                  </div>
                  <button name="singlebutton" class="btn bg-orange btn-lg offset-3 col-6" id="singlebutton">Submit</button>
              </div>
        </div>
    </form>
    <div class="mt-5 text-center">
        <p>not an account? <a href="register.php" class="link">register here</a></p>
    </div>
    <div class="mt-5 text-center">
        <p>not an account? <a href="register.php" class="link">register here</a></p>
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
</div>
</body>
</html>

