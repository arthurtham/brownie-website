<?php
$dir = dirname(__DIR__, 3);
$title = "BrownieVAL - Clip Generator";

require $dir . "/templates/header.php";
require $dir . "/includes/cloudinary.env.php";


// Check login
if (!isset($_SESSION['user'])) { 
  echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
  echo "<div class='alert alert-danger' role='alert'>
  <center>You need to log in with Discord and have the necessary roles in order to access this page.</center>";
  print_navbar_login_items($expand=true, $center=true);
  echo "</div>";
  echo '
  <iframe width="100%" height="400" src="https://www.youtube.com/embed/E_fOq0oxsRM?si=CHW4wgvGX1b5dpap" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
  </div>';
  require $dir . "/templates/footer.php"; 
  die();
} 
// Check user perms
else if (!(check_guild_membership($cloudinary_guild_id) || 
  (check_guild_membership($brownieval_guild_id) && check_roles([$brownieval_admin_access_id])) || 
  (check_guild_membership($guild_id) && check_roles($sub_perk_roles) ) 
  )) {
		echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
    echo "<div class='alert alert-danger' role='alert'>
    <center>You need to have the necessary roles (ie. subscriber role) in order to access this page.</center>
    </div>";
    echo '
    <iframe width="100%" height="400" src="https://www.youtube.com/embed/E_fOq0oxsRM?si=CHW4wgvGX1b5dpap" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>';
    require $dir . "/templates/footer.php"; 
    die();
}

$_SESSION['cloudinary_timer_start']=time();
?>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link href="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.css" 
    rel="stylesheet">
<script src="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.js" 
    type="text/javascript"></script>

<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">#BrownieVAL Clip Generator</h1>

    <div style="display: span">
      <span id="upload-box-span" style="display: none"><button id="upload-box" class="cloudinary-button"> ... </button></span>
      <span id="download-button-span"></span>
    </div>

    <div id="cloudinary-upload-widget-span" style="display: span">

    </div>

    <hr />
    <div id="results-div" class="alert alert-dark" style="display: none">
      <h3> Results </h3>
      <div id="video-player-div">
        <video id="video-player-media"></video>
      </div> 
    </div>

    <div class="alert alert-dark">
      <p><strong>Upload your best VALORANT clip (up to 60 seconds in length) and post it 
      on X (formerly known as Twitter) with the hashtag <a href="https://twitter.com/hashtag/MyBrownieVALClip" target="_blank">#MyBrownieVALClip!</a></strong> Then, you'll get 
      to see how cool it is to be in #BrownieVAL!</p>
      <ul>
        <li>Upload your best VALORANT clip:</li>
        <ul>
          <li>Max length: 60 sec. (longer clips will be trimmed)</li>
          <li>Max file size: 100 MB.</li>
          <li>Aspect Ratio: 16:9</li>
        </ul>
        <li>Once the video is uploaded, wait a minute or two for it to generate.</li>
        <li>Once it's done generating, you can download it and post it on social media using 
          <strong><a href="https://twitter.com/hashtag/MyBrownieVALClip" target="_blank">#MyBrownieVALClip!</a></strong>
        </li>
        <li>If there is an error, please refresh the page and try again.</li>
      </ul>
    </div>
    <div class="alert alert-danger">
      <p><strong>Abuse of this tool will lead to a irrevocable ban on all social media platforms
        that Browntul and BrownieVAL is on.</strong></p> 
      <p><strong>Privacy</strong>: This tool uploads your video to Cloudinary, which will additionally store information about your connections on Discord (ie. your linked X and Twitch profiles).</p>
    </div>

    
</div>

