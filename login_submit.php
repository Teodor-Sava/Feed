<?php

$config = require_once 'includes/config.php';
require_once 'includes/functions.php';

/*** check that both the username, password have been submitted ***/
if (!isset($_POST['username'], $_POST['password'])) {
    $message = 'Please enter a valid username and password';
} elseif ($_POST['form_token'] != $_SESSION['form_token']) {
    $message = 'Invalid form submission';
} /*** check the username is the correct length ***/
elseif (strlen($_POST['username']) > 20 || strlen($_POST['username']) < 4) {
    $message = 'Incorrect Length for Username';
} /*** check the password is the correct length ***/
elseif (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    $message = 'Incorrect Length for Password';
} else {
    /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $remember = filter_var($_POST['remember'], FILTER_SANITIZE_STRING);
    try {

        $dbh = createPDO($config);

        $stmt = $dbh->prepare('SELECT user_id, username, password ,salt,avatar,confirmed,role FROM users 
                    WHERE username = :username');

        /*** bind the parameters ***/
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);


        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        $user_id = $stmt->fetch();

        /*** if we have no result then fail boat ***/
        if (empty($user_id)) {

            $message = 'User not found';

        } elseif ($user_id['password'] !== hash('sha256', $password . $user_id['salt'])) {

            $message = 'Wrong credentials! Try again';

        } /*** if we do have a result, all is well ***/
        else {

            $_SESSION['user'] = $user_id;
            $_SESSION['logged_in'] = true;
            $message = 'You are now logged in';

        }


    } catch (Exception $e) {

        $message = "There was a problem with the login . Please retry";
    }
}
?>

<?php include('includes/header.php'); ?>

<?php include('includes/navbar.php'); ?>

    <div class="jumbotron">
        <div class="container">
            <h3><?php

                echo $message;
                if ($message !== 'You are now logged in') {
                    header('refresh:2 ;url=login.php');
                } else {
                    header('refresh:2 ;url=index.php');
                }
                ?></h3>
        </div>
    </div>
<?php include('includes/footer.php'); ?>