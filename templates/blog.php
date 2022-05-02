<?php

require dirname(__DIR__, 1) . "/includes/Parsedown.php"; 

$legacy_link = explode("_",$blog_id);
if (count($legacy_link) == 5) {
    $blog_id = $legacy_link[4];
}/* else {
    $blog_id = $_GET['blog-id'];
}*/

//MYSQL is already imported
//$sql = "SELECT * FROM blog_posts WHERE blog_id = \"".$_GET['blog-id']."\"";
$sql = "SELECT blog_posts.blog_name, blog_posts.blog_date, blog_posts.blog_content, blog_types.name AS blog_type_name, blog_posts.blog_type AS blog_type_raw, blog_posts.visible, blog_posts.published
 FROM blog_posts 
 INNER JOIN blog_types ON blog_posts.blog_type = blog_types.blog_type 
 WHERE blog_id = \"".$blog_id."\" AND blog_posts.blog_type = \"".$blog_type."\"";
#echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($blog_post = $result->fetch_assoc()) {
        echo <<<STYLE
        <style>
        .blog-images img {
            width: auto;
            max-width: 400px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding: 10px;
        }
        video {
            width: auto;
            max-width: 300px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
STYLE;
        echo "<div class='row blog-images' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
        echo "<a href='/subs/blog'>Back to Blog Directory</a>";
        echo "<center><h1>" . $blog_post["blog_name"] . "</h1>" . $blog_post["blog_type_name"] . " | " . explode(" ",$blog_post["blog_date"])[0] .  "</center><hr><br/>";
        /*if (!$blog_post["visible"]) {
            echo "<p>Note: This blog post is not visible in the main directory.</p>";
        }*/
        if (!$blog_post["published"]) {
            echo "<p>Note: This blog post is not published. Come back again soon!</p>";
        } else {
            echo Parsedown::instance()->text($blog_post["blog_content"]);
        }
        echo "</div></div>";
        echo <<<DISQUS
			<div id="disqus_thread"></div>
			<script>
				/**
				*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
				var disqus_config = function () {
				this.page.url = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"  // Replace PAGE_URL with your page's canonical URL variable
				this.page.identifier = "brownblog_$blog_id"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
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
    echo "An error occured when attempting to open this blog post.";
    //echo $sql;
    //header("Location: /subs/blog");
    //die();
}

// echo "<div class='row blog-images' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
// echo "<a href='/subs/blog'>Back to Blog Directory</a>";
// echo "<center><h1>" . ltrim($title,"-") . "</h1>" . $blogtype . " | " .  $month . "/" . $day . "/" . $year .  "</center><hr><br/>";


// if ($myfile = fopen($blog_file_location . ".md", "r")) {
//     echo Parsedown::instance()->text(fread($myfile, filesize($blog_file_location . ".md")));
//     fclose($myfile);
// } else {
//     header("Location: /subs/blog");
//     die();
// }

// echo "</div></div>";


?>



