<?php
include "header.php";
$groups = $db->getGroups($userid);
if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true) {
    ?>
    <div class="container">
        <div class="card">
            <div class="face face1 green">
                <div class="content">
                    <h3>Add a Bill</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <form id="bill-form" action="includes/bills.inc.php" method="POST">
                        <div class="group">
                            <input type="text" name="name" id="name"required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Name</label>
                        </div>
                        <div class="group">
                            <input type="text" name="amount" id="amount" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Amount</label>
                        </div>
                        <div class="group">
                            <div class="selector"><span id="input-group">Choose a Group</span><i class="fas fa-angle-down"></i>
                                <ul class="dropdown">
                                    <?php foreach ($groups as $group): ?>
                                    <li class="group-options"><?php echo $db->getGroupName($group); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="group">
                            <button class="button" type="submit">
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1 blue">
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
                                <th>Date</th>
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
                                <td>01/02/2020</td>
                                <td>$1.38<button class="button-sm pay-btn">Pay</button></td>
                            </tr>
                            <tr>
                                <td>AAD</td>
                                <td>AUSENCO</td>
                                <td>01/02/2020</td>
                                <td>$2.38<button class="button-sm pay-btn">Pay</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1 blue">
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
                                <th></th>
                                <th>Payee</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table>
                            <tbody>
                            <tr>
                                <td rowspan="2"><h3>Internet</h3><br><button class="button-sm del del-btn">Delete</button></td>
                                <td>AUSTRALIAN COMPANY</td>
                                <td>01/02/2020</td>
                                <td>$1.38<button class="button-sm confirm-btn"><i class="fas fa-check"></i></button></td>
                            </tr>
                            <tr>
                                <td>AUSENCO</td>
                                <td>01/02/2020</td>
                                <td>$2.38<button class="button-sm confirm-btn"><i class="fas fa-check"></i></button></td>
                            </tr>
                            <tr>
                                <td rowspan="2"><h3>Electricity</h3><br><button class="button-sm del del-btn">Delete</button></td>
                                <td>AUSTRALIAN COMPANY</td>
                                <td>01/02/2020</td>
                                <td>$1.38<button class="button-sm confirm-btn"><i class="fas fa-check"></i></button></td>
                            </tr>
                            <tr>
                                <td>AUSENCO</td>
                                <td>01/02/2020</td>
                                <td>$2.38<button class="button-sm confirm-btn"><i class="fas fa-check"></i></button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Pay Modal -->
    <div class="pay-modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close"><i class="fas fa-times"></i></span>
            <!--                            <p>Make a Payment</p><br>-->
            <h3>Please Confirm Your Payment</h3><br>
            <p>Payment: xxx</p><br>
            <p>Amount: 18.00</p><br>
            <button class="action red">Pay</button>
            <button class="action blue cancel-btn">Cancel</button>
        </div>
    </div>
    <!-- The Confirm Modal -->
    <div class="confirm-modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close"><i class="fas fa-times"></i></span>
            <!--                            <p>Make a Payment</p><br>-->
            <h3>Please Confirm the Pending Payment</h3><br>
            <p>Payment: xxx</p><br>
            <p>Payee: xxx</p><br>
            <p>Amount: 10.00</p><br>
            <button class="action red">Confirm</button>
            <button class="action blue cancel-btn">Cancel</button>
        </div>
    </div>
    <!-- The Deletion Modal -->
    <div class="delete-modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close"><i class="fas fa-times"></i></span>
            <!--                            <p>Make a Payment</p><br>-->
            <h3>Confirm to Delete This Bill ?</h3><br>
            <p>Name: xxx</p><br>
            <p>Amount: 30.00</p><br>
<!--            <button class="modal-confirm-btn">Delete</button>-->
<!--            <button class="modal-confirm-btn">Cancel</button>-->
            <button class="action red">Delete</button>
            <button class="action blue cancel-btn">Cancel</button>
        </div>
    </div>
    <script src="js/bills.js"></script>
    <?php
}
else {
        header('Location: signin.php');
    }
include "footer.php";
?>