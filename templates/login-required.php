<h2> User Details :</h2>
<p> Name : <?php echo $_SESSION['username'] //. '#' . $_SESSION['discrim']; ?></p>

<?php require __DIR__ . "/sub-perks-description.php" ?>

<p>In order to access these perks, make sure you satisfy the following requirements:</p>
<ul>
    <li>Join the Turtle Pond Discord Server: <?php 
        echo check_guild_membership($guild_id) ? "Joined!" : <<<DISC
        Not yet joined! <a href="https://discord.gg/c8XNspY" target="_blank">Join the Turtle Pond!</a></iframe>;
DISC;
    ?></li>
    <li>Satisfy at least one role requirement: 
        <ul>
            <li>Red Shells (Subs): <?php 
                echo check_roles([$sub_role_id]) ? "Subbed on Twitch!" : <<<DISC
                Gain this role by subbing to Browntul on https://twitch.tv/browntulstar and linking your Twitch account to Discord.
DISC;
                ?></li>
            <li>Stars (VIPs): <?php 
                echo check_roles([$vip_role_id]) ? "You're special already!" : <<<DISC
                Only for the special ones.
DISC;
                ?></li>
            <li>Blue Shells (Mods): <?php 
                echo check_roles([$mod_role_id]) ? "You're special already!" : <<<DISC
                Only for my bodyguards.
DISC;
                ?></li>
        </ul>
    </li>
</ul>