<?php

include_once dirname(__FILE__) . "/../../auth.php";
include_once dirname(__FILE__) . "/../../Entites/Post.php";


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        post();
        break;

    case "PUT":
        put();
        break;

    case "DELETE":
        delete();
        break;

    default:
    case "GET":
        get();
        break;
}

function post() {
    $user = getLoggedInUser();

    var_dump($user);

    if(!$user) {
        http_response_code(403);
        return;
    }

    $body = json_decode(stream_get_contents(STDIN));
    $post = Post::create($body["title"], $body["body"], $body["photo"], $user->getId(), $body["isPrivate"]);
    
    return $post->serialize();
}

function put() {
    $user = getLoggedInUser();

    if(!$user) {
        http_response_code(403);
        return;
    }

    $post = Post::deserialize(stream_get_contents(STDIN));
    Post::update($post);

    return $post->serialize();
}

function delete() {
    $user = getLoggedInUser();

    if(!$user) {
        http_response_code(403);
        return;
    }

    if(array_key_exists("id", $_GET)) {
        $id = $_GET["id"];
        $post = Post::find($id);

        if($post) {
            Post::delete($post);
            http_response_code(202);
            return;
        }
    }

    http_response_code(204);
}

function get() {
    $user = getLoggedInUser();

    if(!$user) {
        http_response_code(403);
        return;
    }

    if(array_key_exists("id", $_GET)) {
        $id = $_GET["id"];
        $post = Post::find($id);

        if($post) {
            if($post->isPrivate() && $post->getUser() !== $user->getId()) {
                http_response_code(403);
                return;
            }

            echo $post->serialize();
        } else {
            http_response_code(404);
            return;
        }
    } else {

        $posts = Post::findByUser($user->getId());

        printf("[%s]", join(",", array_map(function(Post $post) { return $post->serialize(); }, $posts)));

    }
}