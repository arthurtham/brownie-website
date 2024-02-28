<?php



if (!isset($_FOOTER_ENABLE) || $_FOOTER_ENABLE == true) {
    $_footer_style = (!isset($_FOOTER_HOME) || $_FOOTER_HOME == false) ? "position:fixed;bottom:0;padding: 10px;z-index:2" : "position:relative;bottom:0;padding: 10px;z-index:2";
    echo <<<FOOTER


<footer class="d-flex flex-column w-100 justify-content-center align-items-center border-top bg-light shadow" style="{$_footer_style}">
    <div class="row w-100">
        <div class="col-lg-5">
            <ul class="nav justify-content-center list-unstyled d-flex" style="font-size:20px">
                <li class="ms-2">
                    <a style="text-decoration: none;color:#000" href="https://twitch.tv/browntulstar" target="_blank">
                        <i class="fab fa-twitch"></i>
                    </a> 
                </li>
                <li class="ms-2">
                    <a style="text-decoration: none;color:#000" href="https://x.com/browntulstar" target="_blank">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </li>
                <li class="ms-2">
                    <a style="text-decoration: none;color:#000" href="https://instagram.com/browntulstar" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </li>
                <li class="ms-2">
                    <a style="text-decoration: none;color:#000" href="https://youtube.com/@browntulstar" target="_blank">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </li>
                <li class="ms-2">
                    <a style="text-decoration: none;color:#000" href="https://tiktok.com/@browntulstar" target="_blank">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </li>     
                <li class="ms-2">
                    <a style="text-decoration: none;color:#000" href="https://browntulstar.com/r/discord" target="_blank">
                        <i class="fab fa-discord"></i>
                    </a> 
                </li>
                <li class="ms-2">
                    <a style="text-decoration: none;" href="https://throne.me/browntulstar" target="_blank">
                        <img class="rounded" style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/private/c_pad,w_48,h_48,ar_1:1/com.browntulstar/img/platform-throne.webp">
                    </a> 
                </li> 
                <li class="ms-2">
                    <a style="text-decoration: none;" href="https://ko-fi.com/browntulstar" target="_blank">
                        <img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/private/c_pad,h_48/com.browntulstar/img/platform-kofi.webp">
                    </a> 
                </li> 
                <li class="ms-2">
                    <a style="text-decoration: none;" href="https://brownieval.browntulstar.com" target="_blank">
                        <img class="rounded" style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/private/c_pad,w_48,h_48,ar_1:1/v1705971391/com.browntulstar/img/brownieval-logo-v1.webp">
                    </a> 
                </li>
            </ul>
        </div>
        <div class="col-lg-2">
            <ul class="nav justify-content-center list-unstyled d-flex" style="margin-top:4px">
            <small><span class="text-muted">© 2024 BrowntulStar</span></small>
        </div>
        <div class="col-lg-5">
            <ul class="nav justify-content-center list-unstyled d-flex" style="margin-top:4px;font-size:14px">
                <li class="ms-2">
                    <a style="text-decoration: none;" href="https://browntulstar.com/r/links" target="_blank">
                        More Links
                    </a>
                </li>
                <li class="ms-2">
                    |
                </li>
                <li class="ms-2">
                    <a style="text-decoration: none;" href="/privacy">
                        Privacy Policy
                    </a> 
                </li>
                <li class="ms-2">
                    |
                </li>
                <li class="ms-2">
                    <a style="text-decoration: none;" href="mailto:browntulstar@browntulstar.com">
                        Contact
                    </a> 
                </li>
            </ul>
        </div>
    </div>
</footer>

FOOTER;
};
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>