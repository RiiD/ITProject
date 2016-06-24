<?php

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
     * @var string
     */
    private $photo;

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
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
     * @param int $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }
    public static function find($id){
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM posts WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($res)=== 0){
            return false;
        }

        $post = new Post();

        $post->setTitle($res["title"]);
        $post->setBody($res["body"]);
        $post->isPrivate = $res["isPrivate"];
        $post->id = $res["id"];
        $post->setLikes($res["likes"]);
        $post->setPhoto($res["photo"]);
        $post->setUser($res["user"]);
        return $post;
    }

    public static function findByUser($userId){
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM posts WHERE \"user\"=:id");
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            $post = new Post();
            $post->setTitle($row["title"]);
            $post->setBody($row["body"]);
            $post->id = $row["id"];
            $post->isPrivate = $row["isPrivate"];
            $post->setLikes($row["likes"]);
            $post->setPhoto($row["photo"]);
            $post->setUser($row["user"]);
            return $post;
        }, $res);
    }

    public static function create($title, $body, $photo, $user, $isPrivate) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO posts (title, body, photo, \"user\") VALUES (:title, :body, :photo, :user) RETURNING id");
        $stmt->execute([
            ":title" => $title,
            ":body" => $body,
            ":user" => $user,
            ":photo" => $photo,
            ":isPrivate" => $isPrivate
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $res["id"];

        $post = new Post();
        $post->setTitle($title);
        $post->setBody($body);
        $post->setLikes(0);
        $post->setPhoto($photo);
        $post->setUser($user);
        $post->isPrivate = $isPrivate;
        $post->id = $id;
        return $post;
    }

    public static function update(Post $post){
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE posts SET title=:title
            , body=:body, likes=:likes, photo=:photo, \"user\"=:user, isPrivate=:isPrivate WHERE id=:id");
        return $stmt->execute([
            ":title" => $post->getTitle(),
             ":body"  => $post->getBody(),
            ":likes" => $post->getLikes(),
            ":photo" => $post->getPhoto(),
            ":user"  => $post->getUser(),
            ":id"    => $post->getId(),
            ":isPrivate" => $post->isPrivate()
        ]);
    }
}