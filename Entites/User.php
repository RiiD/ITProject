<?php

include_once "../DB.php";

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
     * @var string
     */
    private $avatar;

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
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
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

        $user = new User();

        $user->setUsername($res["username"]);
        $user->id = $res["id"];
        $user->setAvatar($res["avatar"]);
        $user->setPassword($res["password"]);

        return $user;
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

        $user = new User();

        $user->setUsername($res["username"]);
        $user->id = $res["id"];
        $user->setAvatar($res["avatar"]);
        $user->setPassword($res["password"]);

        return $user;
    }

    /**
     * Creates a user in DB. Returns User object.
     *
     * @param $username
     * @param $password
     * @param $avatar
     * @return User
     */
    public static function create($username, $password, $avatar) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO users (username, password, avatar) VALUES (:username, :password, :avatar) RETURNING id");
        $stmt->execute([
            ":username" => $username,
            ":password" => $password,
            ":avatar" => $avatar
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $res["id"];

        $user = new User();
        $user->setPassword($password);
        $user->setAvatar($avatar);
        $user->setUsername($username);
        $user->id = $id;

        return $user;
    }

    /**
     * Updates existing user in DB.
     * 
     * @param User $user
     * @return bool
     */
    public static function update(User $user) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE users SET username=:username, password=:password, avatar=:avatar WHERE id=:id");
        return $stmt->execute([
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword(),
            ":avatar" => $user->getAvatar(),
            ":id" => $user->getId()
        ]);
    }
}