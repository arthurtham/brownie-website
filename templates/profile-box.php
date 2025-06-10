<?php
echo '<div class="d-flex align-items-center justify-content-center flex-direction: column" style="padding-bottom:50px">';
echo '<div class="box bg-light bg-gradient shadow" style="padding: 10px; border-radius: 5%">';
echo '<center><div class="card" style="width:auto;max-width:400px;padding-top:20px"><center>';
echo "<img class='rounded border' src='".get_avatar_url()."'";
echo '" class="card-img-top" alt="..."/ style="width:auto;max-width:100px;"></center>';
echo '<div class="card-body"><h5 class="card-title">' . $_SESSION["username"] . '</h5>';
if (check_roles([$sub_role_id])) {
    echo '<h5><span class="badge bg-danger" style="width:100%">RED SHELLS (Twitch Subs)</span></h5>';
}
if (check_roles([$discord_sub_role_id])) {
    echo '<h5><span class="badge bg-danger" style="width:100%">RED SHELLS (Discord Subs)</span></h5>';
}
if (check_roles([$iriam_1star_role_id])) {
    echo '<h5><span class="badge bg-primary" style="width:100%">STARS (IRIAM 1★)</span></h5>';
}
if (check_roles([$iriam_2star_role_id])) {
    echo '<h5><span class="badge bg-primary" style="width:100%">SUPER STARS (IRIAM 2★)</span></h5>';
}
if (check_roles([$iriam_3star_role_id])) {
    echo '<h5><span class="badge bg-primary" style="width:100%">GRAND STARS (IRIAM 3★)</span></h5>';
}
if (check_roles([$vip_role_id])) {
    echo '<h5><span class="badge bg-warning text-black" style="width:100%">GOLD SHELLS (Discord VIPs)</span></h5>';
}
if (check_roles([$mod_role_id])) {
    echo '<h5><span class="badge bg-info" style="width:100%">BLUE SHELLS (Mods)</span></h5>';
}
echo check_guild_membership($guild_id) 
    ? '<h5><span class="badge bg-secondary" style="width:100%">Turtle Pond Server Member</span></h5>' 
    : (isset($_SESSION["twitch_user_access_token"])
    ? '<h5><span class="badge bg-secondary" style="width:100%">Logged In Via Twitch</h5>'
    : '<h5><span class="badge bg-secondary" style="width:100%">Not in Turtle Pond Server</h5>');
echo check_guild_membership($brownieval_guild_id) 
    ? '<h5><span class="badge bg-secondary" style="width:100%">#BrownieVAL Server Member</span></h5>' 
    : (isset($_SESSION["twitch_user_access_token"])
    ? ''
    : '<h5><span class="badge bg-secondary" style="width:100%">Not in #BrownieVAL Server</span></h5>');
echo "</div></center>";
echo "</div>";
echo "</div>";
?>