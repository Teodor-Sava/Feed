<?php if ($_SESSION['logged_in'] !== true) {
    header('Location:index.php');

}

require_once('includes/functions.php');
include('includes/header.php');
include('includes/navbar.php');
?>
<style>
    .top-buffer {
        margin-top: 20px;
    }
</style>

<div class="jumbotron top-buffer">
    <div class="container">
        <?php
        displayImage();
       if($_SESSION['user']['confirmed'] == 0){
           echo '<p >To change your profile information you have to be confirmed</p>';
       }
        ?>
        <form class="form-horizontal top-buffer" method="post" action="profile.php" enctype="multipart/form-data">
            <fieldset>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Username</label>
                    <div class="col-md-4">
                        <input id="username" name="username" disabled type="text" placeholder="Username"
                               value="<?php echo $_SESSION['user']['username'] ?>"
                               class="form-control input-md">

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Old password</label>
                    <div class="col-md-4">
                        <input id="oldpassword" name="oldpassword" type="text" placeholder="Old password"
                               class="form-control input-md">

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="newpassword">New Password</label>
                    <div class="col-md-4">
                        <input id="newpassword" name="newpassword" type="text" placeholder="New password"
                               class="form-control input-md">

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="filebutton">Upload avatar</label>
                    <div class="col-md-4">
                        <input type="file" class="input-file" id="filebutton" name="image">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="singlebutton"></label>
                    <div class="col-md-4">
                        <input type="submit" <?php if($_SESSION['user']['confirmed'] == 0) echo 'disabled'; ?> id="singlebutton" name="upload" class="btn btn-default" value="→ Submit">
                    </div>
                </div>

            </fieldset>
        </form>

    </div>
</div>