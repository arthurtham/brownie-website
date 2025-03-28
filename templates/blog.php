<?php
require_once $dir . "/includes/CloudinarySigner.php";

$_return_to_blogs_button = '<a href="/subs/blog/"><button class="btn btn-success">View All Sub Blog Posts</button></a>';

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
 WHERE blog_id = \"".mysqli_real_escape_string($conn,$blog_id)."\" AND blog_posts.blog_type = \"".mysqli_real_escape_string($conn,$blog_type)."\"";
#echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($blog_post = $result->fetch_assoc()) {
        $blog_date = date_format(date_create_from_format("Y-m-d",explode(" ",$blog_post["blog_date"])[0]),"F d, Y");
        echo "<div class='row post-contents' oncontextmenu='return false;' ondragstart='return false;' ondrop='return false;'><div class='col col-md-12'>";
        echo "<center><h1>" . $blog_post["blog_name"] . "</h1>";
        echo "<a href='/subs/blog/'>Sub Blog</a> / <a href='/subs/blog/$blog_type/'>" . $blog_post["blog_type_name"] . "</a></center>";
        echo "<center>Written on: " . $blog_date . "</center><hr><br/>";
        /*if (!$blog_post["visible"]) {
            echo "<p>Note: This blog post is not visible in the main directory.</p>";
        }*/
        if (!$blog_post["published"]) {
            echo "<p>Note: This blog post is not published. Come back again soon!</p>";
        } else {
            $embed_contents = (new CloudinarySigner())->convertAllUrls($blog_post["blog_content"]);
            include_once $dir . "/templates/markdown-render.php";
        }
        echo "</div></div><hr>";

        $_post_footer_type = "blog post";
        $_post_footer_return_button = $_return_to_blogs_button;
        include $dir . "/templates/post-footer.php";

        echo <<<DISQUS
			<div id="disqus_thread"></div>
			<script>
				/**
				*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
				var disqus_config = function () {
				this.page.url = "https://{$_SERVER['HTTP_HOST']}/subs/blog/$blog_type/$blog_id"  // Replace PAGE_URL with your page's canonical URL variable
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
    //die();
}
?>



