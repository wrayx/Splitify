<?php

require_once("password.php");

/**
 * Methods for database handling.
 */
class DB extends SQLite3
{
    private $filename;
    const BCRYPT_COST = 14;

    public function __construct($filename)
    {
        $this->$filename = $filename;
        $this->open($this->$filename);
    }

    public function authenticateUser($usernameOrEmail, $pwd)
    {
        if ($this->userExists($usernameOrEmail)) {
            $storedPwd = $this->getUserPwd($usernameOrEmail);
            // authenticate pwd
            if (password_verify($pwd, $storedPwd)) {
                $authenticated = true;
            } else {
                $authenticated = false;
            }
        } else {
            $authenticated = false;
        }

        return $authenticated;
    }

    public function userExists($usernameOrEmail)
    {
        $sql = 'SELECT COUNT(*) AS count
                FROM   users
                WHERE  username = :userInfo
                OR email = :userInfo';

        $statement = $this->prepare($sql);
        $statement->bindValue(':userInfo', $usernameOrEmail);

        $result = $statement->execute();
        $row = $result->fetchArray();

        $exists = ($row['count'] === 1) ? true : false;

        $statement->close();

        return $exists;
    }

    protected function getUserPwd($userInfo)
    {
        $sql = 'SELECT pwd
                FROM users
                WHERE username = :userInfo
                OR email = :userInfo';
        $statement = $this->prepare($sql);
        $statement->bindValue(':userInfo', $userInfo);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $userPwd = $row['pwd'];
        $statement->close();
        return $userPwd;
    }

    public function getUserId($userInfo)
    {
        $sql = 'SELECT id
                FROM users
                WHERE username = :userInfo
                OR email = :userInfo';
        $statement = $this->prepare($sql);
        $statement->bindValue(':userInfo', $userInfo);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $userId = $row['id'];
        $statement->close();
        return $userId;
    }

    public function getUserEmail($id)
    {
        $sql = 'SELECT email
                FROM users
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $email = $row['email'];
        $statement->close();
        return $email;
    }

    public function getUsername($id)
    {
        $sql = 'SELECT username
                FROM users
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $username = $row['username'];
        $statement->close();
        return $username;
    }

    public function createUser($username, $email, $pwd)
    {
        $sql = 'INSERT INTO users(username, email, pwd)
                VALUES (:username, :email, :pwd)';

        $options = array('cost' => self::BCRYPT_COST);
        $hashedpwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

        $statement = $this->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':pwd', $hashedpwd);

        $statement->execute();

