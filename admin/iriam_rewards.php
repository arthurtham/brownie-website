<?php

$dir = dirname(__DIR__, 1);
$title = "IRIAM Rewards";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require_once($dir . "/includes/mysql.php");

?>
<style>
    .table .tr .th .td {
        border: 1px solid;
    }
</style>
</head>
<body>
    <div class='container body-container'>
        <div id="iriam_rewards_links">
        <div class='row mb-2'>
            <div class='col'>
                <h1>IRIAM Rewards Editor</h1>
                <div class="input-group mb-3">
                    <a href="iriam_rewards_upload.php" class="btn btn-success">Upload New Reward</a>
                    <a href="/admin" class="btn btn-danger">Return to Main Menu</a>
                </div>
                <div class="input-group mb-3">
                    <label for="search-text" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input class="search form-control" type="text" name="search-text" id="search-text" placeholder="Search..." value="<?php echo $_GET["search-text"] ?>" />
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12 border' style='overflow:scroll;max-height:70vh'>
<?php


$sql = "SELECT * FROM iriam_rewards ORDER BY iriam_reward_date DESC, id ASC, iriam_reward_name ASC;";
//echo "<p>$sql</p>";

echo "<table class='table'><thead class='table-dark sticky-top' style='z-index:1'><tr>
<th>Thumbnail</th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_name\">Name</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_reward_date\">Reward Date</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_1star\">1★</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_2star\">2★</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_3star\">3★</button></th>
<th><button class='sort btn btn-success btn-sm' data-sort=\"gl_published\">List in Dir</button></th>
<th>Actions</th></tr></thead><tbody class='list'>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($iriam_reward_post = $result->fetch_assoc()) {
        $iriam_reward_thumbnail = $iriam_reward_post['iriam_reward_thumbnail'];
        $iriam_reward_name = $iriam_reward_post['iriam_reward_name'];
        $iriam_reward_description = $iriam_reward_post['iriam_reward_description'];
        $iriam_reward_date = DateTime::createFromFormat('Y-m-d H:i:s', $iriam_reward_post['iriam_reward_date'])->format("F d, Y<\b\\r>h:i A");
        $iriam_published = $iriam_reward_post['published'];
        $iriam_reward_download_id = $iriam_reward_post['iriam_reward_download_id'];
        echo "<tr>" . 
        "<td class='gl_thumbnail'><img src=\"".$iriam_reward_thumbnail."\" class='img-fluid rounded shadow' style='max-height: 75px; max-width: min(100%,125px);' alt='Thumbnail for ".$iriam_reward_name."'>".
        "</td><td class='gl_name' style='min-width:200px'><strong>".$iriam_reward_name."</strong><br><em>".$iriam_reward_download_id."</em><br>".(strlen($iriam_reward_description) > 100
            ? substr($iriam_reward_description, 0, 100) . "..."
            : $iriam_reward_description) .
        "</td><td class='gl_reward_date_readable'>".$iriam_reward_date.
        "</td><td class='gl_reward_date' style='display:none'>".strtotime($iriam_reward_date).
        "</td><td class='gl_1star'>".$iriam_reward_post['1star'].
        "</td><td class='gl_2star'>".$iriam_reward_post['2star'].
        "</td><td class='gl_3star'>".$iriam_reward_post['3star'].
        "</td><td class='gl_published'>".$iriam_published.
        "</td><td><a href='iriam_rewards_editor.php?public-id=$iriam_reward_download_id'><button class='btn btn-dark' type='button'>Edit</button></a>".
        "</td></tr>";
    }
}
?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>
    var options = { valueNames: ['gl_thumbnail', 'gl_name', 'gl_reward_date', 'gl_published', 'gl_1star', 'gl_2star', 'gl_3star'] };
    var linkList = new List('iriam_rewards_links', options);
</script>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>