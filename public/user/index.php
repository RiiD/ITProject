<?php

include_once dirname(__FILE__) . "/../../auth.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
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

    echo json_encode($user->serialize());
}