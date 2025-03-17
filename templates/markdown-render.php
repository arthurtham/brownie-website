<?php
if (!isset($embed_contents)) {
    $embed_contents = "";
}
$_mdconfig = HTMLPurifier_Config::createDefault();
// $_mdconfig->set('HTML.Allowed', 'a[href],b,strong,i,em,p,br,ul,ol,li,blockquote,code,pre,table,thead,tbody,tr,th,td');
$_mdconfig->set('HTML.SafeScripting', array("https://platform.twitter.com/widgets.js"));
$_mdconfig->set('HTML.SafeIframe', true);
$_mdconfig->set('URI.SafeIframeRegexp', '%^(https?:)?//(www.youtube.com/|youtube.com/|youtu.be/)%');
echo (new HTMLPurifier($_mdconfig))->purify(Parsedown::instance()->setBreaksEnabled(true)->text($embed_contents));