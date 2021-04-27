<?php

define('SALT', 'a_very_random_salt_for_this_app');

/**
 * Look up the user & password pair from the text file.
 *
 * Passwords are simple md5 hashed.
 *
 * Remember, md5() is just for demonstration purposes.
 * Do not do this in production for passwords.
 *
 * @param $user string The username to look up
 * @param $pass string The password to look up
 * @return bool true if found, false if not
 */
function findUser($user, $pass)
{

    $username = 'root';
    $password = 'root';
    $port     = '8889';
    $database = 'comp3015';
    $host     = 'localhost';

    $found = false;
    $link = mysqli_connect($host, $username, $password, $database, $port);

    $query = "select * from users";

    $results = mysqli_query($link, $query);

    while( $row = mysqli_fetch_array($results)  )
    {

        $userFromMySql = $row['username'];
        $passwordFromMySql = $row['password'];

        $hash   = md5($pass . SALT);

        if($userFromMySql == $user && trim($passwordFromMySql) == $hash)
        {
            $found = true;
        }
    }

    mysqli_close($link);

    return $found;
}

/**
 * Remember, md5() is just for demonstration purposes.
 * Do not do this in production for passwords.
 *
 * @param $data
 * @return bool returns false if fopen() or fwrite() fails
 */
function saveUser($data)
{
    $success = false;

    $username = 'root';
    $password = 'root';
    $port     = '8889';
    $database = 'comp3015';
    $host     = 'localhost';

    $link = mysqli_connect($host, $username, $password, $database, $port);


    if($link != false)
    {
        $username   = trim($data['username']);
        $password   = trim($data['password']);
        $hash       = md5($password . SALT);

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";

        $results = mysqli_query($link, $sql);

        if($results)
        {
            $success = true;
        }
    }

    mysqli_close($link);

    return $success;
}

function checkUsername($username)
{
    return preg_match('/^([a-z]|[0-9]){8,15}$/i', $username);
}

/**
 * @param $data
 * @return bool
 */
function checkSignUp($data)
{
    $valid = true;

    // if any of the fields are missing
    if( trim($data['username'])        == '' ||
        trim($data['password'])        == '' ||
        trim($data['verify_password']) == '')
    {
        $valid = false;
    }
    elseif(!checkUsername(trim($data['username'])))
    {
        $valid = false;
    }
    elseif(!preg_match('/((?=.*[a-z])(?=.*[0-9])(?=.*[!?|@])){8}/', trim($data['password'])))
    {
        $valid = false;
    }
    elseif($data['password'] != $data['verify_password'])
    {
        $valid = false;
    }

    return $valid;
}

function filterUserName($name)
{
    // if it's not alphanumeric, replace it with an empty string
    return preg_replace("/[^a-z0-9]/i", '', $name);
}
