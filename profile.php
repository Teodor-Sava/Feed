<?php
if ($_SESSION['logged_in'] !== true || $_SESSION['user']['confirmed'] == 0) {
    header('Location:index.php');
}
$config = require_once 'includes/config.php';
require_once 'includes/functions.php';
try {
    $dbh = createPDO($config);

    $user_id = $_SESSION['user']['user_id'];

    $acceptedExtensions = array('image/png', 'image/jpeg', 'image/gif');
    $avatar = addslashes($_FILES['image']['tmp_name']);
    if (in_array(mime_content_type($avatar), $acceptedExtensions)) {
        if ($avatar < 2000000) {
            $avatar = file_get_contents($avatar);
            $avatar = base64_encode($avatar);
        } else {
            $avatar = NULL;
        }
    } else {
        $avatar = NULL;
    }

    $oldPassword = $_POST['oldpassword'];

    $stmt = $dbh->prepare('SELECT password ,salt FROM users WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    $dbpassword = $stmt->fetch();

    $newPassword = hash('sha256', $_POST['newpassword'] . $dbpassword['salt']);


    if (!empty($oldPassword)) {
        $stmt = $dbh->prepare('SELECT password ,salt FROM users WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $dbpassword = $stmt->fetch();

        if ($dbpassword['password'] === hash('sha256', $oldPassword . $dbpassword['salt'])) {
            if (empty($avatar)) {
                $stat = $dbh->prepare('UPDATE users SET password= :password WHERE user_id= :user_id');
                $stat->bindParam(':password', $newPassword, PDO::PARAM_STR);
                $stat->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $stat->execute();

                $message = "You have updated your password";
            } else {
                $stmt = $dbh->prepare('UPDATE users SET password = :password, avatar = :avatar WHERE user_id = :user_id');
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
                $stmt->bindParam(':avatar', $avatar, PDO::PARAM_LOB);
                $stmt->execute();

                $msg = "image uploaded successfully";
            }
            //$message = "You have updated your password and avatar";

        }

    } else {

        if (!empty($avatar)) {
            $stat = $dbh->prepare('UPDATE users SET avatar = :avatar WHERE user_id = :user_id');
            $stat->bindParam(':avatar', $avatar, PDO::PARAM_LOB);
            $stat->bindParam(':user_id', $user_id, PDO::PARAM_STR);

            $stat->execute();

            $message = "You have updated your avatar";
        } else {
            $message = "Image size bigger than 2 MB or image type was not right . There had been no changes made";
        }

    }
} catch (Exception $exception) {
    $message = "A problem was encountered please try again";
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

    <div class="jumbotron">
        <div class="container">
            <h3><?php
                echo $message;
                header('refresh:2 ;url=profile.view.php');

                ?></h3>
        </div>
    </div>
<?php include('includes/footer.php'); ?>