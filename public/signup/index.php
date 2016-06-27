<?php
include_once "../../auth.php";

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

function post() {
    $user = signup($_POST["username"], $_POST["password"], $_POST["avatar"]);

    if(!$user) {
        echo "signup failed";
    } else {
        echo "Welcome";
    }
}
function get() {
    echo file_get_contents(dirname(__FILE__) . "/../../Templates/signup-page.html");
}
