<?php
include_once "../../auth.php";
include_once "../../utils.php";

define("USERNAME_UNIQUE_ERROR", 23505);

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

    try{
        $user = signup($_POST["username"], $_POST["password"]);

        if(array_key_exists("avatar", $_FILES)) {
            createThumb($_FILES["avatar"]["tmp_name"], USER_IMAGE_DIR . $user->getId() . ".jpg", 70);
        } else {
            createThumb(USER_IMAGE_DIR . "default.jpg", USER_IMAGE_DIR . $user->getId() . ".jpg", 70);
        }

        echo "Welcome";

        redirect("/");
    } catch(\PDOException $e) {
        if($e->getCode() == USERNAME_UNIQUE_ERROR) {
            echo "This username is already in use!!<br />";

            get();
        } else {
            echo "Unknown error!! Try again later<br />";
        }
    }
}
function get() {
    echo file_get_contents(dirname(__FILE__) . "/../../Templates/signup-page.html");
}
