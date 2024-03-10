<?php
/* Useful functions.
 * This file contains some useful functions for demo.
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */
 
# A function to redirect user.
function redirect($url)
{
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
        }
    else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
    }
}

# A function which returns users IP
function client_ip()
{
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		return $_SERVER['REMOTE_ADDR'];
	}
}

function start_session_custom() {
	session_start();
    // Do not allow to use too old session ID
    // if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 180) {
    //     session_destroy();
    //     session_start();
    // }
}
function regenerate_session() {
    // Call session_create_id() while session is active to 
    // make sure collision free.
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    // WARNING: Never use confidential strings for prefix!
    $newid = session_create_id('com-browntulstar-');
    // Set deleted timestamp. Session data must not be deleted immediately for reasons.
    //$_SESSION['deleted_time'] = time(); // Defined in sessiontimer.php
    // Finish session
    session_commit();
    // Make sure to accept user defined session ID
    // NOTE: You must enable use_strict_mode for normal operations.
    ini_set('session.use_strict_mode', 0);
    // Set new custom session ID
    session_id($newid);
	ini_set('session.use_strict_mode', 1);
    // Start with custom session ID
    session_start();
}

?>
