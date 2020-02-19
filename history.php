<?php
include "header.php";
if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true) {
    ?>
    <div class="container">
        <!-- <div class="index-title">Overview</div> -->
        <!-- <svg width="200px" viewBox="0 0 56 56" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
               <defs>
                   <path d="M24,0 C10.746,0 0,10.745 0,24 C0,37.255 10.746,48 24,48 C37.256,48 48,37.255 48,24 C48,10.745 37.256,0 24,0 Z M23.9993115,8 C27.8673158,8 31,11.1326842 31,14.9993115 C31,18.8673158 27.8673158,22 23.9993115,22 C20.1340612,22 17,18.8673158 17,14.9993115 C17,11.1326842 20.1340612,8 23.9993115,8 Z M36.9984852,36.6354823 C33.2251223,38.1255453 28.794337,39 24.0333256,39 C19.2450478,39 14.786996,38.1148812 11,36.6083374 L11,26.5879787 C11,25.7115851 12.1103472,25 13.4812398,25 L34.5187602,25 C35.888138,25 37,25.7106156 37,26.5879787 L37,36.6354823 L36.9984852,36.6354823 Z" id="path-1"></path>
                   <filter x="-14.6%" y="-10.4%" width="129.2%" height="129.2%" filterUnits="objectBoundingBox" id="filter-2">
                       <feOffset dx="0" dy="2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                       <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                       <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" type="matrix" in="shadowBlurOuter1"></feColorMatrix>
                   </filter>
               </defs>
               <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                   <g id="name+round+user+username+icon-1320165925655613036_0" transform="translate(4.000000, 2.000000)" fill-rule="nonzero">
                       <g>
                           <use fill="black" fill-opacity="1" filter="url(#filter-2)" xlink:href="#path-1"></use>
                           <use fill="#FFFFFF" xlink:href="#path-1"></use>
                       </g>
                   </g>
               </g>
           </svg> -->
        <div class="index-info">
            <span class="info">History</span> <?php echo $db->getUserPaidSplitBillsNum($userid); ?> Entries
        </div>
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
    </div>
    <script src="js/index.js"></script>
<?php } else { ?>
    <div class="container">
        <h1 class="index-title">Sign up today to split bills easily with your mates. </h1>
        <a class="btn-draw" href="signup.php"><span>Sign up</span></a>
        <a class="btn-draw" href="signin.php"><span>Sign In</span></a>
    </div>
<?php } ?>
<?php
include "footer.php";
?>