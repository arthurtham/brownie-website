<?php
require_once __DIR__ . "/dotenv.php";
$brownie_env = brownie_load_dotenv();
require_once dirname(__DIR__,1) . "/vendor/autoload.php";
use Cloudinary\Configuration\Configuration;

$CLOUDINARY_CLOUD_NAME = brownie_env("CLOUDINARY_CLOUD_NAME");
$CLOUDINARY_API_KEY = brownie_env("CLOUDINARY_API_KEY");
$CLOUDINARY_API_SECRET = brownie_env("CLOUDINARY_API_SECRET");
$CLOUDINARY_CONFIG = Configuration::instance([
    'cloud' => [
        'cloud_name' => $CLOUDINARY_CLOUD_NAME,
        'api_key'  => $CLOUDINARY_API_KEY,
        'api_secret' => $CLOUDINARY_API_SECRET,
    'url' => [
        'secure' => true]]]);
$CLOUDINARY_URL = "cloudinary://".$CLOUDINARY_API_KEY.":".$CLOUDINARY_API_SECRET."@".$CLOUDINARY_CLOUD_NAME."";


// Defaults that are declared ahead of time, mostly for the Cloudinary lab program
$CLOUDINARY_DELETE_EXPRESSION = brownie_env("CLOUDINARY_DELETE_EXPRESSION");
$CLOUDINARY_BROWNIEVAL_PREFIX = brownie_env("CLOUDINARY_BROWNIEVAL_PREFIX");
$CLOUDINARY_BROWNIEVAL_PLAYER_PREFIX = brownie_env("CLOUDINARY_BROWNIEVAL_PLAYER_PREFIX");
$CLOUDINARY_CLIPUPLOADER_CATEGORY = brownie_env("CLOUDINARY_CLIPUPLOADER_CATEGORY");
$CLOUDINARY_BROWNIEVAL_PREFIX_ARRAY = array(
    $CLOUDINARY_BROWNIEVAL_PREFIX,
    $CLOUDINARY_BROWNIEVAL_PLAYER_PREFIX
);
$CLOUDINARY_IRIAM_PREFIX = brownie_env("CLOUDINARY_IRIAM_PREFIX");

?>