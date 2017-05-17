<nav class="navbar navbar-inverse navbar-fixed-top down-buffer">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Web security</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li><a href="index.php">Home</a></li>
                <?php if (!isset($_SESSION['user'])) {
                    echo "<li><a href='login.php'>Login</a></li>
                          <li><a href='register.php'>Register</a></li>";
                }
                ?>
                <?php if (isset($_SESSION['user']))
                    echo "<li><a href='posts.view.php'>Posts</a></li>
                          <li><a href='profile.view.php'>Profile</a></li>
                          <li><a href='logout.php'>Logout</a></li>"
                ?>
                <?php if (isset($_SESSION['user'],$_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
                    echo "<li><a href='admin.view.php'>Admin</a></li>";
                } ?>

            </ul>
        </div><!--/.nav - collapse-->
    </div>
</nav>
