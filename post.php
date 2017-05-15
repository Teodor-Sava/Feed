<?php
if ($_SESSION['logged_in'] !== true || $_SESSION['user']['confirmed'] == 0) {
    header('Location:index.php');
}
$config = require_once 'includes/config.php';
require_once 'includes/functions.php';

$dbh = createPDO($config);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET' :
        $post_id = trim($_GET['post_id'], FILTER_SANITIZE_STRING);
        $stmt = $dbh->prepare('SELECT post_id, title, content,username FROM posts WHERE post_id = :post_id LIMIT 1');

        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        /*** bind the parameters ***/
        $stmt->execute();
        /*** check for a result ***/
        $post = $stmt->fetch();
        $stmt = $dbh->prepare('SELECT content ,post_id , username FROM comments WHERE post_id = :post_id');

        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        /*** bind the parameters ***/
        $stmt->execute();
        /*** check for a result ***/
        $comment = $stmt->fetchAll();
        return array($post, $comment);
        break;
    case 'POST':
        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
        $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

        $stmt = $dbh->prepare("INSERT INTO posts (title, content ,user_id,username ) VALUES (:title, :content, :user_id,:username )");

        /*** bind the parameters ***/
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR, 40);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR, 40);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        /*** execute the prepared statement ***/
        $stmt->execute();

        header('Location:posts.view.php');
}