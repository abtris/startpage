<?php
/**
 * @package startpage
 * @author Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright Copyright (c) 2007-2008
 * @version $Id: index.php,v f99124d6fbe3 2009/09/22 12:39:22 ladislav $
 * @filesource
 */

/**
 *  Include configuration
 */
include_once "config.inc.php";
/**
 * Include library class
 */
include_once "startpage_class.php";
/**
 * Zend version
 */
if (file("Zend/Version.php", FILE_USE_INCLUDE_PATH)) {
    include_once "Zend/Version.php";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo BASE_URL; ?>/startpage.css" type="text/css" rel="stylesheet" />
<title><?php echo strtolower(php_uname('n')); ?></title>
<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://localhost/piwik/" : "http://localhost/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://localhost/piwik/piwik.php?idsite=1" style="border:0" alt=""/></p></noscript>
<!-- End Piwik Tag -->
</head>
<body>
<?php
/**
 * Navigation
 */
if (isset($_GET['node'])) {
    switch ($_GET['node']) {
        case "svn":
            set_time_limit(0);
            svn_update();
            header("Location: index.php");
            exit;
        case "info":
            ob_start();
            phpinfo();

            preg_match('%<style type="text/css">(.*?)</style>.*?(<body>.*</body>)%s', ob_get_clean(), $matches);

            # $matches [1]; # Style information
            # $matches [2]; # Body information
            echo "<div id='main'><div id='info'>";
            echo $matches[2]."\n</div>\n";
            echo "</div></div>";
            exit;
        case "errors":
            StartPage::showErrorLog();
            exit;
    }
}

setlocale(LC_ALL, 'cs_CZ', 'cz');
?>
<div id="main"><!--
        <ul id="tabnav">
            <li class="tab1"><a href="?node=dash">Dashboard</a></li>
            <li class="tab2"><a href="?node=log">Changelog</a></li>
            <li class="tab3"><a href="?node=review">Review</a></li>
            <li class="tab4"><a href="?node=deploy">Deployment</a></li>
            <li class="tab5"><a href="?node=admin">Administration</a></li>
        </ul>
        --> <?php

        if (isset($_GET['node'])) {
            if (file_exists($_GET['node'].".php")) include($_GET['node'].".php");
        } else {
            include ("dash.php");
        }

        ?> <br />
<div id="foot">Copyright &copy; 2007-2009 Ladislav Prskavec,
<a href="http://blog.prskavec.net">http://blog.prskavec.net</a></div>
</div>
</body>
</html>
