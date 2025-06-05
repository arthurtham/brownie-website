<?php

$dir = dirname(__DIR__, 1);
$title = "IRIAM Rewards Editor";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";
require $dir . "/includes/cloudinary.env.php";
require_once($dir . "/includes/mysql.php");


$_SESSION['cloudinary_timer_start']=time();
?>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
  <h1>Asset Uploader</h1>
  <p>Upload your asset here to continue.</p>
  <p><a href="iriam_rewards.php"><button class="btn btn-danger" type="button">Cancel (Back to Rewards List)</button></a></p>
  
  <div id="cloudinary-upload-widget-span" style="display: span;">
      
  </div>

  <div id="results-div" class="alert alert-dark" style="display: none">
    <h3>Upload successful!</h3>
    <p>Waiting 10 seconds for Cloudinary processing. Please wait...</p>
  </div>
</div>

<script type="text/javascript"> 
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
      uploadPreset: "<?=$CLOUDINARY_IRIAM_PREFIX ?>",
      //public_id: "",
      uploadSignature: generateSignature,
      sources: [
          "local"
      ],
      text: {
        "en": {
          "queue": {
            "title_uploading_with_counter": "Uploading...",
            "title_processing_with_counter": "Processing..."
          },
          "local": {
            "dd_title_single": "Drag and Drop Your Asset Here",
            "browse": "Browse..."
          }
        }
      },
      showAdvancedOptions: true,
      cropping: false,
      multiple: false,
      defaultSource: "local",
      clientAllowedFormats: "mp4,mkv,mov,webp,png,jpg,jpeg,gif,zip",
      resourceType: "auto",
      maxFileSize: "104857600",
      thumbnails: false,
      autoMinimize: false,
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
          alert("Error: This file already exists.\nPlease refresh this page and try again.");
          myWidget.close();
          myWidget.open();
        } else {
          // for debug, print the result.info
          console.log(result.info);
          // collect relevant data for processing post request
          var public_id = result.info.public_id; // includes the folder path
          var public_id_name_only = public_id.split("/").pop(); // get the last part of the public_id
          
          myWidget.close({quiet: true});
          document.getElementById("cloudinary-upload-widget-span").style.display = "none";
          document.getElementById("results-div").style.display = "block";

          // Create a get request using the public id and go to the editor page with it
          var form = document.createElement("form");
          form.setAttribute("method", "get");
          form.setAttribute("action", "/admin/iriam_rewards_editor.php");
          form.setAttribute("style", "display: none;");
          var inputPublicId = document.createElement("input");
          inputPublicId.setAttribute("type", "hidden");
          inputPublicId.setAttribute("name", "public-id");
          inputPublicId.setAttribute("value", public_id_name_only);
          form.appendChild(inputPublicId);
          document.body.appendChild(form);
          setTimeout(() => {
            form.submit()
          }, 10000);
        }
      } else if (!error && result) {
      } else {
        alert("Error: " + error["statusText"] + "\nPlease refresh this page and try again.");
        myWidget.close();
        myWidget.open();
      }
    });

<?php
echo "myWidget.open();";

?>
</script>


<?php
require $dir . "/templates/footer.php"; 
?>