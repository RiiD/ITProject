<?php
include_once dirname(__FILE__) . "/Entites/User.php";
include_once dirname(__FILE__) . "/Entites/PostImage.php";

define("POST_IMAGES_DIR", dirname(__FILE__) . "/public/images/post/");
define("USER_IMAGE_DIR", dirname(__FILE__) . "/public/images/user/");
define("POST_THUMB_DIR", dirname(__FILE__) . "/public/images/post/thumb/");
define("POST_THUMB_WIDTH", 150);

function redirect($url) {
    header('Location: '.$url);
    die();
}

function createThumb($origImage, $destImage, $thumbWidth) {
    $img =  imagecreatefromjpeg($origImage);

    $width = imagesx( $img );
    $height = imagesy( $img );

    $new_width = $thumbWidth;
    $new_height = floor( $height * ( $thumbWidth / $width ) );

    $tmp_img = imagecreatetruecolor( $new_width, $new_height );

    imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

    imagejpeg( $tmp_img,  $destImage );
}

function preparePost(Post $post) {
    $imgs = PostImage::findByPost($post->getId());

    $sImgs = array_map(function(PostImage $i) { return $i->serialize(); }, $imgs);

    $sPost = $post->serialize();

    $sPost["imgs"] = $sImgs;

    $user = User::find($post->getUser());
    $sUser = $user->serialize();

    $sPost["user"] = $sUser;

    return $sPost;
}