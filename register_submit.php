<?php
/*** begin our session ***/
//session_start();
$config = require_once 'includes/config.php';

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
require_once 'includes/functions.php';

if (isset($_POST['validation'])) {
    $message = 'what are you trying big boy ?';
}
if (!isset($_POST['username'], $_POST['password'],$_POST['email'],$_POST['form_token'])) {
    $message = 'Please enter a valid username and password';
} /*** check the form token is valid ***/
elseif ($_POST['form_token'] != $_SESSION['form_token']) {
    $message = 'Invalid form submission';
} /*** check the username is the correct length ***/
elseif (strlen($_POST['username']) > 20 || strlen($_POST['username']) < 4) {
    $message = 'Incorrect Length for Username';
} /*** check the password is the correct length ***/
elseif (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 4) {
    $message = 'Incorrect Length for Password';
} /*** check the password is not the same as username***/
elseif ($_POST['password'] === $_POST['username']) {
    $message = 'User cannot be the same as password';
} /*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['username']) != true) {
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
} /*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['password']) != true) {
    /*** if there is no match ***/
    $message = "Password must be alpha numeric";
} else {
    /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

    /*** now we can encrypt the password ***/
    $salt = base64_encode(random_bytes(16));
    $password = hash('sha256', $password . $salt);

    try {
        $dbh = createPDO($config);

        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP

        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = $config['mail'];   // SMTP username
        $mail->Password = $config['password'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is
        $mail->From = $config['mail'];
        $mail->FromName = 'Teodor';
        $mail->addAddress($email);                 // Add a recipient
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->Subject = 'Confirm your account';

        $key = $username . date('mY');
        $key = md5($key);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($username === "admin"){
            $role = "admin";
        }else {
            $role = "user";
        }
        /*** prepare the insert ***/
        $stmt = $dbh->prepare("INSERT INTO users (username, password ,salt,keyg,role ) VALUES (:username, :password, :salt,:keyg ,:role )");

        /*** bind the parameters ***/
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);
        $stmt->bindParam(':salt', $salt, PDO::PARAM_STR);
        $stmt->bindParam(':keyg', $key, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        $stmt->execute();


        $mail->Body =
            "Welcome $username!Thank-you for creating an account. Please confirm your account by copy and pasting the link below into your browsers address bar. http://localhost/postProject/confirm.php?username=" . $username . "&key=" . $key . " Thanks!";
        /*** unset the form token session variable ***/

        unset($_SESSION['form_token']);

    } catch (Exception $e) {
        /*** check if the username already exists ***/
        if ($e->getCode() == 23000) {
            $message = 'Username already exists';
        } else {
            /*** if we are here, something has gone wrong with the database ***/
            $message = 'We are unable to process your request. Please try again later"';
        }
    }
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<div class="jumbotron">
    <div class="container">
        <h3><?php
            if ($mail->send()) {
                echo $message = 'New user added. A mail was sent to confirm you account to the address ' . $email;
                header('refresh:3 ;url=login.php');
            } else {
                echo $message = 'The mail was not send';
                header('refresh:4; url=register.php');
            }
            ?>
        </h3>
    </div>
</div>
<?php include('includes/footer.php'); ?>
