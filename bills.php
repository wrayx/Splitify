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
                            <div class="selector"><span id="input-group">Choose a Group</span><i
                                        class="fas fa-angle-down"></i>
                                <ul class="dropdown">
                                    <?php foreach ($groups as $group): ?>
                                        <li class="group-options"><?php echo $db->getGroupName($group); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="group">
                            <div class="md-checkbox">
                                <input id="bill-self-paid" type="checkbox">
                                <label for="bill-self-paid">I've paid my part.</label><br>
                            </div>
                            <button class="button" type="submit" id="bill-submit">
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- first section bills to pay -->
        <div class="card">
            <div class="face face1 blue">
                <div class="content">
                    <h3>Bills to pay</h3>
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
                            $type = "pay";
                            foreach ($userBills as $userBill):
                                $splitBillName = $db->getBillName($db->getSplitBillParent($userBill));
                                $splitBillAmount = number_format($db->getSplitBillAmount($userBill), 2, '.', '');
                                $splitBillPayee = $db->getUsername($db->getBillPayee($db->getSplitBillParent($userBill))); ?>
                                <tr id="splitbill-row-<?php echo $userBill; ?>">
                                    <td><?php echo $splitBillName; ?></td>
                                    <td><?php echo $splitBillPayee; ?></td>
                                    <td><?php
                                        $date = str_replace('/', '-', $db->getBillDate($db->getSplitBillParent($userBill)));
                                        echo date("d/m/Y", strtotime($date)); ?></td>
                                    <td>$<?php echo $splitBillAmount; ?>
                                        <button class="button-sm pay-btn"
                                                id="<?php echo modalId($type, "trigger", $userBill); ?>">Pay
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php
                        $userBills = $db->getUserSplitBills($userid);
                        $type = "pay";
                        foreach ($userBills as $userBill):
                            $splitBillName = $db->getBillName($db->getSplitBillParent($userBill));
                            $splitBillAmount = number_format($db->getSplitBillAmount($userBill), 2, '.', '');
                            $splitBillPayee = $db->getUsername($db->getBillPayee($db->getSplitBillParent($userBill))); ?>
                            <!-- The Pay Modal -->
                            <div class="pay-modal" id="<?php echo modalId($type, "", $userBill); ?>">
                                <!-- Modal content -->
                                <div class="modal-content">
                                        <span class="close" id="<?php echo modalId($type, "close", $userBill); ?>"><i
                                                    class="fas fa-times"></i></span>
                                    <div class="modal-header">Please Confirm Your Payment
                                        to <?php echo $splitBillPayee; ?></div>
                                    <p><b>Payment:</b> <?php echo $splitBillName; ?></p><br>
                                    <p><b>Amount:</b> $<?php echo $splitBillAmount; ?></p><br>
                                    <button class="action green"
                                            id="<?php echo modalId($type, "proceed", $userBill); ?>">Pay
                                    </button>
                                    <button class="action blue cancel-btn"
                                            id="<?php echo modalId($type, "cancel", $userBill); ?>">Cancel
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!--        pending payments waiting for others to pay-->
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
                            //                            var_dump($payeeBills);
                            foreach ($payeeBills as $payeeBill):
                                $billName = $db->getBillName($payeeBill);
                                $billNum = $db->getBillNum($payeeBill) - $db->getBillPaidNum($payeeBill);
                                $i = $billNum;
                                $childBills = $db->getChildSplitBills($payeeBill);
                                foreach ($childBills as $childBill):
                                    $childBillAmount = number_format($db->getSplitBillAmount($childBill), 2, '.', '');
                                    $childBillDate = str_replace('/', '-', $db->getBillDate($db->getSplitBillParent($childBill)));
                                    $childBillPayer = $db->getUsername($db->getSplitBillPayer($childBill));
                                    ?>
                                    <tr id="splitebill-row-<?php echo $childBill; ?>">
                                        <?php if ($billNum === $i): ?>
                                            <td rowspan="<?php echo $billNum; ?>"
                                                id="bill-cell-<?php echo $payeeBill ?>"><h3><?php echo $billName ?></h3>
                                                <button class="button-sm del del-btn"
                                                        id="<?php echo modalId("delete", "trigger", $payeeBill) ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                        <td><?php echo $childBillPayer; ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($childBillDate)); ?></td>
                                        <td>$<?php echo $childBillAmount; ?>
                                            <button class="button-sm confirm-btn"
                                                    id="<?php echo modalId("confirm", "trigger", $childBill); ?>"><i
                                                        class="fas fa-check"></i></button>
                                        </td>
                                    </tr>
                                <?php $i--; endforeach;
                            endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    foreach ($payeeBills as $payeeBill):
                        $billName = $db->getBillName($payeeBill);
                        $childBills = $db->getChildSplitBills($payeeBill); ?>

                    <div class="bill-modal-wrapper">
                        <?php
                        foreach ($childBills as $childBill):
                            $childBillAmount = number_format($db->getSplitBillAmount($childBill), 2, '.', '');
                            $childBillDate = str_replace('/', '-', $db->getBillDate($db->getSplitBillParent($childBill)));
                            $childBillPayer = $db->getUsername($db->getSplitBillPayer($childBill));
                            ?>
                            <div class="confirm-modal" id="<?php echo modalId("confirm", "", $childBill); ?>">
                                <!-- Modal content -->
                                <div class="modal-content">
                                                <span class="close"
                                                      id="<?php echo modalId("confirm", "close", $childBill); ?>"><i
                                                        class="fas fa-times"></i></span>
                                    <!--                            <p>Make a Payment</p><br>-->
                                    <div class="modal-header">Please Confirm the Pending Payment</div>
                                    <p><b>Payment:</b> <?php echo $billName; ?></p><br>
                                    <p><b>Payer:</b> <?php echo $childBillPayer; ?></p><br>
                                    <p><b>Amount:</b> $<?php echo $childBillAmount; ?></p><br>
                                    <button class="action green"
                                            id="<?php echo modalId("confirm", "proceed", $childBill); ?>">
                                        Proceed
                                    </button>
                                    <button class="action blue cancel-btn"
                                            id="<?php echo modalId("confirm", "cancel", $childBill); ?>">Cancel
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- The Deletion Modal -->
                        <div class="delete-modal" id="<?php echo modalId("delete", "", $payeeBill); ?>">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <span class="close" id="<?php echo modalId("delete", "close", $payeeBill); ?>"><i
                                        class="fas fa-times"></i></span>
                                <div class="modal-header">Confirm to Delete This Bill ?</div>
                                <p><b>Name:</b> <?php echo $billName; ?></p><br>
                                <p><b>Total Amount:</b>
                                    $<?php echo number_format($db->getBillAmount($payeeBill), 2, '.', ''); ?></p>
                                <br>
                                <button class="action red"
                                        id="<?php echo modalId("delete", "proceed", $payeeBill); ?>">Delete
                                </button>
                                <button class="action blue cancel-btn"
                                        id="<?php echo modalId("delete", "cancel", $payeeBill); ?>">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="js/bills.js" type="module"></script>
    <?php
} else {
    header('Location: signin.php');
}
include "footer.php";
?>