<?php
include_once("../Entites/User.php");
include_once("../Entites/Comment.php");
include_once("../Entites/Post.php");

$post = Post::create("test", "some text", "photo", 1);

$foundPost = Post::find($post->getId());

$foundByUser = Post::findByUser(1);

echo "<pre>";
print_r($foundByUser);
echo "</pre>";
