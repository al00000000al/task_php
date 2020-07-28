<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 28.07.2020
 * Time: 17:26
 */


function saveComment($db, $author, $text){
    if(mb_strlen($author) > 255){
        $author = substr($author, 0, 255);
    }

    if(mb_strlen($text) > 4096){
        $text = substr($text, 0, 4096);
    }


    $db->insert('comments',[
        "author" => $author,
        "text" => $text
    ]);
}


function getCommentsDB($db){
    return $db->select("comments",'*', ["ORDER" => [
        'created_at' => 'DESC'
    ]]);
}

function getComments($db){
    $res = '';
    $data = getCommentsDB($db);
    foreach ($data as $item){
        $date = strtotime( $item['created_at'] );
        $res .= sComment(
            htmlspecialchars($item['author'], ENT_QUOTES, 'UTF-8'),
            date("H:i", $date),
            date("d.m.Y", $date),
            htmlspecialchars($item['text'], ENT_QUOTES, 'UTF-8'));
    }
    echo $res;
}

function sComment($name, $time, $date, $comment){
    return <<<HTML
<div class="comment">
            <div class="comment_header">
                <h3 class="comment_author">{$name}</h3>
                <div class="comment_time">{$time}</div>
                <div class="comment_date">{$date}</div>
            </div>
            <div class="comment_body">
                {$comment}
            </div>
        </div>
HTML;

}

function genCsrfTime(...$params){
    $ts = time();
    array_push($params, $ts);

    return $ts . '_' . genCsrf(...$params);
}

function genCsrf(...$params){
    array_push($params, SECRET);
    $params = array_map('strval', $params);
    $params = array_map('md5', $params);
    $hash_string = implode('_', $params);
    return md5($hash_string);
}

function checkCsrf($hash, ...$params){
    $hash_params = explode('_', $hash);

    if (count($hash_params) < 2) {
        return false;
    }

    $hash_lifetime = 60*60; //1 h
    $hash_ts = (int) $hash_params[0];

    $max_ts = $hash_ts + $hash_lifetime;

    if (time() > $max_ts) {
        return false; //
    }

    array_push($params, $hash_ts);
    return hash_equals(genCsrf (...$params), $hash_params[1]);

}

function pageHeader(){
    include 'pages/header.php';
}

function pageFooter(){
    include 'pages/footer.php';
}

function pageForm(){
    include 'pages/form.php';
}