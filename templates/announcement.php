<?php

require dirname(__DIR__, 1) . "/includes/Parsedown.php"; 

//MYSQL is already imported
$sql = "SELECT * FROM announcement_embeds WHERE announcement_id = '".$_GET['announcement-id']."' LIMIT 1";
#echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($announcement_embed = $result->fetch_assoc()) {
        $announcement_id = $announcement_embed["announcement_id"];
        echo <<<STYLE
        <style>
        .blog-images img {
            width: 100%;
            max-width: 400px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding: 10px;
        }
        video {
            width: 100%;
            max-width: 400px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 20px;
        }
    </style>
STYLE;
        echo "<div class='row blog-images' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
        echo "<center><h1>" . $announcement_embed["announcement_name"] . "</h1><a href='/announcements/'>" . "Announcements" . "</a> | " . explode(" ",$announcement_embed["announcement_date"])[0] .  "</center><br/><hr/>";
        $announcement_embed_contents = $announcement_embed["announcement_embed"];
        echo <<<IFRAME
<iframe width='100%' height='500px' scrolling='yes' frameborder='0' src="$announcement_embed_contents"></iframe>

IFRAME;
        echo "</div></div><hr>";
        echo <<<DISQUS
			<div id="disqus_thread"></div>
			<script>
				/**
				*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
				var disqus_config = function () {
				this.page.url = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"  // Replace PAGE_URL with your page's canonical URL variable
				this.page.identifier = "brownannouncement_$announcement_id"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
				};
				(function() { // DON'T EDIT BELOW THIS LINE
				var d = document, s = d.createElement('script');
				s.src = 'https://browntulstar-com.disqus.com/embed.js';
				s.setAttribute('data-timestamp', +new Date());
				(d.head || d.body).appendChild(s);
				})();
			</script>
			<noscript>Please enable JavaScript to view the <a href='https://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>
			<script id="dsq-count-scr" src='//browntulstar-com.disqus.com/count.js' async></script>
DISQUS;
    }
} else {
    echo "An error occured when attempting to open this announcement post.";
    echo $sql;
    //die();
}
?>


