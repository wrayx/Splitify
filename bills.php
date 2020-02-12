<?php
include "header.php";
if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true) {
    ?>
    <div class="container">
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <h3>Add a Bill</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <form action="includes/bills.inc.php" method="POST">
                        <div class="group">
                            <input type="text" name="name" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Name</label>
                        </div>
                        <div class="group">
                            <input type="text" name="amount" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Amount</label>
                        </div>
                        <!--                        <div class="group">-->
                        <!--                            <input type="text" name="people" required>-->
                        <!--                            <span class="highlight"></span>-->
                        <!--                            <span class="bar"></span>-->
                        <!--                            <label>people</label>-->
                        <!--                        </div>-->
                        <div class="group">
                            <div class="selector"><span>Choose a Group</span><i class="fas fa-angle-down"></i>
                                <ul class="dropdown">
                                    <li class="active"><a href="#">Group 1</a></li>
                                    <li><a href="#">Group 2</a></li>
                                    <li><a href="#">Group 3</a></li>
                                    <li><a href="#">Group 4</a></li>
                                </ul>
                            </div>
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
                    <h3>Bills</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <div class="tbl-header">
                        <table>
                            <thead>
                            <tr>
                                <th>Bill</th>
                                <th>Payee</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table>
                            <tbody>
                            <tr>
                                <td>AAC</td>
                                <td>AUSTRALIAN COMPANY</td>
                                <td>$1.38</td>
                            </tr>
                            <tr>
                                <td>AAD</td>
                                <td>AUSENCO</td>
                                <td>$2.38</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <h3>Pending Payments</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <div class="tbl-header">
                        <table>
                            <thead>
                            <tr>
                                <th>Bill</th>
                                <th>Payee</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table>
                            <tbody>
                            <tr>
                                <td>AAC</td>
                                <td>AUSTRALIAN COMPANY</td>
                                <td>$1.38</td>
                            </tr>
                            <tr>
                                <td>AAD</td>
                                <td>AUSENCO</td>
                                <td>$2.38</td>
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
include "footer.php";
?>