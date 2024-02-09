<?php 
$dir = dirname(__DIR__, 1);
require_once($dir . "/includes/mysql.php");

if (!isset($_GET["shortcode"])) {
    header("Location: /");
}

$sql = "SELECT * FROM shortlinks WHERE shortcode = \"".mysqli_real_escape_string($conn, $_GET["shortcode"])."\" AND available = 1 LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
        header("Location: ".$item["fulllink"], TRUE, 301);
    }
} else {
    header("Location: /");
}


?>