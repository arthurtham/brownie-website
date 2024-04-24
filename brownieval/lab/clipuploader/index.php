<?php

$dir = dirname(__DIR__, 3);
$title = "Clip Uploader - #BrownieVAL Draft Deluxe";
$_layout_brownievalmode = false;
require $dir . "/templates/header.php";
require $dir . "/includes/cloudinary.env.php";


// Check login
if (!isset($_SESSION['user'])) { 
  echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
  echo '<h1 class="text-center">#BrownieVAL Draft Deluxe Clip Uploader</h1>';
  echo "<div class='alert alert-danger' role='alert'>
  <center>Players, please log in with Discord to access this page.</center>
  </div>";
  require $dir . "/templates/footer.php"; 
  die();
} 
// Check user perms 
else if (!(check_guild_membership($cloudinary_guild_id) || 
  (check_guild_membership($brownieval_guild_id) && check_roles([$brownieval_player_access_id, $brownieval_admin_access_id])) 
  )) {
    echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
    echo '<h1 class="text-center">#BrownieVAL Draft Deluxe Clip Uploader</h1>';
    echo "<div class='alert alert-danger' role='alert'>
    <center>We can't determine if you're a #BrownieVAL Draft Deluxe player. We use your Discord roles in the #BrownieVAL server to check this.
    Please contact #BrownieVAL ModMail for support.</center>
    </div>";
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
  <h1 class="text-center">#BrownieVAL Draft Deluxe Clip Uploader</h1>
  <p class="text-center">Upload your clip for the promotional video here! It will be used in the event hype video, 
    and potentially in a smaller-scale team video.</p>
  <div class="alert alert-danger">
    <p><strong>Privacy</strong>: This tool uploads your video to Cloudinary, which will additionally store information
    about your Discord account. Specifically, it will save your Discord username and user ID in the video's metadata,
    and it will rename the video to your Discord username.</p>
    <p><strong>YOU ONLY GET TO UPLOAD ONE CLIP, AND IT WILL REJECT SUBSEQUENT UPLOADS; SO CHOOSE WISELY!</strong></p>
  </div>
  
  <p>The upload widget should appear below. Please upload your video below.</p>
  <p>Your Discord Username: <strong><?=$_SESSION['username'] ?></strong></p>
  <p>Upload requirements and FAQ: <a data-bs-toggle="modal" data-bs-target="#modal-faq">
      <button class="btn btn-success">Help</button>
  </a></p>
  
  <div id="cloudinary-upload-widget-span" style="display: span;">
      
  </div>

  <div id="results-div" class="alert alert-dark" style="display: none">
    <h3> Thank you! </h3>
    <p>If submitted on time, this clip will be used in the promotional video.</p>
    <div id="video-player-div">
      <video id="video-player-media"></video>
    </div> 
  </div>

    
</div>


<div class="modal fade" style="overflow: hidden !important" id="modal-faq" tabindex="-1" aria-labelledby="modal-faq-label" aria-hidden="true">
    <div class="modal-dialog" style="overflow: hidden !important">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-faq-label"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height:60vh;overflow-y:auto">
                <center><h3>FAQ</h3></center>
                <p><strong>Upload your best VALORANT clip here for the promotional video!</strong></p>
                <p><strong>YOU ONLY GET TO UPLOAD ONE CLIP, AND IT WILL REJECT SUBSEQUENT UPLOADS; SO CHOOSE WISELY!</strong></p>
                <ul>
                  <li>You must upload a clip- you can't submit links to clips.</li>
                  <ul>
                    <li>Twitch: If you are the channel owner of the clip, then you can download it in your Clips Manager.</li>
                    <li>Outplayed: You can clip your video from your Outplayed clipping software,
                      or download it from the uploaded clip's webpage by clicking on the triple dots on the bottom right of the video.</li>
                    <li>Medal: You can download your clip from the uploaded clip's webpage by clicking on the triple dots on the top right of the video.</li>
                  </ul>
                  <li>Upload parameters:</li>
                  <ul>
                    <li>Max length: 60 sec. (longer clips will be trimmed)</li>
                    <li>Max file size: 100 MB.</li>
                    <li>Aspect Ratio: any</li>
                  </ul>
                  <li>Once the video is uploaded, wait for it to process successfully.</li>
                  <li>If there is an error, please refresh the page and try again.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
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

  
  var myWidget = cloudinary.applyUploadWidget(document.getElementById("upload-box"),
    { 
      api_key : "<?=$CLOUDINARY_API_KEY ?>", 
      cloudName: "<?=$CLOUDINARY_CLOUD_NAME ?>", 
      buttonCaption: "Upload Clip",
      uploadPreset: "<?=$CLOUDINARY_BROWNIEVAL_PLAYER_PREFIX ?>",
      public_id: "<?=$_SESSION["username"] ?>",
      context: {
        discord_username: "<?=$_SESSION["username"] ?>",
        discord_id: "<?=$_SESSION["user"]["id"] ?>"
      },
      uploadSignature: generateSignature,
      sources: [
          "local"
      ],
      text: {
        "en": {
          "queue": {
            "title_uploading_with_counter": "Uploading video...",
            "title_processing_with_counter": "Processing... (est: 1 min)"
          },
          "local": {
            "dd_title_single": "Drag and Drop Your Video Here",
            "browse": "Browse..."
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
              window: "#caaa79",
              sourceBg: "#66001d",
              windowBorder: "#ffffff",
              tabIcon: "#000000",
              inactiveTabIcon: "#caaa79",
              menuIcons: "#000000",
              link: "#519f58",
              action: "#66001d",
              inProgress: "#000000",
              complete: "#ffffff",
              error: "#ff1765",
              textDark: "#ffffff",
              textLight: "#000000"
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
        if (result.info.existing === true) {
          alert("You've already uploaded a clip before. It will play below for your reference.\n\n\
It's possible that the video editor has already started editing the promotional video. \
If you want to replace your clip, please contact #BrownieVAL ModMail.");
        }
        player.source(result.info.secure_url);
        console.log(result.info.secure_url);
        document.getElementById("cloudinary-upload-widget-span").style.display = "none";
        document.getElementById("results-div").style.display = "block";
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