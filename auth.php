<?php

include_once dirname(__FILE__) . "/Entites/User.php";

function login($username, $password) {
    $user = User::findByUsername($username);

    if($user && $user->getPassword() === md5($password)) {
        session_start();
        $_SESSION["loggedinuser"] = $user->getId();

        return $user;
    }

    return false;
}

function logout() {
    session_start();

    if(array_key_exists("loggedinuser", $_SESSION)) {
        unset($_SESSION["loggedinuser"]);
    }
}

function getLoggedInUser() {
    session_start();

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

    session_start();
    $_SESSION["loggedinuser"] = $user->getId();

    return $user;
}
