<?php
$dir = dirname(__DIR__, 2);
$title = "BrowntulStar - Book a Service - Success";
require $dir . "/templates/header.php";
echo '<script src="/assets/js/bootstrap-tab.js"></script>';
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 style="text-align: center;">Thank you!</h1>
    <p>Thanks for your interest in Browntul's services.</p>
    <p>When you request a service, Browntul will be notified 
        via PayPal to review your request. He will then contact
    you via Discord or Email to discuss the opportunity. If he 
    accepts the request, you will be send an invoice via PayPal.</p>

    <p>Thank you for your request! Browntul will review it as soon as he can.</p>
    <p>Your request ID is "<?php echo $_SESSION["last_request_id"] ?>". Please save it for your records. 
    You can also view your past requests by going to the "My Requests" page in the dropdown menu.</p>
    <p>If you have any questions, please contact Browntul via the Contact button on the top of the page.</p>

    <a href="/store"><button class="btn btn-primary">Back to store</button></a>
    </div>

<?php require $dir . "/templates/footer.php" ?>