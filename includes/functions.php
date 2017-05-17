<?php

function displayImage()
{
    $config = require_once 'config.php';
    $mysql_hostname = 'localhost';
    $mysql_username = $config['database']['username'];
    $mysql_password = $config['database']['password'];
    $mysql_dbname = $config['database']['name'];

    $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

    $user_id = $_SESSION['user']['user_id'];
    $sql = "SELECT avatar FROM users WHERE user_id=:user_id";

    $stmt = $dbh->prepare($sql);


    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $image = $stmt->fetch();
    if ($image['avatar'] == NULL) {
        echo '<img src="includes/default.gif" class="img-thumbnail center-block" height="200" width="250" style="display: flex"/>';
    } else {
        echo '<img src="data:image/jpeg;base64,' . $image['avatar'] . '" class="img-thumbnail center-block" height="200" width="250" style="display: flex"/>';
    }

}

function displayAvatar($username)
{
    $config = require_once 'config.php';
    $mysql_hostname = 'localhost';
    $mysql_username = $config['database']['username'];
    $mysql_password = $config['database']['password'];
    $mysql_dbname = $config['database']['name'];

    $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

    $sql = "SELECT avatar FROM users WHERE username= :username";

    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $image = $stmt->fetch();

    if ($image['avatar'] == NULL) {
        echo '<img src="includes/default.gif" class="profile-image img-circle height="20" width="20""/>';
    } else {
        echo '<img src="data:image/jpeg;base64,' . $image['avatar'] . '" class="profile-image img-circle height="20" width="20""/>';
    }
}

function createPDO($config)
{
    $mysql_hostname = 'localhost';

    $mysql_username = $config['database']['username'];

    $mysql_password = $config['database']['password'];

    $mysql_dbname = $config['database']['name'];


    $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function users()
{
    $config = require_once 'config.php';
    $mysql_hostname = 'localhost';

    $mysql_username = $config['database']['username'];

    $mysql_password = $config['database']['password'];

    $mysql_dbname = $config['database']['name'];

    $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

    $sql = "SELECT username FROM users";

    $stmt = $dbh->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}