<?php
include_once("../Entites/User.php");

$user = User::find(1);

$test = User::create("aaqqffqweqwe", "bbb", "ccc");
print_r($test);
