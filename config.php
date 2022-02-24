<?php
# CLIENT ID
# https://i.imgur.com/GHI2ts5.png (screenshot)
$client_id = "945960295191433221";

# CLIENT SECRET
# https://i.imgur.com/r5dYANR.png (screenshot)
$secret_id = "";

# SCOPES SEPARATED BY SPACE
# example: identify email guilds connections  
$scopes = "identify guilds.members.read";

# REDIRECT URL
# example: https://mydomain.com/includes/login.php
# example: https://mydomain.com/test/includes/login.php
$redirect_url = "http://localhost:3000/includes/login.php";

# IMPORTANT READ THIS:
# - Set the `$bot_token` to your bot token if you want to use guilds.join scope to add a member to your server
# - Check login.php for more detailed info on this.
# - Leave it as it is if you do not want to use 'guilds.join' scope.

# https://i.imgur.com/2tlOI4t.png (screenshot)
$bot_token = null;

# TURTLE POND GUILD ID
$guild_id = "672311301233442826";

# ROLES
$sub_role_id = "895905631192621146";
$vip_role_id = "705025058958999552";
$mod_role_id = "672370133276295178";
$override_role_id = "0";
