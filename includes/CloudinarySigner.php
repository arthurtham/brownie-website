<?php

require_once "cloudinary.env.php";

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\{
  ImageTransformation,
  VideoTransformation,
  Delivery,
  Format
};

class CloudinarySigner {
    private $cld;
    private $cldUrlPattern;

    public function __construct() {
        global $CLOUDINARY_CONFIG;
        $this->cld = new Cloudinary($CLOUDINARY_CONFIG);
        $this->cldUrlPattern = '/(?:https:\/\/res.cloudinary.com\/browntulstar\/?)(image|video)\/(private|authenticated|upload)\/(.*)\/com\.browntulstar\/(.*)\.(.*)/';
    }

    public function signUrl($url) {
        $original_url = trim($url,"()");
        if (strpos($url, "s--") !== false) {
            return $original_url;
        }
        $cldUrlPatternArray = null;
        preg_match($this->cldUrlPattern, $url, $cldUrlPatternArray);

        /*
        0	=>	Full URL
        1   =>  "image" or "video" (literal)
        2	=>	Delivery Type
        3	=>	Transformation
        4	=>	public id: /com.browntulstar/<input>.<format>
        */

        if (count($cldUrlPatternArray) < 4) {
            return $original_url;
        }
        
        $urlformat = null;
        preg_match("/(.*)\.(webp|mp4|mov|jpg|png)/", $url, $urlformat);
        if (count($urlformat) > 0) {
            $public_id = $cldUrlPatternArray[4];
            $extension = $urlformat[2];
        } else {
            $public_id = $cldUrlPatternArray[4];
            $extension = "";
        }

        $versionAndTransformation = null;
        preg_match("/(.*)\/(v[0-9]*).*/", $cldUrlPatternArray[3], $versionAndTransformation);
        if (count($versionAndTransformation) > 3) {
            $version = $versionAndTransformation[2];
            $transformation = $versionAndTransformation[1];
        } else {
            preg_match("(v[0-9]*)", $cldUrlPatternArray[3], $versionAndTransformation);
            if (count($versionAndTransformation) > 0) {
                $version = $cldUrlPatternArray[3];
                $transformation = "";
            } else {
                $version = "1";
                $transformation = $cldUrlPatternArray[3];
            }
        }

        if ($cldUrlPatternArray[1] === "image") {
            $url = $this->cld->image("com.browntulstar/".$public_id);
        } else if ($cldUrlPatternArray[1] === "video") {
            $url = $this->cld->video("com.browntulstar/".$public_id);
        }
        $url = $url->addTransformation($transformation)->version(intval($version))->deliveryType($cldUrlPatternArray[2]);
        switch ($extension) {
            case "webp": $url = $url->delivery(Delivery::format(Format::webp())); break;
            case "jpg" : $url = $url->delivery(Delivery::format(Format::jpg())); break;
            case "mp4" : $url = $url->delivery(Delivery::format(Format::MP4)); break;
            case "mov" : $url = $url->delivery(Delivery::format(Format::MOV)); break;
            case "png" : $url = $url->delivery(Delivery::format(Format::png())); break;
            default:     $url = $url->delivery(Delivery::format(Format::auto()));
        }
        $url = $url->signUrl()->toUrl();
        return $url;
    }

    public function signUrlHelperParens($url_array) {
        return "(".$this->signUrl($url_array[0]).")";
    }

    public function signUrlHelperQuotes($url_array) {
        return "\"".$this->signUrl($url_array[0])."\"";
    }

    public function signUrlsInMarkdown($markdown_text) {
        $new_markdown_text = preg_replace_callback(
            '/\(https:\/\/res.cloudinary.com\/browntulstar\/.*\)/',
            array($this, "signUrlHelperParens"),
            $markdown_text);
        $new_markdown_text = preg_replace_callback(
            '/\"https:\/\/res.cloudinary.com\/browntulstar\/.*\"/',
            array($this, "signUrlHelperQuotes"),
            $new_markdown_text);
        return $new_markdown_text;
    }

    public function localToCloudinaryHelper($url) {
        if ($url[1] === "travelblog") {
            $prefix = "nyc22_blog_post";
        } else if ($url[1] === "gamedevlogs") {
            $prefix = "gamedev_blog_post";
        }

        if ($url[3] === "jpg" || $url[3] === "png") {
            $extension = "webp";
            $mediatype = "image/private/c_pad,w_400";
        } else if ($url[3] === "mov" || $url[3] === "mp4") {
            $extension = "mp4";
            $mediatype = "video/upload/q_auto";
        }
        $new_url = "https://res.cloudinary.com/browntulstar/".$mediatype."/com.browntulstar/".$prefix."/".$url[2].".".$extension;
        return $new_url;
    }

    public function convertLocalUrlsToCloudinaryUrls($markdown_text) {
        $new_markdown_text = preg_replace_callback(
            '/\/subs\/blog\/(travelblog|gamedevlogs)\/media\/([^.]*).(jpg|png|mov|mp4)/',
            array($this, "localToCloudinaryHelper"),
            $markdown_text);
        return $this->signUrlsInMarkdown($new_markdown_text);
    }

    public function convertAllUrls($markdown_text) {
        return $this->convertLocalUrlsToCloudinaryUrls($markdown_text);
    }
    
    
}