        $statement->close();
        return true;
    }

    public function createGroup($name)
    {
        $sql = 'INSERT INTO groups(name)
                VALUES (:name)';
        $statement = $this->prepare($sql);
        $statement->bindValue(':name', $name);
        $statement->execute();

        $statement->close();
    }

    public function getGroupId($name)
    {
        $sql = 'SELECT id
                FROM groups
                WHERE name = :name';
        $statement = $this->prepare($sql);
        $statement->bindValue(':name', $name);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $userId = $row['id'];
        $statement->close();
        return $userId;
    }

    public function getGroupName($id)
    {
        $sql = 'SELECT name
                FROM groups
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $name = $row['name'];
        $statement->close();
        return $name;
    }

    public function getGroups($userid)
    {
        $sql = 'SELECT groupid
                FROM members
                WHERE member = :userid';
        $statement = $this->prepare($sql);
        $statement->bindValue(':userid', $userid);
        $result = $statement->execute();
        $res = array();
        while ($row = $result->fetchArray()) {
            array_push($res, $row['groupId']);
        }
        $statement->close();
        return $res;
    }

    /**
     * @param $groupId
     * @return array of members id in given group
     */
    public function getGroupMembers($groupId)
    {
        $sql = 'SELECT member
                FROM members
                WHERE groupId = :groupId';
        $statement = $this->prepare($sql);
        $statement->bindValue(':groupId', $groupId);
        $result = $statement->execute();
        $res = array();
        while ($row = $result->fetchArray()) {
            array_push($res, $row['member']);
        }
        $statement->close();
        return $res;
    }

    public function getGroupMemberNum($groupId)
    {
        $sql = 'SELECT COUNT(*) AS count
                FROM members
                WHERE groupId = :groupId';
        $statement = $this->prepare($sql);
        $statement->bindValue(':groupId', $groupId);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $res = $row['count'];
        $statement->close();
        return $res;
    }

    public function addGroupMember($userid, $groupid)
    {
        $sql = 'INSERT INTO members(member, groupId)
                VALUES (:member, :groupid)';
        $statement = $this->prepare($sql);
        $statement->bindValue(':member', $userid);
        $statement->bindValue(':groupid', $groupid);
        $statement->execute();

        $statement->close();
    }

    public function deleteGroupMember($userid, $groupid)
    {
        $sql = 'DELETE FROM members
                WHERE member = :userid
                AND groupId = :groupid';

        $statement = $this->prepare($sql);
        $statement->bindValue(':userid', $userid);
        $statement->bindValue(':groupid', $groupid);
        $statement->execute();

        $statement->close();
    }

    public function deleteGroup($id)
    {
        $members = $this->getGroupMembers($id);
//        var_dump($members);
        foreach($members as $member){
            $this->deleteGroupMember($member, $id);
        }

        $sql = 'DELETE FROM groups
                WHERE id = :id';

        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $statement->close();
    }

    public function createBill($userid, $name, $amount, $groupid)
    {
        $sql = 'INSERT INTO bills(name, amount, createdate, payee, num, status)
                VALUES (:name, :amount, :createdate, :userid, :num, :status)';

        $numPayers = $this->getGroupMemberNum($groupid);
        $createdate = date('d/m/Y h:m:s');

        $statement = $this->prepare($sql);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':amount', $amount);
        $statement->bindValue(':createdate', $createdate);
        $statement->bindValue(':num', $numPayers);
        $statement->bindValue(':userid', $userid);
        $statement->bindValue(':status', 0);

        $statement->execute();
        $statement->close();

        $billId = $this->getBillId($name);
        $groupMembers = $this->getGroupMembers($groupid);
        $groupNum = $this->getGroupMemberNum($groupid);
        $splitAmount = ((float)$amount) / $groupNum;
        foreach ($groupMembers as $member) {
            $this->createSplitBill($billId, $member, $splitAmount);
            $this->sendBillNotification($this->getUserEmail($member), $this->getUsername($userid), $splitAmount, $createdate);
        }
    }

    public function sendBillNotification($email, $payeeName, $amount, $date){
        $to      =  $email;
        $subject = 'Splitify Notification';
        $message = '
        <h1>Payment Notification</h1>
        <p><strong>Payee: </strong>'.$payeeName.'</p>
        <p><strong>Amount: </strong>$'.number_format($amount, 2, '.', '').'</p>
        <p><strong>Date Added: </strong>'.date("d/m/Y", strtotime($date)).'</p>
        <a href="http://cs139.dcs.warwick.ac.uk/~u1915472/cs139/cs139_coursework/signin.php">Complete Payment</a>';

        $headers = 'From: noreply@splitify.com' . "\r\n" .
            'Reply-To: reply@splitify.com' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n".
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    public function getBillId($name)
    {
        $sql = 'SELECT id
                FROM bills
                WHERE name = :name';
        $statement = $this->prepare($sql);
        $statement->bindValue(':name', $name);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $res = $row['id'];
        $statement->close();
        return $res;
    }

    public function getBillPaidNum($parent)
    {
        $sql = 'SELECT COUNT(*) AS count
                FROM splitbills
                WHERE parent = :parent
                AND status = 1';
        $statement = $this->prepare($sql);
        $statement->bindValue(':parent', $parent);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $res = $row['count'];
        $statement->close();
        return $res;
    }

    protected function getBillData($header, $id)
    {
        $sql = 'SELECT *
                FROM bills
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $res = $row[$header];
        $statement->close();
        return $res;
    }

    public function getBillNum($id)
    {
        return $this->getBillData('num', $id);
    }

    public function getBillAmount($id)
    {
        return $this->getBillData('amount', $id);
    }

    public function getBillName($id)
    {
        return $this->getBillData('name', $id);
    }

    public function getBillPayee($id)
    {
        return $this->getBillData('payee', $id);
    }

    public function getBillDate($id)
    {
        return $this->getBillData('createdate', $id);
    }

    public function getBillPercentage($id)
    {
        return $this->getBillData('status', $id);
    }

    public function getUserBills($userid)
    {
        $sql = 'SELECT id
                FROM bills
                WHERE payee = :userid
                AND status < 100';
        $statement = $this->prepare($sql);
        $statement->bindValue(':userid', $userid);
        $result = $statement->execute();
        $res = array();
        while ($row = $result->fetchArray()) {
            array_push($res, $row['id']);
        }
        $statement->close();
        return $res;
    }

    public function deleteBill($id)
    {
        $sql = 'DELETE FROM bills
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->close();
        $this->deleteSplitBills($id);
    }

    public function createSplitBill($parent, $payer, $amount)
    {
        $sql = 'INSERT INTO splitbills(parent, payer, amount)
                VALUES (:parent, :payer, :amount)';
        $statement = $this->prepare($sql);
        $statement->bindValue(':parent', $parent);
        $statement->bindValue(':amount', $this->format($amount));
        $statement->bindValue(':payer', $payer);

        $statement->execute();
        $statement->close();
    }

    public function deleteSplitBills($parent)
    {
        $sql = 'DELETE FROM splitbills
                WHERE parent = :parent';
        $statement = $this->prepare($sql);
        $statement->bindValue(':parent', $parent);
        $statement->execute();
        $statement->close();
    }

    public function getUserSplitBills($userid)
    {
        $sql = 'SELECT id
                FROM splitbills
                WHERE payer = :userid
                AND status = 0';
        $statement = $this->prepare($sql);
        $statement->bindValue(':userid', $userid);
        $result = $statement->execute();
        $res = array();
        while ($row = $result->fetchArray()) {
            array_push($res, $row['id']);
        }
        $statement->close();
        return $res;
    }

    public function getChildSplitBills($parent)
    {
        $sql = 'SELECT id
                FROM splitbills
                WHERE parent = :parent
                AND status = 0';
        $statement = $this->prepare($sql);
        $statement->bindValue(':parent', $parent);
        $result = $statement->execute();
        $res = array();
        while ($row = $result->fetchArray()) {
            array_push($res, $row['id']);
        }
        $statement->close();
        return $res;
    }

    public function getSplitBillid($parent, $userid)
    {
        $sql = 'SELECT id
                FROM splitbills
                WHERE parent = :parent
                AND payer = :userid';
        $statement = $this->prepare($sql);
        $statement->bindValue(':parent', $parent);
        $statement->bindValue(':userid', $userid);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $res = $row['id'];
        $statement->close();
        return $res;
    }

    protected function getSplitBillData($header, $id)
    {
        $sql = 'SELECT *
                FROM splitbills
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':header', $header);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $res = $row[$header];
        $statement->close();
        return $res;
    }

    public function getSplitBillAmount($id)
    {
        return $this->getSplitBillData('amount', $id);
    }

    public function getSplitBillParent($id)
    {
        return $this->getSplitBillData('parent', $id);
    }

    public function getSplitBillPayer($id)
    {
        return $this->getSplitBillData('payer', $id);
    }

    public function getSplitBillStatus($id)
    {
        return $this->getSplitBillData('status', $id);
    }

    public static function format($amount)
    {
        return number_format((float)$amount, 2, '.', '');
    }

    public function paySplitBill($id)
    {
        $parent = $this->getSplitBillParent($id);

        $sql = 'SELECT status
                FROM bills
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $parent);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $billPercentage = $row['status'];
        $statement->close();

        $billNum = $this->getBillNum($parent);
        $billPercentage = $billPercentage + floor(100 / $billNum);
//        echo $billPercentage;

        $sql = 'UPDATE bills
                SET status = :status
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':status', $billPercentage);
        $statement->bindValue(':id', $parent);
        $statement->execute();
        $statement->close();

        $sql = 'UPDATE splitbills
                SET status = :status
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':status', 1);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->close();

        $this->matchBillStatus($parent);
    }

    public function matchBillStatus($parent)
    {
        $sql = 'SELECT status
                FROM splitbills
                WHERE parent = :parent';
        $statement = $this->prepare($sql);
        $statement->bindValue(':parent', $parent);
        $result = $statement->execute();
        $allStatus = array();
        while ($row = $result->fetchArray()) {
            array_push($allStatus, $row['status']);
        }
        $statement->close();
        foreach ($allStatus as $status) {
            if ($status === 0)
                exit();
        }

        $sql = 'UPDATE bills
                SET status = :status
                WHERE id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':status', 100);
        $statement->bindValue(':id', $parent);
        $statement->execute();
        $statement->close();
    }
}