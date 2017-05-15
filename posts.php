<?php
if ($_SESSION['logged_in'] !== true) {
    header('Location:index.php');
}
$config = require_once 'includes/config.php';
require_once 'includes/functions.php';

$dbh = createPDO($config);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET' :
        //$if($_SERVER[SCRIPT_FILENAME])
        $stmt = $dbh->prepare('SELECT post_id, title, content,username FROM posts');

        /*** bind the parameters ***/
        $stmt->execute();
        /*** check for a result ***/
        $posts = $stmt->fetchAll();
        return $posts;
        break;

}

?>