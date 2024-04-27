<?php

$dir = dirname(__DIR__, 3);
$title = "Flyer Generator - #BrownieVAL Draft Deluxe";
$_layout_brownievalmode = false;
require $dir . "/templates/header.php";
require $dir . "/includes/cloudinary.env.php";
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\{
  Variable\Variable,
  NamedTransformation
};


// Check login
if (!isset($_SESSION['user'])) { 
  echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
  echo '<h1 class="text-center">#BrownieVAL Draft Deluxe Flyer Generator</h1>';
  echo "<div class='alert alert-danger' role='alert'>
  <center>Players, please log in with Discord to access this page.</center>
  </div></div>";
  require $dir . "/templates/footer.php"; 
  die();
} 
// Check user perms 
else if (! ( check_guild_membership($cloudinary_guild_id) || 
  (check_guild_membership($brownieval_guild_id) && check_roles([$brownieval_player_access_id, $brownieval_admin_access_id, $brownieval_talent_access_id])) 
  )) {
    echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
    echo '<h1 class="text-center">#BrownieVAL Draft Deluxe Flyer Generator</h1>';
    echo "<div class='alert alert-danger' role='alert'>
    <center>We can't determine if you're a #BrownieVAL Draft Deluxe player. We use your Discord roles in the #BrownieVAL server to check this.
    Please contact #BrownieVAL ModMail for support.</center>
    </div></div>";
    require $dir . "/templates/footer.php"; 
    die();
}

function getSignedFlyer($username, $type=0) {
  if ($username === null) {
    return null;
  }
  $type_string = ($type===0) 
    ? 'brownieval/img/brownievalddflyerbase.png' 
    : 'brownieval/img/brownievalddflyerbasetalent.png';
  global $CLOUDINARY_CONFIG;
  $cld = new Cloudinary($CLOUDINARY_CONFIG);
  $image = $cld->imageTag($type_string)
    ->addVariable(Variable::set("style", "fonts:bsfbr.ttf_" . 
      (strlen($username) > 12 ? "86" : "102")))
    ->addVariable(Variable::set("username", 
      (strlen($username) > 16 ? (substr($username,0,16) . "%0A" . substr($username,16)) : $username)
      ))
    ->namedTransformation(NamedTransformation::name("BrownieVALDDFlyerGeneratorTemplate"))
    ->signUrl();
  return str_replace(array("<img src=\"", "\">"), array("",""), $image);
}

$riot_id = null;
if (isset($_SESSION["user_connections"])) {
  $riot_id_array = array_filter(
    $_SESSION["user_connections"],
    function ($item) {
      return array_key_exists("type", $item) && $item["type"] === "riotgames";
    });
  foreach ($riot_id_array as $riot_id_listing) {
    $riot_id = explode("#",$riot_id_listing["name"])[0];
    break;
  }
}

$flyers = array(
  array(
    "name" => "\"Come watch me play!\" - Discord Server Nickname (Registered Preferred Name)",
    "type" => "discord_nickname",
    "username" => $_SESSION["user_guild_info_brownieval"]["nick"],
    "image_type" => "play",
    "image" => getSignedFlyer($_SESSION["user_guild_info_brownieval"]["nick"])
  ),
  array(
    "name" => "\"Come watch me play!\" - Discord Account Username",
    "type" => "discord_username",
    "username" => $_SESSION["username"],
    "image_type" => "play",
    "image" => getSignedFlyer($_SESSION["username"])
  ),
  array(
    "name" => "\"Come watch me play!\" - Riot ID Name",
    "type" => "riot_id",
    "username" => $riot_id,
    "image_type" => "play",
    "image" => getSignedFlyer($riot_id)
  ),
  array(
    "name" => "\"Come support me!\" - Discord Server Nickname (Registered Preferred Name)",
    "type" => "discord_nickname",
    "username" => $_SESSION["user_guild_info_brownieval"]["nick"],
    "image_type" => "support",
    "image" => getSignedFlyer($_SESSION["user_guild_info_brownieval"]["nick"], 1)
  ),
  array(
    "name" => "\"Come support me!\" - Discord Account Username",
    "type" => "discord_username",
    "username" => $_SESSION["username"],
    "image_type" => "support",
    "image" => getSignedFlyer($_SESSION["username"], 1)
  ),
);

function echoCardEntries($entries) {
  $count = 0;
  foreach ($entries as $item) {
      if ($item["username"] === null) {
        continue;
      }
      if ($count % 3 == 0) {
          if ($count > 0) {
              echo '</div>';
          }
          echo '<div class="row" style="padding-bottom:10px" oncontextmenu="return false;">';
      }
      echo '<div class="col-md-4 d-flex align-items-stretch"><div class="card" style="width:100% !important;">';
      echo '
      <div style="position:relative;background-color:lightgray"><img src="'.$item["image"].'" 
      class="card-img-top" alt="flyer image: '.$item["name"].'"></div>';
      echo '<div class="card-body">';
      echo '<h5 class="card-title">'.$item["name"].'</h5>';
      echo '<p class="card-text">'.$item["username"].'</p><p class="card-text"><button id="upload-box" class="btn btn-success"
      onclick=\'downloadSignedImage("'.$item["image"].'", "brownievaldd-flyer-'.$item["image_type"]."-".$item["username"].'")\'>
      Download Image</button></p>';
      echo '</div>';
      echo '</div></div>';
      $count += 1;
  }
  echo '</div>';
}

?>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
  <h1 class="text-center">#BrownieVAL Draft Deluxe Flyer Generator</h1>
  <p class="text-center">Promote yourself in #BrownieVAL Draft Deluxe!</p>
  <div class="alert alert-secondary">
    <p>Below is your personalized flyer for #BrownieVAL Draft Deluxe!<br/>
    You can choose between your Discord username, server nickname, and Riot ID.<br/>
    You can download the image and share it with your friends on social media! <strong>So inspirational!</strong><br/>
    Make sure to use the hashtag <strong>#BrownieVAL</strong> and link to the website: https://draft.brownieval.browntulstar.com</p>
    <p>If you prefer a different text, please contact #BrownieVAL ModMail. This custom request must be approved by staff.</p>
  </div>
  <div class="alert alert-danger">
    <strong>Privacy</strong>: This tool sends your names to Cloudinary,
    which has generated this image for you using that name.
  </div>
  <div class="container">
    <?php echoCardEntries($flyers); ?>
  </div>
</div>

<script>
  var downloadSignedImage = function(link, filename) {
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