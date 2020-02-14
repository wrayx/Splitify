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
                            <input type="text" name="name" id="name" required>
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
                            <?php
                            $userBills = $db->getUserSplitBills($userid);
                            foreach ($userBills as $userBill):
                                $splitBillName = $db->getBillName($db->getSplitBillParent($userBill));
                                $splitBillAmount = number_format($db->getSplitBillAmount($userBill), 2, '.', '');
                                $splitBillPayee = $db->getUsername($db->getBillPayee($db->getSplitBillParent($userBill))); ?>
                                <tr>
                                    <td><?php echo $splitBillName; ?></td>
                                    <td><?php echo $splitBillPayee; ?></td>
                                    <td><?php
                                        $date = str_replace('/', '-', $db->getBillDate($db->getSplitBillParent($userBill)));
                                        echo date("d/m/Y", strtotime($date)); ?></td>
                                    <td>$<?php echo $splitBillAmount; ?>
                                        <button class="button-sm pay-btn">Pay</button>
                                    </td>
                                </tr>
                                <!-- The Pay Modal -->
                                <div class="pay-modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <span class="close"><i class="fas fa-times"></i></span>
                                        <div class="modal-header">Please Confirm Your Payment
                                            to <?php echo $splitBillPayee; ?></div>
                                        <p><b>Payment:</b> <?php echo $splitBillName; ?></p><br>
                                        <p><b>Amount:</b> $<?php echo $splitBillAmount; ?></p><br>
                                        <button class="action red">Pay</button>
                                        <button class="action blue cancel-btn">Cancel</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
                                <th>Payer</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table>
                            <tbody>
                            <?php
                            $payeeBills = $db->getUserBills($userid);
                            foreach ($payeeBills as $payeeBill):
                                $billName = $db->getBillName($payeeBill);
                                $billNum = $db->getBillNum($payeeBill) - 1;
                                $i = $billNum;
                                $childBills = $db->getChildSplitBills($payeeBill);
                                foreach ($childBills as $childBill):
                                    $childBillAmount = number_format($db->getSplitBillAmount($childBill), 2, '.', '');
                                    $childBillDate = str_replace('/', '-', $db->getBillDate($db->getSplitBillParent($childBill)));
                                    $childBillPayer = $db->getUsername($db->getSplitBillPayer($childBill));
                                    ?>
                                    <tr>
                                        <?php
                                        if ($billNum == $i) {
                                            echo "<td rowspan=" . $billNum . "><h3>" . $billName . "</h3><br><button class=\"button-sm del del-btn\">Delete</button></td>";
                                        }
                                        ?>
                                        <td><?php echo $childBillPayer; ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($childBillDate)); ?></td>
                                        <td>$<?php echo $childBillAmount; ?>
                                            <button class="button-sm confirm-btn"><i class="fas fa-check"></i></button>
                                        </td>
                                    </tr>
                                    <!--                            <!-- The Confirm Modal -->
                                    <div class="confirm-modal">
                                        <!-- Modal content -->
                                        <div class="modal-content">
                                            <span class="close"><i class="fas fa-times"></i></span>
                                            <!--                            <p>Make a Payment</p><br>-->
                                            <div class="modal-header">Please Confirm the Pending Payment</div>
                                            <p><b>Payment:</b> <?php echo $billName; ?></p><br>
                                            <p><b>Payer:</b> <?php echo $childBillPayer; ?></p><br>
                                            <p><b>Amount:</b> $<?php echo $childBillAmount; ?></p><br>
                                            <button class="action red">Confirm</button>
                                            <button class="action blue cancel-btn">Cancel</button>
                                        </div>
                                    </div>
                                    <!-- The Deletion Modal -->
                                    <div class="delete-modal">
                                        <!-- Modal content -->
                                        <div class="modal-content">
                                            <span class="close"><i class="fas fa-times"></i></span>
                                            <div class="modal-header">Confirm to Delete This Bill ?</div>
                                            <p><b>Name:</b> <?php echo $billName; ?></p><br>
                                            <p><b>Total Amount:</b> <?php echo $db->getBillAmount($payeeBill); ?></p>
                                            <br>
                                            <button class="action red">Delete</button>
                                            <button class="action blue cancel-btn">Cancel</button>
                                        </div>
                                    </div>
                                    <?php
                                    $i--;
                                endforeach;
                            endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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