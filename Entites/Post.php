<?php

include_once dirname(__FILE__) . "/../DB.php";

class Post
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var User
     */
    private $user;

    /**
     * @var [Comment]
     */
    private $comments;

    /**
     * @var int
     */
    private $likes = 0;

    /**
     * @var DateTime
     */
    private $createDate;

    /**
     * @var bool
     */
    private $isPrivate;

    /**
     * @return bool
     */
    public function isPrivate() {
        return $this->isPrivate;
    }

    public function setPrivate() {
        $this->isPrivate = true;
    }

    public function setPublic() {
        $this->isPrivate = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @return string
     */
    public function serialize() {
        $arr = [
            "id" => $this->getId(),
            "user" => $this->getUser(),
            "body" => $this->getBody(),
            "createDate" => $this->getCreateDate(),
            "likes" => $this->getLikes(),
            "title" => $this->getTitle(),
            "isPrivate" => $this->isPrivate()
        ];

        return $arr;
    }

    public static function deserialize($arr) {
        $post = new Post();
        $post->id = $arr["id"];
        $post->setTitle($arr["title"]);
        $post->setBody($arr["body"]);
        if(array_key_exists("isPrivate", $arr)) {
            $post->isPrivate = $arr["isPrivate"];
        } else {
            $post->isPrivate = false;
        }
        $post->setLikes($arr["likes"]);

        if(is_array($arr["user"])) {
            $post->setUser($arr["user"]["id"]);
        }else {
            $post->setUser($arr["user"]);
        }


        return $post;
    }

    /**
     * @param int $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @param $id
     * @return bool|Post
     */
    public static function find($id){
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM posts WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($res)=== 0){
            return false;
        }
        $res = $res[0];
        return static::deserialize($res);
    }

    /**
     * @param $userId
     * @return array
     */
    public static function findByUser($userId){
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM posts WHERE \"user\"=:id");
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            return static::deserialize($row);
        }, $res);
    }

    /**
     * @param $title
     * @param $body
     * @param $user
     * @param $isPrivate
     * @return Post
     */
    public static function create($title, $body, $user, $isPrivate) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO posts (title, body, \"user\", \"isPrivate\") VALUES (:title, :body, :user, :isPrivate) RETURNING *");
        $stmt->execute([
            ":title" => $title,
            ":body" => $body,
            ":user" => $user,
            ":isPrivate" => $isPrivate ? 1: 0
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return static::deserialize($res);
    }

    /**
     * @param Post $post
     * @return bool
     */
    public static function update(Post $post){
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE posts SET title=:title, body=:body, likes=:likes, \"user\"=:user, \"isPrivate\"=:isPrivate WHERE id=:id");
        return $stmt->execute([
            ":title" => $post->getTitle(),
             ":body"  => $post->getBody(),
            ":likes" => $post->getLikes(),
            ":user" => $post->getUser(),
            ":id" => $post->getId(),
            ":isPrivate" => $post->isPrivate() ? 1 : 0
        ]);
    }

    /**
     * @param Post $post
     * @return bool
     */
    public static function delete(Post $post) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("DELETE FROM posts WHERE id=:id");
        return $stmt->execute([":id" => $post->getId()]);
    }
}