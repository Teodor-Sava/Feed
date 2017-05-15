<?php

if ($_SESSION['logged_in'] !== true || $_SESSION['user']['confirmed'] == 0) {
    header('Location:index.php');
}
$config = require_once 'includes/config.php';
require_once 'includes/functions.php';

try {

    $dbh = createPDO($config);

    $post_id = $_GET['post_id'];

    $stmt = $dbh->prepare('SELECT user_id , post_id FROM posts WHERE post_id= :post_id');
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $user_id = $stmt->fetch();

    $message = 'The post was deasdfadsleted 2';
    if ($_SESSION['user']['user_id'] === $user_id['user_id']) {
        $sql = "DELETE FROM posts WHERE post_id= :post_id";
        $stmt2 = $dbh->prepare($sql);
        $stmt2->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt2->execute();
        if ($stmt2->execute() === true) {
            $message = 'The post was deleted';
        } else {
            $message = 'There was an error';
        }
    }


} catch (Exception $exception) {
    $message = 'There was a problem . Please try again';
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

    <div class="jumbotron">
        <div class="container">
            <h3><?php
                echo $message;
                header('refresh:2 ;url=posts.view.php');

                ?></h3>
        </div>
    </div>
<?php include('includes/footer.php'); ?>