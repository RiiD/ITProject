<?php


class PostImage
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $post;

    /**
     * @return int
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param int $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public static function create($post, $name) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO post_photos (post, name) VALUES (:post, :name) RETURNING id, post, name");
        $stmt->execute([
            ":post" => $post,
            ":name" => $name
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return static::deserialize($res);
    }

    public static function findByPost($postId) {
        $conn = DB::getConnection();

        $stmt = $conn->prepare("SELECT * FROM post_photos WHERE post_photos.post=:id");
        $stmt->bindParam(":id", $postId);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            return static::deserialize($row);
        }, $res);
    }

    public function serialize() {
        return [
            "id" => $this->getId(),
            "post" => $this->getPost(),
            "name" => $this->getName()
        ];
    }

    public static function deserialize($arr) {
        $image = new PostImage();
        $image->setPost($arr["post"]);
        $image->setName($arr["name"]);
        $image->id = $arr["id"];

        return $image;
    }
}