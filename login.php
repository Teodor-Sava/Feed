<?php
$form_token = md5(uniqid('auth', true));


$_SESSION['form_token'] = $form_token;

if ($_SESSION['logged_in'] === true) {
    header('Location:index.php');
}
include('includes/header.php');
?>


<?php include('includes/navbar.php') ?>
<div class="jumbotron">
    <div class="container">
        <h2>Login Here</h2>
        <form action="login_submit.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" id="username" name="username" value="" maxlength="20"/>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" value="" maxlength="20"/>
            </div>
            <div class="form-group">
                <input class="btn btn-default" type="submit" value="→ Login"/>
            </div>
            <input type="hidden" name="form_token" value="<?php echo $form_token; ?>"/>
        </form>

    </div>
</div>
<?php include('includes/footer.php'); ?>
