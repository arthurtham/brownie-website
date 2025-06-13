<?php
if (!isset($embed_contents)) {
    $embed_contents = "";
}
$_mdconfig = HTMLPurifier_Config::createDefault();
$_mdconfig->set('HTML.DefinitionID', 'com-browntulstar-markdown-video-support');
$_mdconfig->set('HTML.DefinitionRev', 1);
$_mdconfig->set('HTML.SafeScripting', array("https://platform.twitter.com/widgets.js"));
$_mdconfig->set('HTML.SafeIframe', true);
$_mdconfig->set('URI.SafeIframeRegexp', '%^(https?:)?//(www.youtube.com/|youtube.com/|youtu.be/)%');

if ($def = $_mdconfig->maybeGetRawHTMLDefinition()) {
    $def->addElement(
        'video',
        'Block',
        'Flow', // Simpler and safe content model
        'Common',
        [
            'src' => 'URI',
            'controls' => 'Bool',
            'width' => 'Length',
            'height' => 'Length',
            'poster' => 'URI',
            'preload' => 'Enum#auto,metadata,none',
            'autoplay' => 'Bool',
            'loop' => 'Bool',
            'muted' => 'Bool'
        ]
    );
    $def->addElement(
        'source',
        'Inline',
        'Empty',
        'Common',
        [
            'src' => 'URI',
            'type' => 'Text'
        ]
    );
}

echo (new HTMLPurifier($_mdconfig))->purify(Parsedown::instance()->setBreaksEnabled(true)->text($embed_contents));
