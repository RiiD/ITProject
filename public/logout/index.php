<?php
include_once "../../auth.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    default:
    case "GET":
        get();
        break;
}

function get() {
    logout();

    echo "Logged out";
}
