<?php

/*** begin our session ***/
//session_start();

/*** set a form token ***/
$form_token = md5(uniqid('auth', true));

/*** set the session form token ***/
$_SESSION['form_token'] = $form_token;
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php') ?>
<div class="jumbotron">
    <div class="container">
        <h2>Add user</h2>
            <form action="register_submit.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" id="username" name="username" value="" maxlength="20"/>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="" maxlength="40"/>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" value="" maxlength="20"/>
            </div>
            <input type="hidden" name="form_token" value="<?php echo $form_token; ?>"/>
            <input type="hidden" name="validation"/>
            <div class="form-group">
                <input class="btn btn-default" type="submit" value="&rarr; Register"/>
            </div>
        </form>
    </div>
</div>
<?php include('includes/footer.php'); ?>