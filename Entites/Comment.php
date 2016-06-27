<?php

include_once dirname(__FILE__) . "/../DB.php";

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

    /**
     * Finds comment by ID in DB. Returns Comment object if found or false if not.
     *
     * @param $id
     * @return bool|Comment
     */
    public static function find($id) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM comments WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($res) === 0) {
            return false;
        }

        $comment = new Comment();

        $comment->setBody($res["body"]);
        $comment->setLikes($res["likes"]);
        $comment->setPost($res["post"]);
        $comment->setUser($res["user"]);
        $comment->id = $res["id"];

        return $comment;
    }

    /**
     * Creates a comment in DB. Returns Comment object.
     *
     * @param $body
     * @param $post
     * @param $user
     * @return Comment
     */
    public static function create($body, $post, $user) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO comments (body, post, \"user\") VALUES (:body, :post, :user) RETURNING id");
        $stmt->execute([
            ":body" => $body,
            ":post" => $post,
            ":user" => $user
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $res["id"];

        $comment = new Comment();

        $comment->setBody($body);
        $comment->setLikes(0);
        $comment->setPost($post);
        $comment->setUser($user);
        $comment->id = $id;

        return $comment;
    }

    /**
     * Finds comment by post ID in DB. Returns array of Comment objects.
     *
     * @param $postId
     * @return array
     */
    public static function findByPost($postId) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM comments WHERE post=:post");
        $stmt->bindParam(":post", $postId);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            $comment = new Comment();

            $comment->setBody($row["body"]);
            $comment->setLikes($row["likes"]);
            $comment->setPost($row["post"]);
            $comment->setUser($row["user"]);
            $comment->id = $row["id"];

            return $comment;
        }, $res);
    }

    /**
     * Updates existing comment in DB.
     *
     * @param Comment $comment
     * @return bool
     */
    public static function update(Comment $comment) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE comments SET body=:body, post=:post, \"user\"=:post WHERE id=:id");
        return $stmt->execute([
            ":body" => $comment->getBody(),
            ":post" => $comment->getPost(),
            ":user" => $comment->getUser(),
            ":id" => $comment->getId()
        ]);
    }
}