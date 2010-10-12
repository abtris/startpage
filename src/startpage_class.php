<?php
/**
 * Library class for startpage
 * @author Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright Copyright (c) 2007-2008
 * @package startpage
 * @version $Id: startpage_class.php,v b532b0fd7e1c 2009/08/26 09:14:02 ladislav $
 */
/**
 * Include config
 */
include_once "config.inc.php";
/**
 * Class startpage
 * @static
 * @package startpage
 */
class StartPage
{
    /**
     * konstruktor
     */
    private function __construct ()
    {    // zabranime vytvoreni tridy
    }
    /**
     * Apache info
     *
     * These functions are only available when running PHP as an Apache module.
     * It depends on settings in httpd.conf ServerTokens
     * ServerTokens Minimal are recommended. File is at Ubuntu /etc/apache2/conf.d/security
     *
     * @return string
     */
    public static function apacheInfo ()
    {
        if (function_exists('apache_get_version')) {
            $a = apache_get_version();
            $b = substr($a, strpos($a, "/") + 1, strlen($a));
            return $b;
        } else {
            return "N/A";
        }
    }
    /**
     * Mysql info
     * @return string
     */
    public static function mysqlInfo ()
    {
        $link = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
        if (! $link) {
            return "N/A";
        }
        $a = mysql_get_server_info();
        $b = substr($a, 0, strpos($a, "-"));
        return $b;
    }
    /**
     * Sqlite info
     * @return string
     */
    public static function sqliteInfo ()
    {
        try {
            $dbh = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . SQLITE_TEST_DB); // success
            foreach ($dbh->query('SELECT sqlite_version()') as $row) {
                return ($row[0]);
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            return "N/A";
        }
    }
    /**
     * get PEAR package version
     * @param string $packageName
     * @return string
     */
    public static function getPearPackageVersion($packageName)
    {
        // pear info phpDocumentor | grep 'Release Version' | awk '{print $3}'
        $out = shell_exec("pear info $packageName | grep 'Release Version' | awk '{print $3}'");
        return $out;
    }
    /**
     * Get version
     * @return unknown_type
     */
    public static function getPhpUnitVersion()
    {
        $out = system("phpunit --version | grep PHPUnit | awk '{print $2}'");
        return $out;
    }
    
