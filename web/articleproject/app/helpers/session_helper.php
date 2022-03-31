<?php

session_start();

function isLogedIn()
{
    return (!empty($_SESSION['user_id']));
}

function getLogginName()
{
    return $_SESSION['user_name'];
}

function getLogginId()
{
    return $_SESSION['user_id'];
}

function checkUserIdEqualToLoginId($checking_user_id)
{
    return ($checking_user_id == $_SESSION['user_id']);
}

function flash($name, $message = '', $class = 'alert alert-success')
{
    if (!empty($name))
    {
        if (empty($message))
        {// خواندن پیام:
            if (!empty($_SESSION[$name]))
            {
                $message = $_SESSION[$name];
                unset($_SESSION[$name]);
                if (!empty($_SESSION[$name . '_class']))
                {
                    $class = $_SESSION[$name . '_class'];
                    unset($_SESSION[$name . '_class']);
                }

                echo '<div class="msg-flash ' . $class . '">' . $message . '</div>';
            }
        }
        else
        {// افزودن پیام:
            if (!empty($_SESSION[$name]))
            {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name . '_class']))
            {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        }
    }
}

?>