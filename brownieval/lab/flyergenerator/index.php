<?php

$dir = dirname(__DIR__, 3);
$title = "Flyer Generator - #BrownieVAL Draft Deluxe";
$_layout_brownievalmode = false;
require $dir . "/templates/header.php";
require $dir . "/includes/cloudinary.env.php";
use Cloudinary\Cloudinary;
use Cloudinary\Tag\ImageTag;
use Cloudinary\Transformation\{
  Resize, AspectRatio, Gravity, Compass,
  Overlay, Source, TextStyle, Position,
  Argument\Text\FontWeight,
  Argument\Text\FontStyle,
  Argument\Text\TextDecoration,
  Argument\Text\TextAlignment,
  Argument\Color
};





// Check login
if (!isset($_SESSION['user'])) { 
  echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
  echo '<h1 class="text-center">#BrownieVAL Draft Deluxe Flyer Generator</h1>';
  echo "<div class='alert alert-danger' role='alert'>
  <center>Players, please log in with Discord to access this page.</center>
  </div>";
  require $dir . "/templates/footer.php"; 
  die();
} 
// Check user perms 
else if (! ( check_guild_membership($cloudinary_guild_id) || 
  (check_guild_membership($brownieval_guild_id) && check_roles([$brownieval_player_access_id, $brownieval_admin_access_id])) 
  )) {
    echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
    echo '<h1 class="text-center">#BrownieVAL Draft Deluxe Flyer Generator</h1>';
    echo "<div class='alert alert-danger' role='alert'>
    <center>We can't determine if you're a #BrownieVAL Draft Deluxe player. We use your Discord roles in the #BrownieVAL server to check this.
    Please contact #BrownieVAL ModMail for support.</center>
    </div>";
    require $dir . "/templates/footer.php"; 
    die();
}

function getSignedFlyerFromDiscord() {
  $username = is_null($_SESSION["user_guild_info_brownieval"]["nick"]) ? $_SESSION["username"] : $_SESSION["user_guild_info_brownieval"]["nick"];
  return getSignedFlyer($username);
}

function getSignedFlyer($username) {
  global $CLOUDINARY_CONFIG;
  $cld = new Cloudinary($CLOUDINARY_CONFIG);
  $image = $cld->imageTag('brownieval/img/brownievalddflyerbase.png')
    ->resize(
      Resize::crop()
        ->aspectRatio(
          AspectRatio::ar1X1()
        )
        ->gravity(
          Gravity::compass(
            Compass::center()
          )
        )
    )
    ->overlay(
      Overlay::source(
        Source::text(
          $username,
          (new TextStyle("arial", 102))
            ->fontWeight(
              FontWeight::bold()
            )
            ->fontStyle(
              FontStyle::italic()
            )
            ->textAlignment(
              TextAlignment::left()
            )
        )
          ->textColor(Color::rgb("ffffff"))
      )
        ->position(
          (new Position())
            ->gravity(
              Gravity::compass(
                Compass::center()
              )
            )
        )
    )->signUrl();
  return str_replace(array("<img src=\"", "\">"), array("",""), $image);
}

$flyer = getSignedFlyerFromDiscord();
?>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
  <h1 class="text-center">#BrownieVAL Draft Deluxe Flyer Generator</h1>
  <p class="text-center">Promote yourself in #BrownieVAL Draft Deluxe!</p>
  <div class="alert alert-secondary">
    Below is your personalized flyer for #BrownieVAL Draft Deluxe, based off your preferred name set on Discord.<br/>
    You can download the image and share it with your friends on social media! <strong>So inspirational!</strong>
  </div>
  <div class="alert alert-danger">
    <strong>Privacy</strong>: This tool sends your Discord display name or server nickname to Cloudinary,
    which has generated this image for you using that name.
  </div>
  <center><p><a><button id="upload-box" class="btn btn-success" \
          onclick='downloadSignedVideo("<?=$flyer?>", "brownievaldd-flyer-<?php echo $_SESSION["username"] ?>")'>
          Download Image</button></a></p>
  <img src="<?php echo $flyer ?>" style="width:300px"></center>
</div>

<script>
  var downloadSignedVideo = function(link, filename) {
    axios({
        url: link,
        method: 'GET',
        responseType: 'blob'
    })
        .then((response) => {
            const url = window.URL
                .createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', filename+'.png');
            document.body.appendChild(link);
            link.click();
        })
  }
</script>

<?php
require $dir . "/templates/footer.php"; 
?>