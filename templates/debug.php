<?php 
if (!isset($dir)) {
    $dir = dirname(__DIR__, 1);
}
require $dir . "/templates/header.php";
?>

<div class="container body-container">

<h1 class="text-center">Debug Page</h1>
<p>Welcome to the debug page. On this page, you will see the login information for the current user. In reality though, it's the same info that you'd get if you logged in via Discord. It's nice info to have, I guess, but you could just try harder, not look at this GitHub repo, and make your own debug app to get your Discord info.</p>

<?php require $dir . "/templates/profile-box.php"; ?>

<h2> User Details :</h2>
<p> Name : <?php echo $_SESSION['username'] //. '#' . $_SESSION['discrim']; ?></p>
<!--<p> ID : <?php //echo $_SESSION['user_id']; ?></p>-->
<p> Has a sub perk role : <?php echo check_roles($sub_perk_roles) ? "true" : "false"; ?></p>
<p> Is In Turtle Pond : <?php echo check_guild_membership($guild_id) ? "true" : "false"; ?></p>
<p> Is In BrownieVAL : <?php echo check_guild_membership($brownieval_guild_id) ? "true" : "false"; ?></p>

<p> Profile Picture : <?php echo "<a href=\"get_discord_avatar_url()\">Link</a>" ?></p>
<br>
<h2>User Response :</h2>
<div class="response-block">
    <pre><?php echo json_encode($_SESSION['user'], JSON_PRETTY_PRINT); ?></pre>
</div>
<br>
<h2> User Guilds :</h2>
<div class="border" style="max-height:300px;overflow-y:auto;">
<table border="1">
    <tr>
        <th>NAME</th>
        <th>ID</th>
    </tr>
    <?php
    for ($i = 0; $i < sizeof($_SESSION['guilds']); $i++) {
        echo "<tr><td>";
        echo $_SESSION['guilds'][$i]['name'];
        echo "<td>";
        echo $_SESSION['guilds'][$i]['id'];
        echo "</td>";
        echo "</tr></td>";
    }
    ?>
</table>
</div>
<br>
<h2> User Guild Info Response :</h2>
<div class="border" style="max-height:300px;overflow-y:auto;">
<div class="response-block">
    <pre>user_guild_info: <?php echo json_encode($_SESSION['user_guild_info'], JSON_PRETTY_PRINT); ?></pre>
    <pre>user_guild_info_brownieval: <?php echo json_encode($_SESSION['user_guild_info_brownieval'], JSON_PRETTY_PRINT); ?></pre>
    <pre>roles (Turtle Pond and BrownieVAL): <?php echo json_encode($_SESSION['roles'], JSON_PRETTY_PRINT); ?></pre>
    <pre>user_connections: <?php echo json_encode($_SESSION['user_connections'], JSON_PRETTY_PRINT); ?></pre>

</div>
</div>
<br>

</div>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>