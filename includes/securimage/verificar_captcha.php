<?php
session_start();
include_once 'securimage.php';

$captcha_code = filter_input( INPUT_POST, 'captcha_code');

$securimage = new Securimage();

if ( $securimage->check($captcha_code) == false ) {
    echo "false";
} else {
    echo "ok";
}
exit;