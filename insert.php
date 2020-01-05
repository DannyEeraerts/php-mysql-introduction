<?php

$sql = "INSERT INTO student (session_uid, first_name, last_name, username, hashed_password, email, gender, linkedIn, github, preferred_language, avatar, video, quote, quote_author)
        VALUES (session_uid = :session_uid, first_name = :first_name, last_name = :last_name, username = :username, hashed_password = :hashed_password, email = :email, gender = :gender, linkedIn = :linkedIn, github = :github, preferred_language = :preferred_language, avatar = :avatar, video =:video, quote = :quote, quote_author = :quote_author)";

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
$stmt->bindValue( 'quote_author', $quoteAuthor);

//Execute spl2
$stmt->execute();