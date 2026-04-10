<?php

$dir = dirname(__DIR__, 1);
$title = "Blog Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

echo "<div class=\"container body-container\">";

if (empty($_POST)) {
    echo ("No variables passed");
} else {

// $is_new_post = ($_POST["blog_id"] === "-1" && $_POST["blog_new_id"] === "-1");
$is_new_post = ($_POST["blog_new_id"] === "-1");


if ($is_new_post) {
    // $sql = "SELECT blog_id FROM blog_posts ORDER BY blog_id DESC LIMIT 1;";
    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     while ($blog_post = $result->fetch_assoc()) {
    //         $blog_id = intval($blog_post["blog_id"])+1;
    //     }
    // } else {
    //     $blog_id = 10001;
    // }
    $uuid_sql = "SELECT UUID() AS new_uuid;";
    $uuid_result = $conn->query($uuid_sql);
    if ($uuid_result !== false && $uuid_result->num_rows > 0) {
        $uuid_row = $uuid_result->fetch_assoc();
        $new_post_uuid = $uuid_row["new_uuid"];
    } else {
        echo "<p>Failure: Could not generate new UUID for blog post</p>";
        exit;
    }
    
    $sql = "INSERT INTO blog_posts (blog_name, blog_new_id, blog_date, blog_modified_date, blog_type, blog_content, visible, published, free) VALUES (";
    $sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_name"]) . "\",";
    $sql .= "UUID_TO_BIN(\"" . $new_post_uuid . "\"),";
    $sql .= "\"" . $_POST["blog_date"] . "\",";
    $sql .= "\"" . date("Y-m-d H:i:s") . "\",";
    $sql .= "\"" . $_POST["blog_type"] . "\",";
    $sql .= "\"" . mysqli_real_escape_string($conn, $_POST["blog_content"]) . "\",";
    $sql .= "\"" . (isset($_POST["blog_visible"]) ? 1 : 0) . "\",";
    $sql .= "\"" . (isset($_POST["blog_published"]) ? 1 : 0)."\",";
    $sql .= "\"" . (isset($_POST["blog_free"]) ? 1 : 0)."\"";
    $sql .= ");";
} else {
    $sql = "UPDATE blog_posts SET ";
    $sql .= "blog_name = \"" . mysqli_real_escape_string($conn, $_POST["blog_name"]) . "\",";
    $sql .= "blog_date = \"" . $_POST["blog_date"] . "\",";
    $sql .= "blog_modified_date = \"" . date("Y-m-d H:i:s") . "\",";
    $sql .= "blog_type = \"" . $_POST["blog_type"] . "\",";
    $sql .= "blog_content = \"" . mysqli_real_escape_string($conn, $_POST["blog_content"]) . "\",";
    $sql .= "visible = \"" . (isset($_POST["blog_visible"]) ? 1 : 0) . "\",";
    $sql .= "published = \"" . (isset($_POST["blog_published"]) ? 1 : 0)."\",";
    $sql .= "free = \"" . (isset($_POST["blog_free"]) ? 1 : 0)."\"";

    
    if (($_POST["blog_new_id"] !== null) && ($_POST["blog_new_id"] !== "-1")) {
        $sql .= " WHERE blog_new_id = UUID_TO_BIN(\"" . mysqli_real_escape_string($conn, $_POST["blog_new_id"]) . "\")";
    } 
    else 
    if (($_POST["blog_id"] !== null) && ($_POST["blog_id"] !== "-1")) {
        $sql .= " WHERE blog_id = \"" . mysqli_real_escape_string($conn, $_POST["blog_id"]) . "\"";
    } 
    else 
    {
        echo "<p>Failure: Invalid blog ID condition for updating blog post</p>";
    }
    $sql .= ";";
}

$result = $conn->query($sql);
if ($result === TRUE) {
    echo "<p>Success!</p>";
    echo "<a href='/admin/blog.php'><button>Main</button></a></p>";
    // echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
    // If it is a new post, we need to get the new blog ID that was auto-assigned by the database. 
    // That means we must search for the new blog post ID.
    if ($is_new_post) {
        $sql = "SELECT blog_id, blog_new_id FROM blog_posts WHERE blog_name = \"" . mysqli_real_escape_string($conn, $_POST["blog_name"]) . "\" AND blog_date = \"" . $_POST["blog_date"] . "\" AND blog_type = \"" . $_POST["blog_type"] . "\" ORDER BY blog_id DESC LIMIT 1;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($blog_post = $result->fetch_assoc()) {
                $sql_return_blog_id = $blog_post["blog_id"];
                $sql_return_blog_new_id = bin_to_uuid($blog_post["blog_new_id"]);
            }
        } else {
            echo "<p>Failure: Could not find new blog post after insertion</p>";
            echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
            exit;
        }
    } else {
        // If it is not a new post, then we can just use the existing ID from the form.
        $sql_return_blog_id = $_POST["blog_id"];
        $sql_return_blog_new_id = $_POST["blog_new_id"];
    }
    redirect("/admin/blog_editor.php?blog_id=".mysqli_real_escape_string($conn, $sql_return_blog_new_id));
} else {
    echo "<p>Failure: $conn->error </p>";
    echo "<xmp style=\"white-space: pre-wrap\">$sql</xmp>";
}
//print_r($_POST);
}

echo "</div>";
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>