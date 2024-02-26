<?php



if (!isset($_FOOTER_ENABLE) || $_FOOTER_ENABLE == true) {
    $_footer_style = (!isset($_FOOTER_HOME) || $_FOOTER_HOME == false) ? "position:fixed;bottom:0;padding: 10px;z-index:2" : "bottom:0;padding: 10px;z-index:2";
    echo <<<FOOTER


<footer class="d-flex flex-column w-100 justify-content-center align-items-center border-top bg-light" style="{$_footer_style}">
    <div class="row" style="width:100wh auto">
        <ul class="nav col-sm-12 justify-content-beginning list-unstyled d-flex">
            <li class="ms-2">
                <a style="text-decoration: none;font-size:24px" href="https://twitch.tv/browntulstar" target="_blank">
                    <i class="fab fa-twitch"></i>
                </a> 
            </li>
            <li class="ms-2">
                <a style="text-decoration: none;font-size:24px" href="https://x.com/browntulstar" target="_blank">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </li>
            <li class="ms-2">
                <a style="text-decoration: none;font-size:24px" href="/youtube" target="_blank">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </li>
            <li class="ms-2">
                <a style="text-decoration: none;font-size:24px" href="/tiktok" target="_blank">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
            </li>
            <li class="ms-2">
                <a style="text-decoration: none;font-size:24px" href="https://ko-fi.com/browntulstar" target="_blank">
                    <i class="fa-solid fa-mug-hot"></i>
                </a>
            </li>       
            <li class="ms-2">
                <a style="text-decoration: none;font-size:24px;" href="/discord" target="_blank">
                    <i class="fab fa-discord"></i>
                </a> 
            </li> 
            <li class="ms-2">
                <a style="text-decoration: none;font-size:24px;" href="mailto:browntulstar@browntulstar.com" target="_blank">
                    <i class="fa-solid fa-envelope"></i>
                </a>
            </li>  
        </ul>
    </div>
    <div class="row">
        <ul class="nav col-sm-12 justify-content-center list-unstyled d-flex">
            <li class="ms-2">
                <a style="text-decoration: none;font-size:16px" href="https://browntulstar.com/r/links" target="_blank">
                    More Links
                </a>
            </li>
            <li class="ms-2">
                |
            </li>
            <li class="ms-2">
                <a style="text-decoration: none;font-size:16px" href="/privacy">
                    Privacy Policy
                </a> 
            </li>
        </ul>
    </div>
    <div class="row">
        <span class="text-muted">© 2024 BrowntulStar</span>
    </div>
</footer>

FOOTER;
};
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>