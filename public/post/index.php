<?php

include_once dirname(__FILE__) . "/../../auth.php";
include_once dirname(__FILE__) . "/../../utils.php";
include_once dirname(__FILE__) . "/../../Entites/Post.php";
include_once dirname(__FILE__) . "/../../Entites/PostImage.php";

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

    if(!$user) {
        http_response_code(403);
        return;
    }

    $post = Post::create($_POST["title"], $_POST["body"], $user->getId(), array_key_exists("isPrivate", $_POST));

    $imagesTmpPath = $_FILES["file"]["tmp_name"];

    foreach ($imagesTmpPath as $key => $tmpImage) {
        $new_name = POST_IMAGES_DIR . $post->getId() . "_" . $key . ".jpg";
        $new_thumb_name = POST_THUMB_DIR . $post->getId() . "_" . $key . ".jpg";

        copy($tmpImage, $new_name);

        createThumb($new_name, $new_thumb_name, POST_THUMB_WIDTH);
        PostImage::create($post->getId(), $post->getId() . "_" . $key . ".jpg");
    }

    echo json_encode(preparePost($post));
}

function put() {
    $user = getLoggedInUser();

    if(!$user) {
        http_response_code(403);
        return;
    }

    $post = Post::deserialize(json_decode(file_get_contents("php://input"), true));
    $res = Post::update($post);

    if($res) {
        http_response_code (200);
    } else {
        http_response_code (500);
    }

    echo json_encode(preparePost($post));
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

            echo json_encode(preparePost($post));
        } else {
            http_response_code(404);
            return;
        }
    } else {

        $posts = Post::findByUser($user->getId());

        $sPosts = array_map(function(Post $post) {
            return preparePost($post);
        }, $posts);

        echo json_encode($sPosts);

    }
}