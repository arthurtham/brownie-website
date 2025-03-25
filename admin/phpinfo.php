<?php

$dir = dirname(__DIR__, 1);
$title = "PHPInfo";
require $dir . "/includes/admin-check.php";
require $dir . "/includes/default-includes.php";
require $dir . "/templates/header.php";

?>
<style type="text/css">
#phpinfo {overflow-wrap: anywhere;overflow-x:auto}
#phpinfo pre {}
#phpinfo a:link {}
#phpinfo a:hover {}
#phpinfo table {border: 0px solid; }
#phpinfo .center {}
#phpinfo .center table {}
#phpinfo .center th {font-weight:bold}
#phpinfo td, th {min-width:200px}
#phpinfo h1 {}
#phpinfo h2 {}
#phpinfo .p {}
#phpinfo .e {}
#phpinfo .h {}
#phpinfo .v {}
#phpinfo .vr {}
#phpinfo img {}
#phpinfo hr {}
</style>

<div class="container body-container">
    <div class="row mb-2">
        <div class="col">
            <h1>PHP Info</h1>
            <a href="/admin" class="btn btn-danger">Return to Main Menu</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div id="phpinfo">
            <?php 
            ob_start () ;
            phpinfo () ;
            $pinfo = ob_get_contents() ;
            ob_end_clean () ;
            
            // the name attribute "module_Zend Optimizer" of an anker-tag is not xhtml valide, so replace it with "module_Zend_Optimizer"
            echo ( str_replace ( "module_Zend Optimizer", "module_Zend_Optimizer", preg_replace ( '%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo ) ) ) ;
            ?>
            </div>
        </div>
    </div>
</div>

<?php
$_footer_adminmode = true; require $dir . "/templates/footer.php";
?>