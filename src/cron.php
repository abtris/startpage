#!/usr/local/zend/bin/php
<?php
include_once "config.inc.php";

// take arguments
$skipSvn = false;
$allSvn = false;
// command line arguments
if (isset($argv[1])) {
    switch ($argv[1]) {
        case "--skipSvn":
            $skipSvn = true;
            break;
        case "--allSvn":
            $allSvn = true;
            break;
        case "--help":
            echo 'SVN changelog $Id: cron.php,v af678c04bdb8 2009/07/24 06:04:33 ladislav $ Ladislav Prskavec'."\n";
            echo "\n";
            echo "Usage: php cron.php [options]\n";
            echo "\n";
            echo "  --help            Help\n";
            echo "  --skipSvn         skip check SVN directories\n";
            echo "  --allSvn          make log for whole repository, not URL\n";
            exit;
            break;
    }
}

$roots = explode('|', PROJECT_PATH);
if ($roots[0]=="/srv/www2/") unset($roots[0]);

$pwd = shell_exec("pwd");

foreach ($roots as $i) {
    foreach (glob ($i.'*',GLOB_ONLYDIR) as $dirs) {
        // echo "Make: $dirs\n";
        // SVN
        if (!$skipSvn) {
            if (file_exists($dirs.'/.svn/entries')) {
            echo "$dirs" . "\n";
            exec("cd $dirs");
            exec("svn up $dirs");
            // for All repository
            if ($allSvn) {
            $output = shell_exec("svn info $dirs | grep 'Root' | awk '{print $3}'");
            } else {
            // for URL repository
            $output = shell_exec("svn info $dirs | grep 'URL' | awk '{print $2}'");
            }
            $out = shell_exec("svn log --xml -v $output");
            if (!empty($out) && strlen($out)>28) {
            file_put_contents("{$dirs}.xml",$out);
            }
            }
        }
        // HG
        if (file_exists($dirs.'/.hg')) {
            echo "$dirs" . "\n";
            exec("hg pull $dirs");
            exec("sh ".dirname(__FILE__)."/bin/hglog.sh $dirs");
        }
        // GIT
        if (file_exists($dirs.'/.git')) {
            echo "$dirs" . "\n";
            exec("sh ".dirname(__FILE__)."/bin/gitlog.sh $dirs");
        }
    }
}



echo "Done\n";
