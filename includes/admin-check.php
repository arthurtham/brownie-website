<?php
// Checks if the user is admin
if (!isset($_SESSION['user'])) {
    $auth_url = url($client_id, $redirect_url, $scopes);
	header('HTTP/1.0 403 Forbidden');
    die("Error: No userauth <a href=$auth_url'>Login</a>");
} else if (
    !check_guild_membership($guild_id) || 
    $_SESSION['user_id'] !== $turtle_id ||
    !check_roles([$turtle_role_id])
){
	header('HTTP/1.0 403 Forbidden');
    die("Error: Login criteria failed");
}
?>