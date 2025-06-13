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
        $this->cldUrlPattern = '/(?:https:\/\/res.cloudinary.com\/browntulstar\/)(image|video)\/(private|authenticated|upload)\/(.*\/?)(com\.browntulstar)\/(.\S*\.(webp|mov|mp4|jpg|png|gif)*)/';
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
        4   =>  "com.browntulstar"
        5	=>	public id after 4: <input>
        6   => file extension (webp, mov, mp4, jpg, png, gif)
        */

        // error_log("Signing URL: ".var_export($cldUrlPatternArray, true));
        if (count($cldUrlPatternArray) < 5) {
            // var_dump("die");
            // var_dump($cldUrlPatternArray);
            return $original_url;
        }
        
        $urlformat = null;
        preg_match("/(.*)\.(webp|mp4|mov|jpg|png|gif)/", $url, $urlformat);
        if (count($urlformat) > 0) {
            $public_id_prefix = $cldUrlPatternArray[4];
            $public_id = $cldUrlPatternArray[5];
            $extension = $urlformat[2];
        } else {
            $public_id_prefix = $cldUrlPatternArray[4];
            $public_id = $cldUrlPatternArray[5];
            $extension = "";
        }

        if ($cldUrlPatternArray[1] === "image") {
            $url = $this->cld->image($public_id_prefix."/".$public_id);
        } else if ($cldUrlPatternArray[1] === "video") {
            $url = $this->cld->video($public_id_prefix."/".$public_id);
        }

        $versionAndTransformation = null;
        preg_match("/(.*)\/(v[0-9]*).*/", $cldUrlPatternArray[3], $versionAndTransformation);
        if (count($versionAndTransformation) > 3) {
            $version = $versionAndTransformation[2];
            $transformation = rtrim($versionAndTransformation[1], "/");
        } else {
            preg_match("(v[0-9]*)", $cldUrlPatternArray[3], $versionAndTransformation);
            if (count($versionAndTransformation) > 0) {
                $version = rtrim($cldUrlPatternArray[3], "/");
                $transformation = "";
            } else {
                $version = "1";
                $transformation = rtrim($cldUrlPatternArray[3], "/");
            }
        }

        if (!empty($transformation)) {
            // var_dump($transformation);
            $url = $url->addTransformation($transformation);
        }
        if (!empty($version)) {
            $url = $url->version(intval($version));
        }
        
        $url = $url->deliveryType($cldUrlPatternArray[2]);
        switch ($extension) {
            case "webp": $url = $url->delivery(Delivery::format(Format::webp())); break;
            case "jpg" : $url = $url->delivery(Delivery::format(Format::webp())); break;
            case "mp4" : $url = $url->delivery(Delivery::format(Format::MP4)); break;
            case "mov" : $url = $url->delivery(Delivery::format(Format::MP4)); break;
            case "png" : $url = $url->delivery(Delivery::format(Format::webp())); break;
            case "gif" : $url = $url->delivery(Delivery::format(Format::gif())); break;
            default:     if ($cldUrlPatternArray[1] === "image") {
                $url = $url->delivery(Delivery::format(Format::webp()));
            } else if ($cldUrlPatternArray[1] === "image") {
                $url = $url->delivery(Delivery::format(Format::MP4));
            } else {
                $url = $url->delivery(Delivery::format(Format::auto()));
            }
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
        $new_markdown_text = $markdown_text;
        $new_markdown_text = preg_replace_callback(
            '/\/subs\/blog\/(travelblog|gamedevlogs)\/media\/([^.]*).(jpg|png|mov|mp4)/',
            array($this, "localToCloudinaryHelper"),
            $new_markdown_text);
        $new_markdown_text = $this->signUrlsInMarkdown($new_markdown_text);
        $new_markdown_text = preg_replace_callback(
            '#https://res\.cloudinary\.com/browntulstar/image/(upload|private|authenticated)/s--[^/]+--((/c_pad,w_400)?)/f_webp/v1/com\.browntulstar/([a-zA-Z0-9]+)_blog_post/(.+?\.[a-zA-Z0-9]+)#',
            function ($matches) {
                $upload_type = $matches[1];
                $optional_transformation = $matches[3];
                $folder = $matches[4];
                $filename = pathinfo($matches[5], PATHINFO_FILENAME);
                return "https://res.cloudinary.com/browntulstar/image/$upload_type$optional_transformation/com.browntulstar/blog/$folder/$filename.webp";
            },
            $new_markdown_text
        );
        $new_markdown_text = preg_replace_callback(
            '#https://res\.cloudinary\.com/browntulstar/image/(upload|private|authenticated)/s--[^/]+--((/t_eastcoast-blog-photo)?)/v1/com\.browntulstar/([a-zA-Z0-9]+)_blog_post/(.+?\.[a-zA-Z0-9]+)#',
            function ($matches) {
                $upload_type = $matches[1];
                $optional_transformation = $matches[3];
                $folder = $matches[4];
                $filename = pathinfo($matches[5], PATHINFO_FILENAME);
                return "https://res.cloudinary.com/browntulstar/image/$upload_type$optional_transformation/com.browntulstar/blog/$folder/$filename.webp";
            },
            $new_markdown_text
        );
        $new_markdown_text = preg_replace_callback(
            '#https://res\.cloudinary\.com/browntulstar/video/(upload|private|authenticated)/s--[^/]+--/q_auto/f_mp4/v1/com\.browntulstar/([a-zA-Z0-9]+)_blog_post/(.+?\.mp4)#',
            function ($matches) {
                $upload_type = $matches[1];
                $folder = $matches[2];
                $filename = $matches[3];
                return "https://res.cloudinary.com/browntulstar/video/$upload_type/q_auto/com.browntulstar/blog/$folder/$filename";
            },
            $new_markdown_text
        );
        return $this->signUrlsInMarkdown($new_markdown_text);
    }

    public function convertAllUrls($markdown_text) {
        // Unneeded now, so ignore
        return $markdown_text;
        // return $this->convertLocalUrlsToCloudinaryUrls($markdown_text);
    }
    
    
}