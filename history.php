<?php
include "header.php";
?>
<div class="index-info">
    <span class="info">History</span> <?php echo $db->getUserPaidSplitBillsNum($userid); ?> Entries
</div>
<?php if ($db->getUserPaidSplitBillsNum($userid) != 0): ?>
<table class="index-table">
    <thead>
        <tr>
            <th>Bill</th>
            <th>Payee</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $userBills = $db->getUserPaidSplitBills($userid);
        $type = "pay";
        foreach ($userBills as $userBill):
            $splitBillName = $db->getBillName($db->getSplitBillParent($userBill));
            $splitBillAmount = number_format($db->getSplitBillAmount($userBill), 2, '.', '');
            $splitBillPayee = $db->getUsername($db->getBillPayee($db->getSplitBillParent($userBill))); ?>
        <tr class="splitbill-row" id="splitbill-row-<?php echo $userBill; ?>">
            <td><?php echo $splitBillName; ?></td>
            <td><?php echo $splitBillPayee; ?></td>
            <td><?php
                    $date = str_replace('/', '-', $db->getBillDate($db->getSplitBillParent($userBill)));
                    echo date("d/m/Y", strtotime($date)); ?></td>
            <td>$<?php echo $splitBillAmount; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<div class="no-info">No Infomation Available</div>
<?php endif; ?>
<script src="js/index.js"></script>
<?php
include "footer.php";
?>