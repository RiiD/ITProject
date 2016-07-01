<?php

include_once dirname(__FILE__) . "/../../auth.php";
include_once dirname(__FILE__) . "/../../Entites/Comment.php";


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        post();
        break;

    default:
    case "GET":
        get();
        break;
}

function get() {
    $user = getLoggedInUser();

    if(!$user) {
        http_response_code(403);
        return;
    }

    if(!array_key_exists("postId", $_GET)) {
        http_response_code(400);
        return;
    }

    $postId = $_GET["postId"];

    $comments = Comment::findByPost($postId);

    $serializedComments = array_map(function(Comment $comment) { return json_encode($comment->serialize()); }, $comments);

    printf("[%s]", join(",", $serializedComments));
}

function post() {
    $user = getLoggedInUser();

    if(!$user) {
        http_response_code(403);
        return;
    }

    $body = json_decode(file_get_contents("php://input"), true);

    $comment = Comment::create($body["body"], $body["postId"], $user->getId());

    echo json_encode($comment->serialize());
}