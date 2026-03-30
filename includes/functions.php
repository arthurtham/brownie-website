<?php
/* Useful functions.
 * This file contains some useful functions for demo.
 * @author : MarkisDev
 * @copyright : https://markis.dev
 */
 
# A function to redirect user.
function redirect($url, $permanent = false)
{
    if (!headers_sent())
    {    
        if ($permanent) {
            header("HTTP/1.1 301 Moved Permanently");
        } else {
            header("HTTP/1.1 302 Found");
        }
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

// Pre PHP8 str_contains function
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

// A function to convert bytes to human readable formats. Stackoverflow 15188033
function readable_bytes_thousands($bytes) {
    if ($bytes === 0) return '0 B';
    $i = floor(log($bytes) / log(1024));

    $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

    return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 . ' ' . $sizes[$i];
}

// A function to convert binary to UUID. Generated via GitHub Copilot.
function bin_to_uuid($bin) {
    $hex = bin2hex($bin);
    return sprintf('%08s-%04s-%04s-%04s-%12s',
        substr($hex, 0, 8),
        substr($hex, 8, 4),
        substr($hex, 12, 4),
        substr($hex, 16, 4),
        substr($hex, 20));
}

// A function to check if a post ID is an old or new one
function is_new_blog_id($id) {
    return !is_numeric($id) || strlen($id) != 5;
}
?>
