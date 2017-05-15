<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php') ?>

<style>
    .top-buffer {
        margin-top: 20px;
    }
</style>

<div class="jumbotron">
    <div class="container">


        <div class="panel panel-default top-buffer">
            <div class="panel-heading">
                <h3 class="panel-title"><?php if (isset($_SESSION['user'])) {
                        echo ucfirst($_SESSION['user']['username']) . "'s ";
                    }
                    ?>Dashboard</h3>
            </div>
            <div class="panel-body">
                <h2><?php echo $message; ?></h2>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['confirmed'] != 0) {
                    foreach ($postText as $post): ?>
                        <div class="panel panel-default top-buffer">
                            <div class="panel-heading">
                                <h2 class="panel-title"><?php echo $post['title']; ?></h2>
                            </div>
                            <div class="panel-body">
                                <p><?php echo $post['content'] ?></p>
                            </div>
                            <div class="panel-footer">
                                <?php echo "Posted by " . "@" . $post['username']; ?>
                                <a class="btn btn-default btn-xs pull-right"
                                   href="post.view.php?post_id=<?php echo $post['post_id'] ?>">Go To Post</a>
                            </div>
                        </div>
                    <?php endforeach;
                } ?>
                <?php if ($_SESSION['logged_in'] === false) {

                    echo "<br/><h3>" . "<a href='login.php'>" . "Click to go to login " . "</a></h3>";

                } ?>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
