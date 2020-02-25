<?php
include "header.php";
?>
    <h1 class="landing-title"><?php echo $title; ?></h1>
    <div class="landing-form">
        <form action="includes/signup.inc.php" method="POST">
            <div class="group first-group">
                <input type="text" required value="<?php if (isset($_GET['username'])) echo $_GET['username']; ?>"
                       name="username">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Username</label>
            </div>
            <div class="group">
                <input type="text" value="<?php if (isset($_GET['useremail'])) echo $_GET['useremail']; ?>" name="email"
                       required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>E-mail</label>
            </div>
            <div class="group">
                <input type="password" required name="pwd">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>
            <div class="group">
                <input type="password" required name="re-pwd">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Repeat Password</label>
            </div>
            <div class="group">
                <button class="button fill" name="signup-submit" type="submit">
                    <span class="text">Sign up</span>
                </button>
            </div>
        </form>
    </div>
<?php
include "footer.php"
?>