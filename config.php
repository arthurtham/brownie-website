<?php
require_once __DIR__ . "/includes/dotenv.php";
$brownie_env = brownie_load_dotenv();

if (!empty($brownie_env)) {
    $client_id = brownie_env("DISCORD_CLIENT_ID");
    $secret_id = brownie_env("DISCORD_SECRET_ID");
    $scopes = brownie_env("DISCORD_SCOPES");
    $redirect_url = brownie_env("DISCORD_REDIRECT_URL");
    $bot_token = brownie_env_nullable("DISCORD_BOT_TOKEN");
    $guild_id = brownie_env("DISCORD_GUILD_ID");
    $brownieval_guild_id = brownie_env("BROWNIEVAL_GUILD_ID");
    $cloudinary_guild_id = brownie_env("CLOUDINARY_GUILD_ID");

    $sub_role_id = brownie_env("SUB_ROLE_ID");
    $discord_sub_role_id = brownie_env("DISCORD_SUB_ROLE_ID");
    $vip_role_id = brownie_env("VIP_ROLE_ID");
    $mod_role_id = brownie_env("MOD_ROLE_ID");
    $kofi_role_id = brownie_env("KOFI_ROLE_ID");
    $iriam_1star_role_id = brownie_env("IRIAM_1STAR_ROLE_ID");
    $iriam_2star_role_id = brownie_env("IRIAM_2STAR_ROLE_ID");
    $iriam_3star_role_id = brownie_env("IRIAM_3STAR_ROLE_ID");
    $turtle_role_id = brownie_env("TURTLE_ROLE_ID");
    $turtle_id = brownie_env("TURTLE_ID");
    $brownieval_admin_access_id = brownie_env("BROWNIEVAL_ADMIN_ACCESS_ID");
    $brownieval_player_access_id = brownie_env("BROWNIEVAL_PLAYER_ACCESS_ID");
    $brownieval_talent_access_id = brownie_env("BROWNIEVAL_TALENT_ACCESS_ID");
    $override_role_id = brownie_env("OVERRIDE_ROLE_ID");

    $twitch_client_id = brownie_env("TWITCH_CLIENT_ID");
    $twitch_client_secret = brownie_env("TWITCH_CLIENT_SECRET");
    $twitch_user_id = brownie_env("TWITCH_USER_ID");
    $twitch_user_scopes = brownie_env("TWITCH_USER_SCOPES");
    $twitch_redirect_url = brownie_env("TWITCH_REDIRECT_URL");
    $brownieval_sub_only_videos = brownie_env_array("BROWNIEVAL_SUB_ONLY_VIDEOS");

    $youtube_user_id = brownie_env("YOUTUBE_USER_ID");
    $youtube_api_key = brownie_env("YOUTUBE_API_KEY");
    $iriam_reward_download_folder = brownie_env("IRIAM_REWARD_DOWNLOAD_FOLDER");

    $iriam_star_roles = brownie_env_array("IRIAM_STAR_ROLES");
    $sub_perk_roles = brownie_env_array("SUB_PERK_ROLES");
}

?>