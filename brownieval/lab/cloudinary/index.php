<?php
$dir = dirname(__DIR__, 3);
$title = "BrownieVAL - Cloudinary";

require $dir . "/templates/header.php";
require $dir . "/includes/cloudinary.env.php";


// Check login
if (!isset($_SESSION['user'])) { 
  echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
	echo "<div class='alert alert-danger' role='alert'>
	<center>This BrownieVAL tool requires you to log in to Discord with the appropriate roles.</center>
	</div></div>";
  require $dir . "/templates/footer.php"; 
  die();
} 
// Check user perms
else if (!check_guild_membership($brownieval_guild_id) || !check_roles([$brownieval_admin_access_id])) {
		echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
    echo "<div class='alert alert-danger' role='alert'>
		<center>This BrownieVAL tool requires you to have the appropriate BrownieVAL web admin access role on Discord.
    Get this role first, then re-log in to this website.</center>
		</div></div>";
    require $dir . "/templates/footer.php"; 
    die();
}?>

<link href="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.css" 
    rel="stylesheet">
<script src="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.js" 
    type="text/javascript"></script>

<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Overlay Generator for #BrownieVAL</h1>

    <div style="display: span">
      <button id="upload-box" class="cloudinary-button"> ... </button>
      <span id="download-button-span"></span>
    </div>

    <hr />
    <h3> Results </h3>
    <div class="alert alert-dark">
      <div id="video-player-div">
        <video id="video-player-media"></video>
      </div> 
    </div>
</div>

<script type="text/javascript"> 
  const player = cloudinary.videoPlayer('video-player-media', {
    cloudName: 'browntulstar',
    fluid: true,
    controls: true,
    muted: true,
    colors: {
      accent: '#af0303'
    },
    hideContextMenu: true,
    autoplay: true
  });
  
  var generateSignature = function(callback, params_to_sign){
      $.ajax({
        url     : "/includes/cloudinarysign.php",
        type    : "GET",
        dataType: "text",
        data    : { data: params_to_sign},
        complete: function() {console.log("complete")},
        success : function(signature, textStatus, xhr) { callback(signature); },
        error   : function(xhr, status, error) { console.log(xhr, status, error); }
      });
  }
  
  var myWidget = cloudinary.applyUploadWidget(document.getElementById("upload-box"),
    { 
      api_key : "<?=$CLOUDINARY_API_KEY ?>", 
      cloudName: "<?=$CLOUDINARY_CLOUD_NAME ?>", 
      buttonCaption: "Upload Video",
      uploadPreset: "com-browntulstar-brownieval-sandbox",
      uploadSignature: generateSignature,
      sources: [
          "local",
          "url",
          "google_drive"
      ],
      showAdvancedOptions: false,
      cropping: false,
      multiple: false,
      defaultSource: "local",
      clientAllowedFormats: "mp4",
      maxFileSize: "100000000",
      thumbnails: false,
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
        console.log('Result: ', result.info); 
        player.source(result.info.eager[0].secure_url);
        document.getElementById("download-button-span").innerHTML='\
          <a href="'+result.info.eager[0].secure_url+'" target="_blank">\
          <button id="upload-box" class="cloudinary-button">Download Processed Video</button></a>';
        myWidget.close({quiet: true});
      } else if (!error && result) {
        console.log('Event:' , result.event);
      } else {
        console.log("Error: ", error);
        alert("Error: " + error["statusText"]);
      }
    });
  
    
  
  
  document.getElementById("upload-box").addEventListener("click", function(){
      myWidget.open();
    }, false);
</script>


<?php
require $dir . "/templates/footer.php"; 
?>