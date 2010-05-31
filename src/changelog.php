<?php
/**
 * @package startpage
 * @author Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright Copyright (c) 2007-2008
 * @version $Id: changelog.php,v f99124d6fbe3 2009/09/22 12:39:22 ladislav $
 * @filesource
 */
/**
 * Include config
 */
include_once "config.inc.php";
 $debug=0;
 $changelog=$_GET['file'];
 $changelogName = basename($changelog);
 /**
  * Include class
  */
 include_once "startpage_class.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
 <head>
  <meta name="generator" content="PSPad editor, www.pspad.com" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link href="<?php echo BASE_URL; ?>/startpage.css" type="text/css" rel="stylesheet" />
  <title><?php echo "Changelog ".str_replace(XMLLOGNAME, "", $changelogName); ?></title>
 </head>
 <body>
 <div id="main">
<?php
    echo "<h1>Changelog ".str_replace(XMLLOGNAME, "", $changelogName)."</h1>";
    StartPage::changeLog($changelog, false);
?>
<p class="foot"><?php echo "Generated:".date(DATE_RFC822); ?></p>
</div>
</body>
</html>
