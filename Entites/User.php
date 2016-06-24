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

    public static function find($id) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $user = new User();

        $user->setUsername($res["username"]);
        $user->id = $res["id"];
        $user->setAvatar($res["avatar"]);
        $user->setPassword($res["password"]);

        return $user;
    }

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

    
}