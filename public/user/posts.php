<?php

include_once dirname(__FILE__) . "/../../auth.php";
include_once dirname(__FILE__) . "/../../Entites/Post.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    default:
    case "GET":
        get();
        break;
}

function get() {
    $user = getLoggedInUser();
    
    $posts = $user->getFriendsPosts();
    
    $serializedPosts = array_map(function(Post $post) { return $post->serialize(); }, $posts);

    printf("[%s]", join(",", $serializedPosts));
}