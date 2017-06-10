<?php

session_unset();

// Destroy the session.
session_destroy();
?>
<?php include('includes/header.php') ?>
<?php include('includes/navbar.php') ?>
    <div class="jumbotron">
        <div class="container">
            <h2>You are now logged out. Please come again</h2>
        </div>
    </div>
<?php header('refresh:3;url=index.php'); ?>

<?php include('includes/footer.php'); ?>