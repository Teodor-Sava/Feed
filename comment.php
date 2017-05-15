<?php
if ($_SESSION['logged_in'] !== true || $_SESSION['user']['confirmed'] == 0) {
    header('Location:index.php');
}
$config = require_once 'includes/config.php';

try {
    $mysql_hostname = 'localhost';
    $mysql_username = $config['database']['username'];
    $mysql_password = $config['database']['password'];
    $mysql_dbname = $config['database']['name'];

    $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
    $message = "smth good happened";
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $message = "smth good happeeened";
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET' :
            $post_id = trim($_GET['post_id'], FILTER_SANITIZE_STRING);

            $stmt = $dbh->prepare('SELECT content, user_id ,post_id FROM comments WHERE post_id = :post_id');

            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            /*** bind the parameters ***/
            $stmt->execute();
            /*** check for a result ***/
            $comment = $stmt->fetch();

            return $comment;
            break;
        case 'POST':

            $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
            $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);
            $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_STRING);
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

            $message = "smth good happened 1";
            $stmt = $dbh->prepare("INSERT INTO comments (content ,user_id,username ,post_id ) VALUES (:content,:user_id ,:username,:post_id)");

            /*** bind the parameters ***/
            $message = "smth good happened 2";
            $stmt->bindParam(':content', $content, PDO::PARAM_STR, 40);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR, 40);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR, 40);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $message = "smth good happened3";
            /*** execute the prepared statement ***/
            $stmt->execute();
            $message = 'You successfully added a post';

    }
} catch (Exception $e) {

    //$message = "There was a problem with the login . Please retry";
    $message = $e->getMessage();
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