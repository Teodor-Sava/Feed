<?php
ob_start();
ini_set("session.cookie_httponly", 1);
ini_set('session.use_only_cookies', 1);


$config = require_once 'includes/config.php';

require_once 'includes/functions.php';
if (!isset($_SESSION['user'])) {
    $message = 'You must be logged in to access this page';
    $_SESSION['logged_in'] = false;
} else {
    try {
        $dbh = createPDO($config);
        $stmt = $dbh->prepare("SELECT username FROM users 
        WHERE user_id = :user_id LIMIT 1");

        /*** bind the parameters ***/
        $stmt->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        $username = $stmt->fetch();

        $stmt = $dbh->prepare("SELECT post_id , title , content,username FROM posts 
        WHERE user_id = :user_id ");

        $stmt->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        $postText = $stmt->fetchAll();

        if ($username == false) {
            $message = 'Access Error';
        } elseif (!isset($_COOKIE)) {
            $message = "Not recognized user";
        } else {
            $message = 'Welcome to your feed ' . $username['username'] . '. These are your posts';
        }

    } catch (Exception $e) {
        /*** if we are here, something is wrong in the database ***/
        $message = 'We are unable to process your request. Please try again later"';
    }
}

?>

<?php include('index.view.php'); ?>