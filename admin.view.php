<?php
if ($_SESSION['logged_in'] !== true && $_SESSION['user']['role'] != 'admin') {
    header('Location:index.php');
}
include('includes/header.php');
require_once ('includes/functions.php');
$users = users();

?>
    <style>
        .top-buffer {
            margin-top: 20px;
        }
    </style>

<?php include('includes/navbar.php') ?>
    <div class="jumbotron">
        <div class="container">
            <div class="panel panel-default top-buffer">
                <div class="panel-heading">
                    <h3 class="panel-title">Users</h3>
                </div>
                <div class="panel-body">
                    <?php foreach ($users as $user): ?>
                        <div class="panel panel-default top-buffer">
                            <div class="panel-body">
                                <p><?php echo $user['username'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>