<script type="text/javascript"> 
  const player = cloudinary.videoPlayer('video-player-media', {
    cloudName: 'browntulstar',
    fluid: true,
    controls: true,
    muted: false,
    colors: {
      accent: '#af0303'
    },
    hideContextMenu: true,
    autoplay: true
  });
  
  var generateSignature = function(callback, params_to_sign){
      // console.log(params_to_sign);
      $.ajax({
        url     : "/includes/cloudinarysign.php",
        type    : "GET",
        dataType: "text",
        data    : {data: params_to_sign},
        complete: function() {
        },
        success : function(signature, textStatus, xhr) { callback(signature); },
        error   : function(xhr, status, error) {
          alert(xhr.status + ": " + xhr.responseText);
        }
      });
  }

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
            link.setAttribute('download', filename+'.mp4');
            document.body.appendChild(link);
            link.click();
        })
  }
  
  var myWidget = cloudinary.applyUploadWidget(document.getElementById("upload-box"),
    { 
      api_key : "<?=$CLOUDINARY_API_KEY ?>", 
      cloudName: "<?=$CLOUDINARY_CLOUD_NAME ?>", 
      buttonCaption: "Upload Video",
      uploadPreset: "<?=$CLOUDINARY_BROWNIEVAL_PREFIX ?>",
      context: {
        discord_username: "<?=$_SESSION["username"] ?>",
        discord_id: "<?=$_SESSION["user"]["id"] ?>",
        twitch_connections: "<?php 
        $twitch_connections = array_filter(
            $_SESSION["user_connections"],
            function ($item) {
              return array_key_exists("type", $item) && $item["type"] === "twitch";
            });
        foreach ($twitch_connections as $connection) {
          echo $connection["name"] . ":" . $connection["id"] . ":";
        }
            ?>",
        twitter_connections: "<?php 
        $twitter_connections = array_filter(
            $_SESSION["user_connections"],
            function ($item) {
              return array_key_exists("type", $item) && $item["type"] === "twitter";
            });
        foreach ($twitter_connections as $connection) {
          echo $connection["name"] . ":" . $connection["id"] . ":";
        }
            ?>"
      },
      uploadSignature: generateSignature,
      sources: [
          "local",
          "google_drive"
      ],
      text: {
        "en": {
          "queue": {
            "title_uploading_with_counter": "Uploading video...",
            "title_processing_with_counter": "Adding #BrownieVAL overlays to video (est: 1 min)"
          },
          "local": {
            "dd_title_single": "Drag and Drop Your Video Here",
            "browse": "Browse..."
          },
          "google_drive": {
            "no_auth_title": "Upload a video from your Google Drive."
          }
        }
      },
      showAdvancedOptions: false,
      cropping: false,
      multiple: false,
      defaultSource: "local",
      clientAllowedFormats: "mp4,mkv,mov",
      resourceType: "video",
      maxFileSize: "104857600",
      thumbnails: false,
      autoMinimize: true,
      inlineContainer: document.getElementById('cloudinary-upload-widget-span'),
      styles: {
          palette: {
              window: "#5D005D",
              sourceBg: "#3A0A3A",
              windowBorder: "#AD5BA3",
              tabIcon: "#ffffcc",
              inactiveTabIcon: "#FFD1D1",
              menuIcons: "#FFD1D1",
              link: "#ffcc33",
              action: "#ffcc33",
              inProgress: "#00e6b3",
              complete: "#a6ff6f",
              error: "#ff1765",
              textDark: "#3c0d68",
              textLight: "#fcfffd"
          },
          fonts: {
              default: null,
              "sans-serif": {
                  url: null,
                  active: true
              }
          }
      }
    }, 
    (error, result) => { 
      if (!error && result && result.event === "success") { 
        player.source(result.info.secure_url);
        document.getElementById("cloudinary-upload-widget-span").style.display = "none";
        document.getElementById("results-div").style.display = "block";
        document.getElementById("download-button-span").innerHTML='\
          <button id="upload-box" class="cloudinary-button" \
          onclick=downloadSignedVideo("'+result.info.secure_url+'","'+(result.info.public_id).split("/").slice(-1)+'_edited")>\
          Download Processed Video</button></a>';
        
        myWidget.close({quiet: true});
      } else if (!error && result) {
      } else {
        alert("Error: " + error["statusText"] + "\nPlease refresh this page and try again.");
        myWidget.close();
        myWidget.open();
      }
    });

    myWidget.open();
</script>


<?php
require $dir . "/templates/footer.php"; 
?>