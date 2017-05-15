<?php
if ($_SESSION['logged_in'] !== true) {
    header('Location:index.php');
}
include('includes/header.php');
require_once ('includes/functions.php');
$posts = require_once('posts.php');
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
                    <?php if($_SESSION['user']['confirmed'] !=0){ echo '<a href="addPost.php" class="btn btn-primary btn-xs pull-right">Add Post</a>'; } ?>
                    <h3 class="panel-title">Posts</h3>
                </div>
                <div class="panel-body">
                    <?php foreach ($posts as $post): ?>
                        <div class="panel panel-default top-buffer">
                            <div class="panel-heading">
                                <h2 class="panel-title"><?php echo $post['title']; ?></h2>
                            </div>
                            <div class="panel-body">
                                <p><?php echo $post['content'] ?></p>
                            </div>
                            <div class="panel-footer">
                                <?php echo "Posted by " . "@" . $post['username']; displayAvatar($post['username']) ?>
                                <a class="btn btn-default btn-xs pull-right"
                                   href="post.view.php?post_id=<?php echo $post['post_id'] ?>">Go To Post</a>
                                <?php if ($_SESSION['user']['username'] === $post['username']): ?>
                                    <a href="deletePost.php?post_id=<?php echo $post['post_id'] ?>"
                                       class='btn btn-danger btn-xs pull-right'>Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>