    /**
     * Print_d
     * @param mixed $var
     * @return void
     */
    public static function printDebug ($var)
    {
        echo "<pre>";
        if (is_array($var) || is_object($var)) {
            print_r($var);
        } else {
            var_dump($var);
        }
        echo "</pre>";
    }
    /**
     * svnVersion - from bash
     * @return string
     */
    public static function svnVersion()
    {
       $output = shell_exec('svn --version | grep "svn, version"');
        // svn, version 1.5.1 (r32289)
       $pattern = '/(\d.\d.\d)/';
       preg_match($pattern, $output, $matches, PREG_OFFSET_CAPTURE, 3);
       if (!empty($matches[0][0])) {
         return $matches[0][0];
       } else {
         return "N/A";
       }

    }
    /**
     * Message replace
     * @param string $msg
     * @return string
     */
    public static function messageReplace ($msg)
    {
        // Ticket XXXX nahradit Ticket <a href='https://helpdesk.cvut.cz/ets/0/showTicket?id=XXXX'>XXXX</a>
        $string = $msg;
        $pattern = '/Ticket: (\d+)/';
        $replacement = "<strong><a href='" . BUG_URL . "$1'>Ticket: $1</a></strong>";
        return preg_replace($pattern, $replacement, $string);
    }
    /**
     * Check date range for display another color today and yesterday
     * @param string $date1 in DATE_ISO8601
     * @param int days
     * return bool
     */
    public static function dateRange ($date1, $range)
    {
        $date1 = date_parse($date1);
        $date2 = date(DATE_ISO8601); // actual date
        $date2 = date_parse($date2);
        if ($date1['year'] == $date2['year']) {
            if ($date1['month'] == $date2['month']) {
                if ($date1['day'] == $date2['day'] || $date1['day'] + $range == $date2['day']) {
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * Date replace
     *
     * Zmena formatovani z ISO na cesky zvyk DD.MM.RRRR
     *
     * @param string $date
     * @return string
     */
    public static function dateReplace ($date)
    {
        $date = date_parse($date);
        $date = sprintf("%02d.%02d.%04d %02d:%02d:%02d", $date['day'], $date['month'], $date['year'], $date['hour'], $date['minute'], $date['second']);
        return $date;
    }
    /**
     * Truncate
     * @param string $text Text ke zkrácení
     * @param int $numb Kolik znaků je platných
     * @param string $etc='...' Způsob zakončení
     * @return string
     */
    public static function truncate ($text, $numb, $etc = "...")
    {
        if (strlen($text) > $numb) {
            $text = substr($text, 0, $numb);
            $text .= $etc;
        }
        return $text;
    }
    /**
     * Changelog
     *
     * Changelog structure
     * <code>
     * YYYY-MM-DD John Doe johndoe@example.com
     *
     *  * myfile.ext (myfunction): my changes made
     *   additional changes
     *
     *   * anotherfile.ext (somefunction): more changes
     * </code>
     * XML output from SVN
     * <code>
     * <log>
     * <logentry revision="165">
     * <author>abtris</author>
     * <date>2008-03-26T13:36:35.586000Z</date>
     * <msg>
     * Ticket: 000041
     * Napojeni nazvu ve filtru na db, table status
     * </msg>
     * </logentry>
     * </log>
     * </code>
     * @param string $path
     * @param bool $last
     * @param string $id
     */
    public static function changeLog ($path, $last, $id = NULL)
    {
        // Changelog
        if (!$last) {
            // REP exits
            $repExists = 0;
        }
        // XML log exists
        if (file_exists($path)) {
            // kontrola validity XML
            $xml = @simplexml_load_file($path);
            if (! $xml) {
                if (! $last)
                    echo "<h2 class='error'>Changelog in $path isn't valid XML file.</h2>";
                return false;
            }
        } else {
            // if file not exists
            echo "<h2>Failed to open " . $path . "</h2";
            exit();
        }
        // last revision
        if ($last) {
            if (isset($_GET['rev']) && $path == $_GET['file']) {
                $keys = array();
                foreach ($xml->children() as $i) {
                    array_push($keys, (int) $i['revision']);
                }
                $key = array_search($_GET['rev'], $keys);
                $lastkey = end(array_keys($keys));
                $val = array_values($keys);
                if ($_GET['pos'] == "next") {
                    if ($key > 0) {
                        $rev = $val[$key - 1];
                    } else {
                        $rev = $val[$key];
                    }
                }
                if ($_GET['pos'] == "prev") {
                    if ($key < $lastkey) {
                        $rev = $val[$key + 1];
                    } else {
                        $rev = $val[$lastkey];
                    }
                }
                // use xpath lookfor rev in XML
                if (! empty($rev)) {
                    $xpath = "//logentry[@revision=" . $rev . "]";
                    foreach ($xml->xpath($xpath) as $res) {
                        // print
                        echo "<td class='msg'>";
                        echo "<strong>";
                        printf("R%d %s %s", $res['revision'], self::dateReplace($res->date), $res->author);
                        echo "</strong>";
                        echo "&nbsp;<a href='?file={$path}&rev={$res['revision']}&pos=prev#$id'>";
                        echo "&laquo;</a>{$res['revision']}<a href='?file={$path}" . "&rev={$res['revision']}&pos=next#$id'>&raquo;</a>";
                        echo "<br />";
                        echo nl2br(self::messageReplace($res->msg));
                        echo "<br />";
                        echo "</td>";
                    }
                }
            } else {
                echo "<td class='msg'>";
                echo "<strong>";
                // comapre revision for git
                if (strlen((string)$xml->logentry['revision'])==strlen((int)$xml->logentry['revision'])) {
                printf("R%d %s %s", $xml->logentry['revision'], self::dateReplace($xml->logentry->date), $xml->logentry->author);
                } else {
                printf("%s %s", self::dateReplace($xml->logentry->date), $xml->logentry->author);
                }
                echo "</strong>";
                echo "&nbsp;<a href='?file={$path}&rev={$xml->logentry['revision']}";
                echo "&pos=prev#$id'>&laquo;</a>{$xml->logentry['revision']}";
                echo "<a href='?file={$path}&rev={$xml->logentry['revision']}&pos=next#$id'>&raquo;</a>";
                echo "<br />";
                echo nl2br(self::messageReplace($xml->logentry->msg));
                echo "<br />";
                echo "</td>";
            }
        } else {
            // all revisions
            echo "<table id='changelog'>";
            echo "<tr><th>Revision</th><th>Message</th><th>Date</th><th>Author</th></tr>";
            foreach ($xml->children() as $i) {
                if (self::dateRange($i->date, 0)) {
                    echo "<tr class='thisday'>";
                } elseif (self::dateRange($i->date, 1)) {
                    echo "<tr class='dayback'>";
                } else {
                    echo "<tr>";
                }
                // revision
                echo "<td>" . $i['revision'] . "</td>";
                // msg
                echo "<td class='msg'>" . nl2br(self::messageReplace(htmlspecialchars($i->msg)));
                // path
                if (! empty($i->paths->path)) {
                    echo "<div class='path'>";
                    foreach ($i->paths->path as $k) {
                        if (REP_BROWSER != "" && $repExists == 1) {
                            echo $k['action'] . " - <a href='" . REP_BROWSER . "{$repName}{$k}'>" . self::truncate($k, 78) . "</a><br />";
                        } elseif (isset($k['action'])) {
                            echo $k['action'] . " - " . self::truncate($k, 78) . "<br />";
                        
                        }
                        // detect hg or git
                        if (!isset($k['action'])) {
                            $files = explode(" ",$k);
                            foreach ($files as $file) {
                                echo $file."<br />";
                            }
                        }
                        // for tags and branches
                        if ( isset($k['copyfrom-path']) && isset($k['copyfrom-rev']) ) {
                        echo "<strong>";
                        echo "Copy from: {$k['copyfrom-path']} (";
                        echo "R{$k['copyfrom-rev']})";
                        echo "</strong><br />";
                        }
                        
                    }
                    echo "</div>";
                }
                echo "</td>";
                // date
                echo "<td>";
                echo self::dateReplace($i->date);
                echo "</td>";
                // author
                echo "<td>" . $i->author . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } // end changelog
    /**
     *  Etc/hosts
     *  @return array
     */
    public static function hosts ()
    {
        // detekce OS
        if (preg_match("/linux/i", $_SERVER['HTTP_USER_AGENT'])) {
            $os = "linux";
        } elseif (preg_match("/win32/i", $_SERVER['HTTP_USER_AGENT'])) {
            $os = "win";
        } else {
            $os = "win";
        }
        if ($os == "win") {
            $filename = $_SERVER['WINDIR'] . "\system32\drivers\etc\hosts";
        } else {
            $filename = "/etc/hosts";
        }
        if (file_exists($filename)) {
            $obsah = file_get_contents($filename);
            $reg = '/^(\d+.\d+.\d+.\d+)\s+(\S+)/m';
            preg_match_all($reg, $obsah, $matches, PREG_SET_ORDER);
            return $matches;
        }
    }
    /**
     * Apache error log
     */
    public static function showErrorLog ()
    {
        echo "<div id='main'><h1>Apache error log</h1>";
        if (file_exists(APACHELOG_PATH)) {
        // errorlog
        echo "<table id='changelog'>";
        echo "<tr><th>Date</th><th>Message</th></tr>";
        $path = APACHELOG_PATH;
        $output = shell_exec('tail '.$path);
       
        $pole = explode("\n",$output);
        
        // parse lines
        foreach($pole as $line) {
            if (!empty($line)) {
            preg_match('~^\[(.*?)\]~', $line, $date);
            if (empty($date[1])) {
                continue;
            }
            //preg_match('~\] \[([a-z]*?)\] \[~', $line, $type);
            //preg_match('~\] \[client ([0-9\.]*)\]~', $line, $client);
            preg_match('~\] (.*)$~', $line, $message);

            echo "<tr>";
            echo "<td>$date[1]</td>";
            //echo "<td>$type[1]</td>";
            //echo "<td>$client[1]</td>";
            echo "<td style='text-align:left'>$message[1]</td>";
            echo "</tr>";
            }
        }
        echo "</table></div>";
            return true;
        } else {
            echo "Error log not found in ".APACHELOG_PATH;
            return false;
        }
        
    }
    /**
     * Infoini
     * @param string $string
     * @return string
     */
    public static function infoIni ($string)
    {
        if (ini_get($string) == 0) {
            return "Off";
        } else {
            return "On";
        }
    }
    /**
     * Check extension
     * @param $string
     * @return unknown_type
     */
    public static function checkExt ($string)
    {
        $j = 0;
        $pole = get_loaded_extensions();
        foreach ($pole as $i) {
            if ($i == $string)
                $j = 1;
        }
        if ($j == 1) {
            return "<strong>Installed</strong>";
        } else {
            return "<strong>Not available</strong>";
        }
    }
    /**
     * Lists of projects, in $root directory can used some mask
     * @param string $root
     * @return mixed
     */
    public function listProject ($root, $url)
    {
        echo "<p><strong>Working copies at $root</strong></p>";
        echo "<table id='wc'>";
        echo "<tr class='firstrow'><th>Name</th><th>SCM</th><th>Links</th>
        <th>Last record from history</th></tr>";
        foreach (glob($root . PROJECT_FILTER, GLOB_ONLYDIR) as $dirs) {
            echo "<tr>";
            echo "<td class='name' id='" . basename($dirs) . "'>
            <a href='". $url . basename($dirs) . "'>" . basename($dirs) . "</a></td>";
            // xmllog is name with path etc. /tmp/start_page_cheangelog.xml
            // build by hook post-commit script
            $xmllog = $dirs . XMLLOGNAME;
            echo "<td  class='log'>";
            if (file_exists($dirs.'/.svn')) {
                $output = shell_exec("svn info $dirs | grep 'URL' | awk '{print $2}'");
                echo "<a href='".$output."'>SVN</a>";
            }
            if (file_exists($dirs.'/.git')) {
                echo "GIT";
            }
            if (file_exists($dirs.'/.hg')) {
              if (file_exists($dirs.'/.hg/hgrc')) {
                  $q= "cat ". $dirs."/.hg/hgrc | egrep 'default =' | awk '{ print $3 }'";
                  $hgrc = shell_exec($q);
                  if (isset($hgrc)) {
                    echo "<a href='".$hgrc."'>HG</a>";
                  } else {
                    echo "HG";
                  }
                } else {
                echo "HG";
                }
            }
            echo "</td>";
            if (file_exists($xmllog)) {
                echo "<td class='log'>";
                echo "<a href='" . BASE_URL . "changelog.php?file=$xmllog'>Log</a> ";
                echo "<a href='" . WIKI_LINK . basename($dirs) . "'>Wiki</a>";
                //echo "<a href='changelog.php?rep=".substr($dirs, strpos($dirs, "/")+1,strlen($dirs))."'>Log</a>
                echo "</td>";
            } else {
                echo "<td></td>";
            }
            // This part is for last revision (display rev and message)
            if (file_exists($xmllog)) {
                StartPage::changeLog($xmllog, true, basename($dirs));
            }
            //
            echo "</tr>";
        }
        echo "</table>";
    }
    
    public function listProjects ($root)
    {
        $urls = explode('|',PROJECT_URL);
        $roots = explode('|',$root);
        
        for ($i=0;$i<count($roots);$i++){
            self::listProject($roots[$i],$urls[$i]);
        }
    }
    
} // end class
