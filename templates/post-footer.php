<?php
if (!isset($_post_footer_type)) {
    $_post_footer_type = "content";
}
if (!isset($_post_footer_return_button)) {
    $_post_footer_return_button = '<a href="/"><button class="btn btn-success">Go Home</button></a>';
}
$_post_footer_contact_button = '<a href="/contact"><button class="btn btn-primary">Contact</button></a>';
?>
<div class="alert alert-secondary">
    <h3>Like this <?=$_post_footer_type ?>?</h3>
    <p>Please consider subscribing or donating to support more content.</p>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-dark mt-2 mb-2" href="https://www.twitch.tv/browntulstar/subscribe" target="_blank">
                <i class="fa-brands fa-twitch"></i>
                Sub on Twitch
            </a>
            <script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script><script type='text/javascript'>kofiwidget2.init('Support me on Ko-fi', '#66001d', 'R6R02XQSW');kofiwidget2.draw();</script> 
        </div>
    </div>
    <hr>
    <h3>Have questions?</h3>
    <p>Contact for more information.</p>
    <?=$_post_footer_contact_button?>
    <hr>
    <h3>More <?=$_post_footer_type ?>s</h3>
    <?=$_post_footer_return_button?>
</div>