<?php
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
    <h1 class="my-3 text-center bg-orange text-light p-3">Password Reset</h1>

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
                       <label for="inputUserName" class="sr-only">Enter the email of your account to reset Password</label>
                       <input type="email" name="userName" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                  </div>
                      <!-- input Password-->
                  <button name="singlebutton" class="btn bg-orange btn-lg offset-3 col-6" id="singlebutton">Submit</button>
              </div>
        </div>
    </form>

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


