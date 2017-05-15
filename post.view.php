<?php

if ($_SESSION['logged_in'] !== true) {
    header('Location:index.php');
}
include('includes/header.php');
$post = require_once('post.php');


?>
    <style>
        .top-buffer {
            margin-top: 20px;
        }
    </style>

<?php include('includes/navbar.php') ?>
    <div class="jumbotron">
        <div class="container">
            <div class="panel-body">
                <div class="panel panel-default top-buffer">
                    <div class="panel-heading">
                        <h2 class="panel-title"><?php echo $post[0]['title']; ?></h2>
                    </div>
                    <div class="panel-body">
                        <p><?php echo $post[0]['content'] ?></p>
                        <?php foreach ($post[1] as $comment): ?>

                            <div class="panel panel-default top-buffer">
                                <div class="panel-body">
                                    <p><?php echo $comment['content'] ?></p>
                                </div>
                                <div class="panel-footer">
                                    <?php echo "Posted by @".$comment['username'] ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <div class="panel-footer">
                        <?php echo "Posted by " . "@" . $post[0]['username']; ?>
                    </div>
                </div>
            </div>

            <form action="comment.php" method="post" class="col-md-12">
                <h2>Add A comment</h2>
                <div class="form-group">
                    <textarea class="form-control" id="content" name="content"></textarea>
                </div>
                <input type="hidden" name="post_id" value="<?php echo $_GET['post_id']; ?>"/>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['user_id']; ?>"/>
                <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>"/>
                <div class="form-group">
                    <input class="btn btn-default" type="submit" value="→ Submit"/>
                </div>
            </form>
        </div>
    </div>
<?php include('includes/footer.php'); ?>