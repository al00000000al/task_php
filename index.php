<?php
require_once 'vendor/autoload.php';

use Medoo\Medoo;

$database = new Medoo([
    // required
    'database_type' => 'mysql',
    'database_name' => DB_NAME,
    'server' => DB_SERVER,
    'username' =>  DB_USERNAME,
    'password' => DB_PASSWORD,
    ]);

if(isset($_POST['author'])
    && isset($_POST['text'])
    && isset($_POST['hash'])
){
    if(checkCsrf($_POST['hash'], 'save_comment')) {

        $author = $_POST['author'];
        $text = $_POST['text'];

        saveComment($database, $author, $text);
        header('Location: ' . $_SERVER['REQUEST_URI']);

    }

}

pageHeader();
getComments($database);
pageForm();
pageFooter();
//echo hGetComments($database);