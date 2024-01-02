<?php

require_once "cloudinary.env.php";
use Cloudinary\Api\Search\SearchApi;
use Cloudinary\Api\Admin\AdminApi;


$result = (new SearchApi())->expression(
    $CLOUDINARY_DELETE_EXPRESSION
    )
    ->sortBy('uploaded_at','desc')
    ->execute();

$uploaded_at = array();
$public_ids_to_delete = array();
foreach ($result["resources"] as $rid => $resource) {
    array_push($uploaded_at, array(
        "upload_date" => $resource["uploaded_at"],
        "public_id" => $resource["public_id"],
        "asset_id" => $resource["asset_id"]
    ));
    array_push($public_ids_to_delete, $resource["public_id"]);
}

$admin_api = new AdminApi();

foreach (array_chunk($public_ids_to_delete, 100) as $public_ids_to_delete_chunk) {
    // echo "<pre>";
    // print_r($public_ids_to_delete_chunk);
    // echo "</pre>";
    // echo "<pre>";
    print_r($admin_api -> deleteAssets($public_ids_to_delete_chunk, array(
        "invalidate" => true,
        "resource_type" => "video"
    )));
    // echo "</pre>";
}

echo "List of deleted assets on ".date_format(date_create(),"c").": \n";
print_r($uploaded_at);
echo "\n";


?>