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
else if (!(check_guild_membership($cloudinary_guild_id) || 
  (check_guild_membership($brownieval_guild_id) && check_roles([$brownieval_admin_access_id])) || 
  (check_guild_membership($guild_id) && check_roles($sub_perk_roles) )) 
  ) {
		echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
    echo "<div class='alert alert-danger' role='alert'>
		<center>This BrownieVAL tool requires you to have the appropriate roles on Discord.
    Get this role first, then re-log in to this website.</center>
		</div></div>";
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

    <div class="alert alert-success">
      <p><strong>Upload your best VALORANT clip (up to 15 seconds in length) and post it 
      on Twitter/X with the hashtag #BrownieVAL and #MyBrownieVALClip!</strong> Then, you'll get 
      to see how cool it is to be in #BrownieVAL!</p>
      <ul>
        <li>Upload your best VALORANT clip (Resolution: 16:9 or 1920x1080)</li>
        <li>Max length: 15 sec. Max file size: 100 MB.</li>
        <li>Wait for a while for the video to generate.</li>
        <li>The resulting video will appear below, and you can download it and post it on social media!</li>
        <li>If there is an error, refresh the page and try again.</li>
      </ul>
      <p>In this demo, users can upload their VALORANT clips and then add
      the BrownieVAL special overlays on top of it.</p>
    </div>
    <div class="alert alert-danger">
      <p><strong>Abuse of this tool will lead to a irrevocable ban on all social media platforms
        that Browntul and BrownieVAL is on.</strong></p> 
    </div>

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
      uploadPreset: "com-browntulstar-brownieval-generator-v1",
      context: {
        username: "<?=$_SESSION["username"] ?>"
      },
      uploadSignature: generateSignature,
      sources: [
          "local",
          "google_drive"
      ],
      showAdvancedOptions: false,
      cropping: false,
      multiple: false,
      defaultSource: "local",
      clientAllowedFormats: "mp4",
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
      }
    });

    myWidget.open();
</script>


<?php
require $dir . "/templates/footer.php"; 
?>