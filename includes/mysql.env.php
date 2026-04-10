<?php
require_once __DIR__ . "/dotenv.php";
$brownie_env = brownie_load_dotenv();

$_environmental_variables = array(
    "servername" => brownie_env("DB_HOST"),
    "username" => brownie_env("DB_USER"),
    "password" => brownie_env("DB_PASS"),
    "dbname" => brownie_env("DB_NAME"),
);
?>