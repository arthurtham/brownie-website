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
            <a class="btn btn-info mt-2 mb-2" href="/iriam">
                <img src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0" style="height:20px;width:20px">
                    Gift on IRIAM
                </a>
            </a>
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