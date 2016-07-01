<?php
session_start();
include_once dirname(__FILE__) . "/Entites/User.php";

function login($username, $password) {
    $user = User::findByUsername($username);

    if($user && $user->getPassword() === md5($password)) {
        $_SESSION["loggedinuser"] = $user->getId();

        return $user;
    }

    return false;
}

function logout() {


    if(array_key_exists("loggedinuser", $_SESSION)) {
        unset($_SESSION["loggedinuser"]);
    }
}

function getLoggedInUser() {

    if(array_key_exists("loggedinuser", $_SESSION)) {
        return User::find($_SESSION["loggedinuser"]);
    }

    return false;
}

function signup($username, $password, $avatar) {
    $user = User::findByUsername($username);

    if(!$user){
        return false;
    }

    $user = User::create($username, $password, $avatar);

    $_SESSION["loggedinuser"] = $user->getId();

    return $user;
}
