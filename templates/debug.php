<h2> User Details :</h2>
<p> Name : <?php echo $_SESSION['username'] //. '#' . $_SESSION['discrim']; ?></p>
<p> ID : <?php //echo $_SESSION['user_id']; ?></p>
<p> Is Red Shell / Star : <?php echo check_roles([$sub_role_id, $vip_role_id, $override_role_id]) ? "true" : "false"; ?></p>
<p> Is In Turtle Pond : <?php echo check_guild_membership($guild_id) ? "true" : "false"; ?></p>

<p> Profile Picture : <img src="https://cdn.discordapp.com/avatars/<?php $extention = is_animated($_SESSION['user_avatar']);
                                                                    echo $_SESSION['user_id'] . "/" . $_SESSION['user_avatar'] . $extention; ?>" /></p>
<br>
<!--<h2>User Response :</h2>
<div class="response-block">
    <p><?php //echo json_encode($_SESSION['user']); ?></p>
</div>
<br>-->
<!--<h2> User Guilds :</h2>
<table border="1">
    <tr>
        <th>NAME</th>
        <th>ID</th>
    </tr>
    <?php
    /*for ($i = 0; $i < sizeof($_SESSION['guilds']); $i++) {
        echo "<tr><td>";
        echo $_SESSION['guilds'][$i]['name'];
        echo "<td>";
        echo $_SESSION['guilds'][$i]['id'];
        echo "</td>";
        echo "</tr></td>";
    }*/
    ?>
</table>
<br>-->
<!--<h2> User Guild Info Response :</h2>
<div class="response-block">
    <p> <?php //echo json_encode($_SESSION['user_guild_info']); ?></p>
    <p> <?php //echo json_encode($_SESSION['roles']); ?></p>
</div>
<br>-->