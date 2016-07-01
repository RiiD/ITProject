<?php

include_once dirname(__FILE__) . "/../../auth.php";
include_once dirname(__FILE__) . "/../../Entites/User.php";

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
        http_send_status(403);
        die();
    }

    $query = $_GET["query"];

    $friends = $user->findFriends($query);

    $serializedFriends = array_map(function(User $friend) { return json_encode($friend->serialize()); }, $friends);

    printf("[%s]", join(",", $serializedFriends));
}

function post() {
    $user = getLoggedInUser();

    if(!$user) {
        http_send_status(403);
        die();
    }

    $body = json_decode(file_get_contents("php://input"), true);
    
    $friends = Friends::create($user->getId(), $body["friend"]);

    return json_encode($friends->serialize());
}