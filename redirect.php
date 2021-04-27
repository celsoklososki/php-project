<?php
require 'includes/functions.php';

if(count($_POST) > 0)
{
    if($_GET['from'] == 'login')
    {
        $found = false; // assume not found
        $msg = 'It was not possible to Login! Please, try again.';

        $user = trim($_POST['username']);
        $pass = trim($_POST['password']);

        if(checkUsername($user))
        {
            $found = findUser($user, $pass, 'username');

            if($found)
            {
                session_start();
                $_SESSION['username'] = $user;
                header('Location: thankyou.php?from=login&username='.filterUserName($user));
                exit();
            }
            else
            {
                setcookie("error_message", $msg, time() + 1);
                header('Location: login.php');
                exit();
            }
        }

        header('Location: login.php');
        exit();
    }
    elseif($_GET['from'] == 'signup')
    {

        if(checkSignUp($_POST) && saveUser($_POST))
        {
            session_start();
            $_SESSION['username'] = $user;
            header('Location: thankyou.php?from=signup&username='.filterUserName(trim($_POST['username'])));
            exit();
        }
        else
        {
            $msg = 'Sorry! It was unable to sign you up at this time! Please, try again.';
            setcookie('error_message', $msg, time() + 1);
            header('Location: signup.php');
            exit();
        }
    }
}

header('Location: index.php');
exit();
