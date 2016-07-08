<?php

include_once dirname(__FILE__) . "/../DB.php";
include_once dirname(__FILE__) . "/Friends.php";
include_once dirname(__FILE__) . "/Post.php";

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var array
     */
    private $posts;



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param [Post] $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    function __toString()
    {
        return "User " . $this->getId();
    }

    /**
     * Finds user by ID in DB. Returns User object if user found or false if not.
     *
     * @param $id
     * @return bool|User
     */
    public static function find($id) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($res) === 0) {
            return false;
        }

        return  static::fromArray($res);
    }

    /**
     * Finds user by username in DB. Returns User object if user found or false if not.
     *
     * @param $username
     * @return bool|User
     */
    public static function findByUsername($username) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($res) === 0) {
            return false;
        }

        return  static::fromArray($res);
    }

    /**
     * Creates a user in DB. Returns User object.
     *
     * @param $username
     * @param $password
     * @return User
     */
    public static function create($username, $password) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password) RETURNING id");
        $stmt->execute([
            ":username" => $username,
            ":password" => md5($password)
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $res["id"];

        return static::fromArray([
            "username" => $username,
            "password" => $password,
            "id" => $id
        ]);
    }

    public static function fromArray($arr) {
        $user = new User();

        $user->setPassword($arr["password"]);
        $user->setUsername($arr["username"]);
        $user->id = $arr["id"];

        return $user;
    }

    public function getFriendsPosts() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM ((SELECT * FROM posts WHERE \"user\"=:id1 ORDER BY \"createDate\" DESC LIMIT 8) UNION (SELECT posts.* FROM friends JOIN posts ON friends.friend2=posts.\"user\" 
                                  WHERE friends.friend1=:id2 AND posts.\"isPrivate\"=FALSE ORDER BY posts.\"createDate\" DESC LIMIT 8)) AS a ORDER BY \"createDate\" DESC LIMIT 8");
        $stmt->execute([":id1" => $this->getId(), ":id2" => $this->getId()]);

        $res = $stmt->fetchAll();

        return array_map(function($row) {
            return Post::deserialize($row);
        }, $res);
    }

    public function findFriends($search){
        $conn = DB::getConnection();
        if($search == '*'){
            //all of the people who are not friends
            $stmt = $conn->prepare("SELECT * FROM users WHERE id NOT IN (SELECT users.id FROM users JOIN friends ON users.id=friends.friend2 WHERE friends.friend1=:id) AND id!=:id");
            $stmt->execute([":id" => $this->getId()]);
        }
        else{
            $stmt = $conn->prepare("SELECT * FROM users WHERE id NOT IN (SELECT users.id FROM users JOIN friends ON users.id=friends.friend2 WHERE friends.friend1=:id) AND id!=:id AND users.username LIKE :search");
            $stmt->execute([
                ":id" => $this->getId(),
                ":search" => sprintf("%%%s%%", $search)
            ]);
        }

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            return User::fromArray($row);
        }, $res);
    }

    public function serialize() {
        return [
            "id" => $this->getId(),
            "username" => $this->getUsername()
        ];
    }
}