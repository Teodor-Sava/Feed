<?php

$config = require_once 'includes/config.php';

try {
    if ($_SESSION['user']['confirmed'] != 0) {
        $message = 'you are already confirmed';
    } else {
        $dbg = createPDO($config);

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET' :
                $username = $_GET['username'];
                $key = $_GET['key'];

                $stmt = $dbh->prepare('SELECT keyg FROM users WHERE username=:username');
                $stmt->bindParam(':username', $username, PDO::PARAM_INT);
                $stmt->execute();
                $keyDatabase = $stmt->fetch();

                if ($keyDatabase['keyg'] === $key) {
                    $stmt = $dbh->prepare('UPDATE users SET confirmed=NOT confirmed WHERE username = :username');
                    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt->execute();
                    $message = 'You have confirmed your email';
                } else {
                    $message = 'Incorrect credentials to confirm your mail';
                }
                break;
            case 'POST':
                $message = 'Dont try anything funny sir';
                break;

        }
    }
} catch (Exception $e) {

    $message = "There was a problem with the login . Please retry";
    //$message = $e->getMessage();
}
?>
<?php include('includes/header.php'); ?>

<?php include('includes/navbar.php'); ?>

<div class="jumbotron">
    <div class="container">
        <h3><?php
            echo $message;

            header('refresh:3 ;url=login.php');

            ?></h3>
    </div>
</div>
<?php include('includes/footer.php'); ?>
