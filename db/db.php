<?php

require_once("password.php");

/**
 * Methods for database handling.
 */
class DB extends SQLite3
{

    // const DATABASE_NAME = 'todo.db';
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

    public function addGroupMember($userid, $groupid)
    {
        $sql = 'INSERT INTO groupMembers(member, groupid)
                VALUES (:member, :groupid)';
        $statement = $this->prepare($sql);
        $statement->bindValue(':member', $userid);
        $statement->bindValue(':groupid', $groupid);
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
                FROM groupMembers
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
     * @param $groupid
     * @return array of members id in given group
     */
    public function getGroupMembers($groupId)
    {
        $sql = 'SELECT member
                FROM groupMembers
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
        $sql = 'SELECT member
                FROM groupMembers
                WHERE groupId = :groupId';
        $statement = $this->prepare($sql);
        $statement->bindValue(':groupId', $groupId);
        $result = $statement->execute();
        $i = 0;
        while ($row = $result->fetchArray()) {
            $i++;
        }
        $statement->close();
        return $i;
    }

    public function createBill($userid, $name, $amount, $groupid)
    {
        $sql = 'INSERT INTO bills(name, amount, date, payee, numberOfPayers)
                VALUES (:name, :amount, :date, :userid, :numPayers)';

        $numPayers = getGroupMemberNum($groupid);
        $date = date('Y-m-d H:i:s');

        $statement = $this->prepare($sql);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':amount', $amount);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':numPayers', $numPayers);
        $statement->bindValue(':payee', $userid);

        $statement->execute();

        $statement->close();
        return true;
    }
}