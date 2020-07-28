<?php

/**
 * @param array  ...$params
 * @return string
 */
function genCsrfTime(...$params){
    $ts = time();
    array_push($params, $ts);

    return $ts . '_' . genCsrf(...$params);
}

/**
 * @param array  ...$params
 * @return string
 */
function genCsrf(...$params){
    array_push($params, SECRET);
    $params = array_map('strval', $params);
    $params = array_map('md5', $params);
    $hash_string = implode('_', $params);
    return md5($hash_string);
}

/**
 * @param $hash string
 * @param array ...$params
 * @return bool
 */
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
