<?php
include "header.php";
if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true) {
    ?>
    <div class="container">
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <h3>Create a Group</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <form action="includes/groups.inc.php" method="POST">
                        <div class="group">
                            <input type="text" name="name" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Name</label>
                        </div>
                        <div class="group">
                            <input type="text" name="member-email" class="member-email" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Member E-mail</label>
                        </div>
                        <div class="group">
                            <span id="add-member-input"><i class="fas fa-user-plus"></i></span>
                        </div>
                        <div class="group">
                            <button class="button" name="submit" type="submit">
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <h3>Group 1</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <div class="tbl-header">
                        <table>
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>E-mail</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>xiao ming</td>
                                <td>123@example.com</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>xiao mei</td>
                                <td>123@example.com</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}
else {
    header('Location: signin.php');
}
include "footer.php"
?>