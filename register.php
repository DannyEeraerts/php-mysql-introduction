<?php

/**
 * Created by Danny Eeraerts
 * Date: 2019-30-12
 * Time: 09:31
 */

session_start();

require 'connect.php';

$errorFirstName = $errorLastName = $errorUserName = $errorMail = $errorPassword =$errorRepeatPassword = $errorGender =
$errorLanguage = $errorLinkedIn = $errorGithub = $errorVideo = "";
$_SESSION['success_message'] ="";
$_SESSION['error_message']="";
$linkedIn = $video = $github = $avatar= "";
date_default_timezone_set("Europe/Brussels");

//sanitize input

function Sanitize($data){
    $data = trim($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['firstName']) ) {
        if (empty(trim($_POST['firstName']))) {
            $errorFirstName = "You did not fill out this required field";
        }
        elseif (strlen(trim($_POST['firstName']))<2) {
                $errorFirstName = "fill in at least minimum two characters";
        }
        else {
        $_SESSION['firstName'] = Sanitize($_POST['firstName']);
        $firstName = $_SESSION['firstName'];
        }
    }

    if (isset($_POST['lastName']) ) {

        if (empty(trim($_POST['lastName']))) {
            $errorLastName = "You did not fill out this required field";
        }
        elseif (strlen(trim($_POST['lastName']))<2) {
            $errorLastName = "Fill in at least minimum two characters";
        }
        else{
            $_SESSION['lastName'] = Sanitize($_POST['lastName']);
            $lastName = $_SESSION['lastName'];
        }
    }

    if (isset($_POST['userName']) ) {

        if (empty(trim($_POST['userName']))) {
            $errorUserName = "You did not fill out this required field";
        }
        elseif (strlen(trim($_POST['userName']))<2) {
            $errorUsertName = "Fill in at least minimum two characters";
        }
        else{
            $_SESSION['userName'] = Sanitize($_POST['userName']);
            $userName = $_SESSION['userName'];
        }
    }

    //check if the  userName already exists.

    //Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(username) AS num FROM student WHERE username = :username";
    $stmt = openConnection()->prepare($sql);
    $stmt->bindParam(':username', $userName);
    //Execute spl
    $stmt->execute();
    //Fetch the row.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['num'] > 0) {
        $errorUserName = "This username already exists";
    }

    if (isset($_POST['email']) ) {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMail = "Email has no valid format";
        } else {
            $errorMail = "";
            $_SESSION['email'] = $_POST['email'];
            $email = $_SESSION['email'];
        }
    }

    //check if password is at least 8 characters
    if(strlen(trim($_POST['password'])) < 8) {
        $errorPassword = "Password must be at least 8 characters";
    }

    //check if two passwords are equal to each other
    if ($_POST['password'] === $_POST['repeatPassword']) {
            $errorRepeatPassword = "";
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            //var_dump($hashed_password);
            //print_r($_COOKIE['PHPSESSID']);
    }
    else {
        $errorRepeatPassword = "Passwords are not equal";
    }

    if (isset($_POST['linkedIn']) && (trim($_POST['linkedIn']) !== '') ) {

        if (filter_var((trim($_POST['linkedIn'])), FILTER_VALIDATE_URL) === FALSE) {
            $errorVideo = "This is not a valid link.";
        } else {
            $_SESSION['linkedIn'] = $_POST['linkedIn'];
            $linkedIn = $_SESSION['linkedIn'];
        }

        /*if (filter_var((trim($_POST['linkedIn'])), FILTER_VALIDATE_URL) === FALSE) {
            $errorLinkedIn = "This is not a valid link";
        } else {
            $url = filter_var(trim($_POST['linkedIn']));
            // Use get_headers() function
            $headers = @get_headers($url);
            // Use condition to check the existence of URL
            echo $headers[0];
            echo (strpos( $headers[0], '200'));
            if($headers && strpos( $headers[0], '200')) {
                echo "OK";
                die;
                $_SESSION['linkedIn'] = $_POST['linkedIn'];
                $linkedIn = $_SESSION['linkedIn'];
            }
            else {
                $errorLinkedIn = "This link doesn't exists";
                echo $errorLinkedIn;
                die;
            }
        }*/
    }

    if (isset($_POST['github']) ) {

        if((trim($_POST['github']) !== '') ){

            if (filter_var((trim($_POST['github'])), FILTER_VALIDATE_URL) === FALSE) {
                $errorGithub = "This is not a valid link";
            } else {
                $_SESSION['github'] = $_POST['github'];
                $github = $_SESSION['github'];
            }
        }

    }

    if (isset($_POST['video']) && (trim($_POST['video']) !== '') ) {

        if (filter_var((trim($_POST['video'])), FILTER_VALIDATE_URL) === FALSE) {
            $errorVideo = "This is not a valid link.";
        } else {
            $_SESSION['video'] = $_POST['video'];
            $video = $_SESSION['video'];
        }

    }
    if ( ($errorFirstName === '') && ($errorLastName === '') && ($errorUserName === '') &&
         ($errorMail === '') && ($errorPassword === '') && ($errorRepeatPassword === '') &&
         ($errorGender === '') && ( $errorLinkedIn === '') && ($errorGithub === '') && ($errorVideo === '') ){

            $session_UID = $_COOKIE['PHPSESSID'];
            $preferred_language = $_POST['preferredLanguage'];
            $gender = $_POST['gender'];
            $avatar = $_POST['avatar'];
            $_SESSION['avatar']=$avatar;
            $quote = $_POST['quote'];
            $quoteAuthor= $_POST['quote_author'];


            $sql = "INSERT INTO student (session_uid, first_name, last_name, username, hashed_password, email, gender, linkedIn, github, preferred_language, avatar, video, quote, quote_author)
            VALUES (:session_uid, :first_name, :last_name, :username, :hashed_password, :email, :gender, :linkedIn, :github, :preferred_language, :avatar, :video, :quote, :quote_author)";

            $stmt = openConnection()->prepare($sql);

            $stmt->bindValue(':session_uid', $session_UID);
            $stmt->bindValue(':first_name', $firstName);
            $stmt->bindValue(':last_name', $lastName);
            $stmt->bindValue(':username', $userName);
            $stmt->bindValue(':hashed_password', $hashed_password);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':gender', $gender);
            $stmt->bindValue(':linkedIn', $linkedIn);
            $stmt->bindValue(':github', $github);
            $stmt->bindValue(':preferred_language', $preferred_language);
            $stmt->bindValue(':avatar', $avatar);
            $stmt->bindValue(':video', $video);
            $stmt->bindValue(':quote', $quote);
            $stmt->bindValue(':quote_author', $quoteAuthor);

    //Execute spl2
            $stmt->execute();

            $_SESSION['success_message'] = "Welcome " . $firstName . ", you are succesfully registrated";

    }
    else {
        $_SESSION['error_message'] = "There are errors, please correct and submit again";
    }
}


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
        <h1 class="my-3 text-center bg-orange text-light p-3">Sign in</h1>

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

		<form class="form-horizontal my-5" method="post" action="<?= $_SERVER['PHP_SELF'];?>" novalidate >
            <div class="form-row">
            <!-- input Firstname-->
                <div class="form-group required col-6">
                     <label class="control-label" for="firstname">Firstname:</label>
                     <label class="error float-right"><?= $errorFirstName; ?></label>
                     <input name="firstName" id="textinput" type="text" class="form-control" placeholder="FirstName" value ="<?php
                                if(isset($_SESSION['firstName']))
                                {
                                    echo $_SESSION['firstName'];
                                }
                                else
                                {
                                     echo "";
                                }
                          ?>">

                </div>

            <!-- input Lastname-->
                <div class="form-group required col-6">
                    <label class="control-label" for="lastName">Lastname:</label>
                    <label class="error float-right"><?= $errorLastName; ?></label>
                    <input name="lastName" id="textinput" type="text" class="form-control" value ="<?php
                            if(isset($_SESSION['lastName']))
                            {
                                echo $_SESSION['lastName'];
                            }
                            else
                            {
                                echo "";
                            }
                        ?>" placeholder="LastName">
                </div>
            </div>

            <div class="form-row">
                <!-- input UserName-->
                <div class="form-group required col-6">
                    <label class="control-label" for="username">Username:</label>
                    <label class="error float-right"><?= $errorUserName; ?></label>
                    <input name="userName" id="textinput" type="text" placeholder="UserName" value ="<?php
                            if(isset($_SESSION['userName']))
                            {
                                echo $_SESSION['userName'];
                            }
                            else
                            {
                                echo "";
                            }
                        ?>" class="form-control input-md">
                </div>
                <!-- Email input-->
                <div class="form-group required col-6">
                    <label class="control-label" for="Email">E-mail:</label>
                    <label class="error float-right"><?= $errorMail; ?></label>
                    <input name="email"
                           value = "<?php
                               if(isset($_SESSION['email']))
                               {
                                   echo $_SESSION['email'];
                               }
                               else
                               {
                                   echo "";
                               }
                           ?>" class="form-control input-md" id="Email" type="text" placeholder="E-mail">
                </div>
            </div>

            <div class="form-row">
                <!-- input password-->
                <div class="form-group required col-6">
                    <label for="password">Password (min 8 characters)</label>
                    <label class="error float-right"><?= $errorPassword; ?></label>
                    <input name ="password" type="password" class="form-control" id="password" placeholder="Password" >
                </div>
                <!-- Repeat password input-->
                <div class="form-group required col-6">
                    <label for="repeatPassword">Repeat password</label>
                    <label class="error float-right"><?= $errorRepeatPassword; ?></label>
                    <input name ="repeatPassword" type="password" class="form-control" id="repeatPassword" placeholder="Repeat password" >
                </div>
            </div>

            <div class="form-row">
            <!-- input Gender-->
                <div class="form-group required col-6">
                    <label class=" control-label" for="inputGroupGender">Gender:</label>
                        <select class="custom-select" name="gender" id="inputGroupGender">
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                            <option value="x">X</option>
                        </select>
                </div>

                <div class="form-group required col-6">
                    <label class="control-label" for="inputGroupLanguage">Language:</label>
                        <select class="custom-select" name = "preferredLanguage" id="inputGroupLanguage">
                            <option value="aa">Afar</option>
                            <option value="ab">Abkhazian</option>
                            <option value="af">Africaans</option>
                            <option value="sq">Albanian</option>
                            <option value="am">Amharic</option>
                            <option value="ar">Arabic</option>
                            <option value="hy">Armenian</option>
                            <option value="as">Assamese</option>
                            <option value="ay">Aymara</option>
                            <option value="az">Azerbaijani</option>
                            <option value="ba">Bashkir</option>
                            <option value="eu">Basque</option>
                            <option value="bn">Bengali</option>
                            <option value="dz">Bhutani</option>
                            <option value="bh">Bihari</option>
                            <option value="bi">Bislama</option>
                            <option value="br">Breton</option>
                            <option value="bg">Bulgarian</option>
                            <option value="my">Burmese</option>
                            <option value="be">Byelorussian</option>
                            <option value="km">Cambodian</option>
                            <option value="ca">Catalan</option>
                            <option value="zh">Chinese</option>
                            <option value="co">Corsican</option>
                            <option value="hr">Croatian</option>
                            <option value="cs">Czech</option>
                            <option value="da">Danish</option>
                            <option value="nl">Dutch</option>
                            <option value="en" selected>English</option>
                            <option value="eo">Esperanto</option>
                            <option value="et">Estonian</option>
                            <option value="fo">Faeroese</option>
                            <option value="fj">Fiji</option>
                            <option value="fi">Finnish</option>
                            <option value="fr">French</option>
                            <option value="fy">Frisian</option>
                            <option value="gl">Galician</option>
                            <option value="ka">Georgian</option>
                            <option value="de">German</option>
                            <option value="el">Greek</option>
                            <option value="kl">Greenlandic</option>
                            <option value="gn">Guarani</option>
                            <option value="gu">Gujarati</option>
                            <option value="ha">Hausa</option>
                            <option value="he">Hebrew</option>
                            <option value="hi">Hindi</option>
                            <option value="hu">Hungarian</option>
                            <option value="id">Indonesian</option>
                            <option value="ia">Interlingua</option>
                            <option value="ie">Interlingue</option>
                            <option value="ik">Inupiak</option>
                            <option value="iu">Inuktitut</option>
                            <option value="ga">Irish</option>
                            <option value="it">Italian</option>
                            <option value="ja">Japanese</option>
                            <option value="jw">Javanese</option>
                            <option value="kn">Kannada</option>
                            <option value="ks">Kashmiri</option>
                            <option value="kk">Kazakh</option>
                            <option value="rw">Kinyarwanda</option>
                            <option value="ky">Kirghiz</option>
                            <option value="rn">Kirundi</option>
                            <option value="ko">Korean</option>
                            <option value="ku">Kurdish</option>
                            <option value="lo">Laothian</option>
                            <option value="la">Latin</option>
                            <option value="lv">Latvian, Lettish</option>
                            <option value="ln">Lingala</option>
                            <option value="lt">Lithuanian</option>
                            <option value="mk">Macedonian</option>
                            <option value="mg">Malagasy</option>
                            <option value="ms">Malay</option>
                            <option value="ml">Malayalam</option>
                            <option value="mt">Maltese</option>
                            <option value="mi">Maori</option>
                            <option value="mr">Marathi</option>
                            <option value="mo">Moldavian</option>
                            <option value="mn">Mongolian</option>
                            <option value="na">Nauru</option>
                            <option value="ne">Nepali</option>
                            <option value="no">Norwegian</option>
                            <option value="os">Occitan</option>
                            <option value="or">Oriya</option>
                            <option value="ps">Pashto, Pushto</option>
                            <option value="fa">Persian</option>
                            <option value="pl">Polish</option>
                            <option value="pt">Portuguese</option>
                            <option value="pa">Punjabi</option>
                            <option value="qu">Quechua</option>
                            <option value="rm">Rhaeto-Romance </option>
                            <option value="ro">Romanian</option>
                            <option value="ru">Russian</option>
                        </select>
                </div>
            </div>

            <div class="form-row">
            <!-- input LinkedIn-->
                <div class="form-group col-6">
                    <label class="control-label" for="linkedIn">LinkedIn:</label>
                    <label class="error float-right"><?= $errorLinkedIn; ?></label>
                    <input name="linkedIn" class="form-control input-md" id="textinput" type="text" placeholder="LinkedIn-link">
                </div>

            <!-- input Github-->
                <div class="form-group col-6">
                    <label class="control-label" for="github">Github:</label>
                    <label class="error float-right"><?= $errorGithub; ?></label>
                    <input name="github" class="form-control input-md" id="textinput" type="text" placeholder="Github-link">
                </div>
            </div>

            <div class="form-row">
                <!-- File Button -->

                <div class="form-group col-6">
                    <div class="row">
                    <p class ="control-label mb-2 col-12" >Avatar:</p>
                    </div>
                    <div class="row">
                        <div class ="col-12">
                            <input name="avatar" class="form-control custom-file-input px-1" id="customFile" type="file" accept="image/png" lang ="en">
                            <label class="custom-file-label mx-3" for="customFile">Select a avatar</label>
                        </div>
                    </div>
                </div>


                <!--<div class=" selectpicker col-6">
                <label class=" control-label" for="inputGroupAvatar">Avatar:</label>
                    <select class="custom-select " name="avatar" id="inputGroupAvatar">
                        <option value="aquarius" style="background-image:url(images/aquarius.png);">Aquarius</option>
                        <option value="aquarius" style="background-image:url(images/archery.png);">Aquarius</option>

                    </select>
                </div>-->

                <!-- Link to video -->
                <div class="form-group col-6">
                    <label class="control-label" for="textinput">Video:</label>
                    <label class="error float-right"><?= $errorVideo; ?></label>
                    <input name="video" class="form-control input-md" id="textinput" type="url" placeholder="Video-link">
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-6">
                    <label class="control-label" for="comment">Favorite quote:</label>
                    <textarea class="form-control py-n2" rows="3" name = "quote" id="comment"></textarea>
                </div>

                <div class="form-group col-6">
                    <div class="row">
                        <div class ="col-12">
                            <label class="control-label" for="quote_author">Author of the quote:</label>
                            <input name="quote_author" class="form-control input-md" id="textinput" type="url" placeholder="author of the quote">
                        </div>
                    </div>
                    <div class="row text-right mt-2">
                        <div class ="col-12">
                            <button name="singlebutton" class="btn bg-orange btn-lg btn-block" id="singlebutton">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group col-12 text-right p-0">

            </div>

        </form>
        <div class="text-center">
            <p>already have an account? <a href="login.php" class="link">login here</a></p>

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

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
</script>