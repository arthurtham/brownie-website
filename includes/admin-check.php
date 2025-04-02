<?php
// Checks if the user is admin
$_admincheckdirname = dirname(__DIR__, 1);
require_once $_admincheckdirname . '/includes/discord.php';
require_once $_admincheckdirname . '/config.php';
if (!isset($_SESSION['user']) || 
    !check_guild_membership($guild_id) || 
    $_SESSION['user_id'] !== $turtle_id ||
    !check_roles([$turtle_role_id])
){
    if (isset($_GET["nouicheck"])) {
        echo json_encode(array("status" => "403", "message" => "Authorization error (possibly timed out of session)"));
        die();
        }
	header('HTTP/1.0 403 Forbidden');
    include($_admincheckdirname . '/error/403.php');
    die();
} elseif (isset($_GET["nouicheck"])) {
    echo json_encode(array("status" => "200", "message" => "OK"));
    die();
}
?>