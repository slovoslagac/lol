<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 30.11.2017
 * Time: 13:10
 */
$email = 'chumpitas@gmail.com';
$hash = '1141938ba2c2b13f7117d7c424ebae5f';

$to      = $email; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject
$message = '

Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.


Please click this link to activate your account:
http://localhost/lol/verify.php?email='.$email.'&hash='.$hash.'

'; // Our message above including the link

$headers = 'From:noreply@level-up.rs' . "\r\n". "CC : petar.prodanovic@gmail.com"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email