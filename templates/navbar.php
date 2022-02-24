<?php

echo <<<NAVBAR
    <header>
    <span class="logo">Turtle Pond - Sub Perks</span>
    <span class="menu">
NAVBAR;

$auth_url = url($client_id, $redirect_url, $scopes);
if (isset($_SESSION['user'])) {
    echo '<a href="includes/logout.php"><button class="log-in">LOGOUT</button></a>';
} else {
    echo "<a href='$auth_url'><button class='log-in'>LOGIN</button></a>";
}
        
echo "</span></header>"

?>