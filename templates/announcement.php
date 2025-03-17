<?php
require_once $dir . "/includes/CloudinarySigner.php";

//MYSQL is already imported
$sql = "SELECT * FROM announcement_embeds WHERE announcement_id = '".$_GET['announcement-id']."' LIMIT 1";
#echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($announcement_embed = $result->fetch_assoc()) {
        $announcement_id = $announcement_embed["announcement_id"];
        echo "<div class='row post-contents' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
        if (!$announcement_embed["published"]) {
            echo "<center><h1>Browntul Says</h1></center><hr/>";
            echo "<p>Note: This announcement is not published or no longer exists!</p>";
        } else {
            $announcement_date = date_format(date_create_from_format("Y-m-d",explode(" ",$announcement_embed["announcement_date"])[0]),"F d, Y");
            echo "<center><h1>" . $announcement_embed["announcement_name"] . "</h1><a href='/announcements/'>" . "Browntul Says" . "</a> | " . $announcement_date .  "</center><br/><hr/>";
            $embed_contents = (new CloudinarySigner())->convertAllUrls($announcement_embed["announcement_embed"]);
            include_once $dir . "/templates/markdown-render.php";
        }
        echo "</div></div>";
//         echo <<<DISQUS
// 			<div id="disqus_thread"></div>
// 			<script>
// 				/**
// 				*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
// 				*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
// 				var disqus_config = function () {
// 				this.page.url = "https://{$_SERVER['HTTP_HOST']}/announcements/$announcement_id"  // Replace PAGE_URL with your page's canonical URL variable
// 				this.page.identifier = "brownannouncement_$announcement_id"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
// 				};
// 				(function() { // DON'T EDIT BELOW THIS LINE
// 				var d = document, s = d.createElement('script');
// 				s.src = 'https://browntulstar-com.disqus.com/embed.js';
// 				s.setAttribute('data-timestamp', +new Date());
// 				(d.head || d.body).appendChild(s);
// 				})();
// 			</script>
// 			<noscript>Please enable JavaScript to view the <a href='https://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>
// 			<script id="dsq-count-scr" src='//browntulstar-com.disqus.com/count.js' async></script>
// DISQUS;
    }
} else {
    echo "<center><h1>Browntul Says</h1></center><hr/>";
    echo "<p>Note: This announcement is not published or no longer exists!</p>";
    //die();
}
?>



