<?php
if ($_SESSION['logged_in'] !== true || $_SESSION['user']['confirmed'] == 0) {
    header('Location:index.php');
}
$config = require_once 'includes/config.php';

try {
    require_once 'includes/functions.php';

    $dbh = createPDO($config);
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'POST':

            $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
            $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);
            $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_STRING);
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

            $stmt = $dbh->prepare("INSERT INTO comments (content ,user_id,username ,post_id ) VALUES (:content,:user_id ,:username,:post_id)");

            $stmt->bindParam(':content', $content, PDO::PARAM_STR, 40);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR, 40);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR, 40);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);

            $stmt->execute();
            $message = 'You successfully added a comment';

    }
} catch (Exception $e) {

    //$message = "There was a problem with the login . Please retry";
    $message = "There was a problem with adding the comment";
}
?>

<?php include('includes/header.php'); ?>

<?php include('includes/navbar.php'); ?>

    <div class="jumbotron">
        <div class="container">
            <h3><?php
                echo $message;

                header("refresh:2;url=post.view.php?post_id=" . $post_id);

                ?></h3>
        </div>
    </div>
<?php include('includes/footer.php'); ?>