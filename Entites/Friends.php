<?php

include_once dirname(__FILE__) . "/../DB.php";

class Friends
{
    /**
     * @var int
     */
    private $friend1;

    /**
     * @var int
     */
    private $friend2;

    /**
     * @return int
     */
    public function getFriend1()
    {
        return $this->friend1;
    }

    /**
     * @param int $friend1
     */
    public function setFriend1($friend1)
    {
        $this->friend1 = $friend1;
    }

    /**
     * @return int
     */
    public function getFriend2()
    {
        return $this->friend2;
    }

    /**
     * @param int $friend2
     */
    public function setFriend2($friend2)
    {
        $this->friend2 = $friend2;
    }

    public static function create($user1, $user2) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("INSERT INTO friends (friend1, friend2) VALUES (:user1, :user2)");

        $stmt->execute([
            ":user1" => $user1,
            ":user2" => $user2
        ]);

        $friends = new Friends();

        $friends->setFriend1($user1);
        $friends->setFriend2($user2);

        return $friends;
    }

    public static function findByUser($userId){
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT users.* FROM users JOIN friends ON users.id=friends.friend2 WHERE friends.friend1=:id");
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            return User::fromArray($row);
        }, $res);
    }

    public function serialize() {
        return [
            "friend1" => $this->getFriend1(),
            "friend2" => $this->getFriend2()
        ];
    }

    public static function deserialize($arr) {
        $friends = new Friends();

        $friends->setFriend1($arr["friend1"]);
        $friends->setFriend2($arr["friend2"]);

        return $friends;
    }
}