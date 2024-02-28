<?php 
$dir = dirname(__DIR__, 1);
require_once($dir . "/includes/mysql.php");

if (!isset($_GET["shortcode"])) {
    include($dir . "/error/404.php");
    die();
}

$sql = "SELECT * FROM shortlinks WHERE shortcode = \"".mysqli_real_escape_string($conn, $_GET["shortcode"])."\" AND available = 1 LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
        $sql_update = "UPDATE shortlinks SET hits = IFNULL(hits, 0) + 1 WHERE id = ".$item["id"].";";
        $result_update = $conn->query($sql_update);
        header("Location: ".$item["fulllink"]);
    }
} else {
    include($dir . "/error/404.php");
    die();
}


?>