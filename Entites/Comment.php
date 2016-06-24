<?php

include("../DB.php");

class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Post
     */
    private $post;

    /**
     * @var int
     */
    private $likes;

    /**
     * @var string
     */
    private $body;

    /**
     * @var DateTime
     */
    private $createDate;

    /**
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
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

    static public function find($id) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM comments WHERE id=:id");
        $stmt->bindParam(":id", $id);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return $res;
    }
}