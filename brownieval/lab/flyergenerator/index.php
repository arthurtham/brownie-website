<?php

$dir = dirname(__DIR__, 3);
$title = "Flyer Generator - #BrownieVAL Draft Deluxe";
$_layout_brownievalmode = true;
require $dir . "/templates/header.php";
require $dir . "/includes/cloudinary.env.php";
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\{
  Variable\Variable,
  NamedTransformation,
  Delivery
};

function getSignedFlyer($username, $type=0) {
  if ($username === null) {
    return null;
  }
  global $CLOUDINARY_CONFIG;
  $cld = new Cloudinary($CLOUDINARY_CONFIG);
  if ($username === "fill-in") {
    $image = $cld->imageTag('brownieval/img/brownievalddflyerbasewatch.png')
    ->namedTransformation(NamedTransformation::name("square-center-crop"))
    ->signUrl();
  } else {
    $type_string = ($type===0) 
      ? 'brownieval/img/brownievalddflyerbase.png' 
      : (($type===2) ? 'brownieval/img/brownievalddflyerbasewatch.png'
      : 'brownieval/img/brownievalddflyerbasetalent.png');
    $image = $cld->imageTag($type_string)
      ->addVariable(Variable::set("style", "fonts:LeagueSpartan-Bold.ttf_" . //"fonts:bsfbr.ttf" . 
        (strlen($username) > 12 ? "86" : "106")))
      ->addVariable(Variable::set("username", 
        (strlen($username) > 16 ? (substr($username,0,16) . "-" . substr($username,16)) : $username)
        ));
    if ($type===2) {
      $image = $image->namedTransformation(NamedTransformation::name("BrownieVALFlyerGeneratorTemplate"));
    } else {
      $image = $image->namedTransformation(NamedTransformation::name("BrownieVALDDFlyerGeneratorTemplate"));
    };
      $image = $image->namedTransformation(NamedTransformation::name("square-center-crop"))
      ->delivery(Delivery::quality(100))
      ->signUrl();
  }
  return str_replace(array("<img src=\"", "\">"), array("",""), $image);
}

function getConnectionUsername($connection = null) {
  if ($connection === null) {
    return null;
  }
  $result_ids = array();
  if (isset($_SESSION["user_connections"])) {
    $connection_array = array_filter(
      $_SESSION["user_connections"],
      function ($item) use($connection) {
        return array_key_exists("type", $item) && $item["type"] === $connection;
      });
    #var_dump($connection_array);
    foreach ($connection_array as $connection_listing) {
      array_push($result_ids, $connection === "riotgames" ? explode("#",$connection_listing["name"])[0] : $connection_listing["name"]);
    }
    return $result_ids;
  }
  else {
    return null;
  }
}

$riot_ids = getConnectionUsername("riotgames");

//TODO: Flyers will appear based on a criteria
$flyers = array(
  
);

if (!(check_roles([$brownieval_player_access_id, $brownieval_talent_access_id, $brownieval_admin_access_id])) || check_roles([$turtle_role_id])) {
  array_push(
    $flyers,
    array(
      "name" => "Viewers Support DIY Flyer",
      "type" => "fill-in",
      "username" => "DIY",
      "image_type" => "watch",
      "image" => getSignedFlyer("fill-in")
    )
  );
}

if (!is_null($riot_ids) && (check_roles([$turtle_role_id, $brownieval_player_access_id]))) {
  foreach ($riot_ids as $riot_id) {
    array_push(
      $flyers,
      array(
        "name" => "Riot ID (without #tag)",
        "type" => "riot_id",
        "username" => $riot_id,
        "image_type" => "support",
        "image" => getSignedFlyer($riot_id, 1)
      )
    );
    break; //Only take the first Riot ID on the list
  }
}

if ((isset($_SESSION["user"]) && check_roles([$turtle_role_id, $brownieval_player_access_id, $brownieval_talent_access_id, $brownieval_admin_access_id]))) {
  array_push(
    $flyers,
    array(
      "name" => "Discord",
      "type" => "discord_username",
      "username" => $_SESSION["user_guild_info_brownieval"]["nick"] !== null ? $_SESSION["user_guild_info_brownieval"]["nick"] : $_SESSION["username"],
      "image_type" => "support",
      "image" => getSignedFlyer($_SESSION["user_guild_info_brownieval"]["nick"] !== null ? $_SESSION["user_guild_info_brownieval"]["nick"] : $_SESSION["username"], 1)
    )
    );
}

if ((isset($_SESSION["user"]))) {
array_push(
    $flyers,
    array(
      "name" => "Discord Username (Viewers)",
      "type" => "discord_username",
      "username" => "Discord Username",
      "image_type" => "support",
      "image" => getSignedFlyer($_SESSION["username"], 2)
    )
    );
}

function echoCardEntries($entries) {
  $count = 0;
  $javascript_lazyload = "<script>$(window).on('load', function() {
";
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
      <div style="position:relative;background-color:lightgray"><img id="card' . $count . '" 
      src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/loading-spinner-transparent.gif" 
      class="card-img-top" alt="flyer image: '.$item["name"].'"></div>';
      echo '<div class="card-body">';
      echo '<h5 class="card-title">'.$item["name"].'</h5>';
      echo '<p class="card-text">'.$item["username"].'</p><p class="card-text"><button class="btn btn-success"
      onclick=\'downloadSignedImage("'.$item["image"].'", "brownievaldd-flyer-'.$item["image_type"]."-".$item["username"].'")\'>
      Download Image</button>';
      if ($item["type"] === "fill-in") {
        echo '<a href="/r/brownievaldeluxediyflyer/" target="_blank"><button class="btn btn-warning">Edit Online</button></a>';
      }
      echo '</p></div>';
      echo '</div></div>';
      $javascript_lazyload .= "$('#card" . $count . "').attr('src','". $item["image"] ."');
      ";
      $count += 1;
  }
  echo '</div>';
  $javascript_lazyload .= "});</script>";
  echo $javascript_lazyload;
}

?>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
  <h1 class="text-center">Flyer Generator</h1>
  <p class="text-center">Promote yourself in #BrownieVAL Draft Deluxe!<br/>
  Download and share on social media using the hashtag <strong>#BrownieVAL</strong>. So inspirational!</p>
  <div class="alert alert-danger">
    <strong>Privacy</strong>: While logged in, this tool will use your Discord account information to 
    send your Discord name and Riot ID name (players only) to Cloudinary and generate the images below.
  </div>
  <div class="alert alert-secondary">
      <strong>Detected Discord roles: </strong>
      <?php
if (check_roles([$turtle_role_id, $brownieval_player_access_id, $brownieval_talent_access_id, $brownieval_admin_access_id])) {
  if (check_roles([$turtle_role_id, $brownieval_player_access_id])) {
    echo "<span class='badge bg-success'>Player</span>";
  }
  if (check_roles([$turtle_role_id, $brownieval_talent_access_id])) {
    echo "<span class='badge bg-warning'>On-air Talent</span>";
  }
  if (check_roles([$turtle_role_id, $brownieval_admin_access_id])) {
    echo "<span class='badge bg-danger'>Web Lab Access (Admins, Captains, etc.)</span>";
  }
} else {
    echo "<span class='badge bg-secondary'>None</span><br/>
    If you're a player/staff and only see \"fill-in-the-blank\" below, first try logging in.<br/>
    If you still don't see your personalized options, then please contact #BrownieVAL ModMail.";
}

print_navbar_login_items($expand=true);

?>
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