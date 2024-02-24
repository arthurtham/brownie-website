<?php
echo '<div class="d-flex align-items-center justify-content-center flex-direction: column" style="padding-bottom:50px">';
echo '<div class="box bg-light bg-gradient shadow" style="padding: 40px; border-radius: 10%">';
echo '<center><div class="card" style="width:auto;max-width:400px;padding-top:20px"><center>';
if (isset($_SESSION['user_avatar'])) {
    echo '<img class="rounded border" src="https://cdn.discordapp.com/avatars/';
    $extention = is_animated($_SESSION['user_avatar']);
    echo $_SESSION['user_id'] . "/" . $_SESSION['user_avatar'] . $extention;
} else {
    echo '<img class="rounded border" src="https://cdn.discordapp.com/embed/avatars/0.png"';
}
echo '" class="card-img-top" alt="..."/ style="width:auto;max-width:100px;"></center>';
echo '<div class="card-body"><h5 class="card-title">' . $_SESSION["username"] . '</h5>';
if (!check_roles($sub_perk_roles)) {
    echo '<h5><span class="badge bg-dark" style="width:100%">Big Fan</span></h5>';
}
else {
    if (check_roles([$sub_role_id])) {
        echo '<h5><span class="badge bg-danger" style="width:100%">RED SHELLS (Twitch Subs)</span></h5>';
    }
    if (check_roles([$discord_sub_role_id])) {
        echo '<h5><span class="badge bg-danger" style="width:100%">RED SHELLS (Discord Subs)</span></h5>';
    }
    if (check_roles([$kofi_role_id])) {
        echo '<h5><span class="badge bg-danger" style="width:100%">RED SHELLS (Ko-fi)</span></h5>';
    }
    if (check_roles([$vip_role_id])) {
        echo '<h5><span class="badge bg-warning" style="width:100%">STARS (VIP Access)</span></h5>';
    }
    if (check_roles([$mod_role_id])) {
        echo '<h5><span class="badge bg-info" style="width:100%">BLUE SHELLS (Mods)</span></h5>';
    }
    
    
}
echo check_guild_membership($guild_id) ? '<h5><span class="badge bg-secondary" style="width:100%">Turtle Pond Server Member</span></h5>' : '<h5><span class="badge bg-secondary" style="width:100%">Not in Turtle Pond Server</h5>';
echo check_guild_membership($brownieval_guild_id) ? '<h5><span class="badge bg-secondary" style="width:100%">BrownieVAL Server Member</span></h5>' : '';
echo "</div></center>";
echo "</div>";
echo "</div>";
?>