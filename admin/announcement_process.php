<?php

$dir = dirname(__DIR__, 1);
$title = "Announcement Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

?>
<div class="container body-container">

<?php

if (empty($_POST)) {
    echo ("No variables passed");
} else {

$sql = "REPLACE INTO announcement_embeds (announcement_id, announcement_name, announcement_embed, announcement_date, published) VALUES (";
$sql .= "\"" . $_POST["announcement_id"] . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["announcement_name"]) . "\",";
$sql .= "\"" . mysqli_real_escape_string($conn, $_POST["announcement_embed"]) . "\",";
$sql .= "\"" . $_POST["announcement_date"] . "\",";
$sql .= "\"" . (isset($_POST["announcement_published"]) ? 1 : 0)."\"";
$sql .= ");";
$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<a href='/admin/announcement.php'><button>Main</button></a></p>";
    echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    redirect("/admin/announcement_editor.php?announcement_id=".$_POST["announcement_id"]);
} else {
    echo "<p>Failure: $conn->error </p>";
    echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
}
echo "<br/>";
print_r($_POST);
}

?>
</div>
<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>