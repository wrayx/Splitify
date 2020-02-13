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

//    protected function getUserResource($type, $userInfo)
//    {
//        if ($type == 'userid') {
//            $sql = 'SELECT userid
//                    FROM   users
//                    WHERE  username = :userInfo
//                    OR useremail = :userInfo';
//        } else if ($type == 'userPwd') {
//            $sql = 'SELECT userpwd
//                FROM   users
//                WHERE  username = :userInfo
//                OR useremail = :userInfo';
//        }
//
//        $statement = $this->prepare($sql);
//        $statement->bindValue(':userInfo', $userInfo);
//
//        $result = $statement->execute();
//        $row = $result->fetchArray();
//
//        if ($type == 'userid') {
//            $userResource = $row['userid'];
//        } else if ($type == 'userPwd') {
//            $userResource = $row['userpwd'];
//        }
//
//        $statement->close();
//        return $userResource;
//    }

    protected function getUserPwd($userInfo){
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

    public function getUserId($userInfo){
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

    public function createGroup($name){
        $sql = 'INSERT INTO groups(name)
                VALUES (:name)';
        $statement = $this->prepare($sql);
        $statement->bindValue(':name', $name);
        $statement->execute();

        $statement->close();
    }

    public function addGroupMember($userid, $groupid){
        $sql = 'INSERT INTO groupMembers(member, groupid)
                VALUES (:member, :groupid)';
        $statement = $this->prepare($sql);
        $statement->bindValue(':member', $userid);
        $statement->bindValue(':groupid', $groupid);
        $statement->execute();

        $statement->close();
    }

    public function getGroupId($name){
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
}