<?php
if ($_SESSION['logged_in'] !== true || $_SESSION['user']['confirmed'] == 0) {
    header('Location:index.php');
}
include('includes/header.php');
?>

<?php include('includes/navbar.php') ?>
<div class="jumbotron">
    <div class="container">
        <h2>Add A Post</h2>
        <form action="post.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" id="title" name="title" value="" maxlength="20"/>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content"></textarea>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['user_id']; ?>"/>
            <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>"/>
            <div class="form-group">
                <input class="btn btn-default" type="submit" value="→ Submit"/>
            </div>
        </form>

    </div>
</div>
<?php include('includes/footer.php'); ?>
