<?php
/**
 * @package startpage
 * @author Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright Copyright (c) 2007-2008
 * @version $Id: dash.php,v e3522cfa8c28 2009/07/23 14:56:51 ladislav $
 * @filesource
 */
?>
        <h1 class='index'><?php echo strtolower(php_uname('n')); ?></h1>
        <p><span style='float:right'>
        <?php echo date(DATE_RFC850); ?></span><strong>Server OS</strong>
         - <?php echo php_uname('s')." ".php_uname('r'); ?></p>
        <div id="quicklinks">
            <div>
                <a href="<?php echo WIKI; ?>"><img src="<?php echo BASE_URL; ?>images/dokuwiki-128.png" alt="[WIKI]" /></a>
             </div>
            <p><span>
                    <a href="http://httpd.apache.org/">Apache</a>
                    <?php echo StartPage::apacheInfo();  ?>
                </span>
                <a href="?node=errors">error_log</a>
             </p>
            <p><span>
                    <a href="http://www.php.net">PHP</a>
                    <?php echo phpversion(); ?>
                </span>
                <a href="?node=info">phpinfo</a></p>
            <p><span>
                    <a href="http://www.mysql.com">MYSQL</a>
                    <?php echo StartPage::mysqlInfo(); ?></span><a href="
                    <?php echo MYADMIN_PATH; ?>">PhpMyAdmin</a> |
                    <a href="<?php echo MINADMIN_PATH; ?>?username=root">Adminer</a></p>
            <p><span>
                    <a href="http://www.sqlite.org/">SQLite</a>
                    <?php echo StartPage::sqliteInfo(); ?></span>
                    <?php if (file_exists(SQLITE_PATH)) { ?>
                    <a href="<?php echo SQLITE_PATH; ?>">SQLite Manager</a>
                    <?php } else { ?>
                    SQLite Manager not found
                    <?php }?>
                    </p>
            <p><span>
                    <a href="http://pear.php.net">PEAR <?php echo StartPage::getPearPackageVersion('PEAR');?></a></span>
                    <a href="http://www.phpdoc.org/">PHPDoc <?php echo StartPage::getPearPackageVersion('phpDocumentor');?></a>&nbsp;|
                    <a href="http://www.phpunit.org/">PHPUnit <?php echo StartPage::getPearPackageVersion('phpunit/PhpUnit'); ?></a>&nbsp;|
                    <a href="http://pear.php.net/package/PHP_CodeSniffer">PHPCS <?php echo StartPage::getPearPackageVersion('PHP_CodeSniffer'); ?></a>
                    </p>
            <p><span>
                    <a href="http://subversion.tigris.org/">Subversion</a>
                    <?php echo StartPage::svnVersion(); ?> </span><a href="
                    <?php echo SVN_PATH; ?>">Repository browser</a></p>
            <p><span>
                    <a href="http://framework.zend.com">Zend Framework</a>
                    <?php
                     if (class_exists('Zend_Version')) {
                            echo Zend_Version::VERSION;
                     } else {
                            echo "N/A";
                     }
                         ?>
                     </span>
                     <a href="http://framework.zend.com/manual/en/">Documentation</a>
                     |
                     <a href="https://localhost:10082/ZendServer/Login">Zend Server Console</a>
                     </p>
            <p><span>SEO</span>
             <a href="http://www.google.com/analytics/indexu.html">Google Analytics</a> |
             <a href="https://www.hittail.com">HitTail</a></p>

       </div>
      <div class="cols">
          
          <?php StartPage::listProjects(PROJECT_PATH); ?>
      </div>
      <div class="cols">
          <p><strong>Virtual hosts at <?php echo strtolower(php_uname('n')); ?></strong></p>
          <?php
          if (!is_null(StartPage::hosts()) {
            foreach (StartPage::hosts() as $val) {
                echo "<a href='http://".$val[2]."'>http://".$val[2]."</a>";
                echo "<br />";
            }
          }
          ?>
      </div>
      <div class="cols">
       <div class="left">
       <p><strong><strong>Documentation</strong></strong></p>
        <ul>
            <li><a href="http://php.net/manual/en/">
            phpmanual</a></li>
            <li><a href="http://framework.zend.com/manual/en/">
            Zend Framework</a></li>
            <li><a href="http://www.symfony-project.com/content/documentation.html">
            symfony Documentation</a></li>
            <li><a href="http://smarty.php.net/manual/en/">
            Smarty - the compiling PHP template engine</a></li>
            <li><a href="http://dev.mysql.com/doc/refman/5.0/en/index.html">
            MySQL 5.0 Reference Manual</a></li>
            <li><a href="http://dev.mysql.com/doc/refman/4.1/en/index.html">
            MySQL 3.23, 4.0, 4.1 Reference Manual</a></li>
            <li><a href="http://www.oracle.com/technology/documentation/index.html">
            Oracle Documentation</a></li>
            <li><a href="http://www.patternsforphp.com/wiki/Patterns_For_PHP:Index">
            Patterns For PHP</a></li>
            <li><a href="http://en.wikipedia.org/wiki/Design_pattern_(computer_science)">
            Design Pattern (Computer Science)</a></li>
        </ul>

        </div>
        <div class="right">
          <p><strong>Cheat sheets</strong></p>
        <ul>
          <li><a href="/_start/sheets/php_cheat_sheet.png">PHP</a></li>
          <li><a href="/_start/sheets/mysql_cheat_sheet.png">MySQL</a></li>
          <li><a href="/_start/sheets/javascript_cheat_sheet.png">JavaScript</a></li>
          <li><a href="/_start/sheets/characters_cheat_sheet.png">HTML Entities</a></li>
          <li><a href="/_start/sheets/css_cheat_sheet.png">CSS</a></li>
          <li><a href="/_start/sheets/mod_rewrite_cheat_sheet.png">Apache mod_rewrite</a></li>
          <li><a href="/_start/sheets/colourchart.png">RGB HEX</a></li>
          <li><a href="/_start/sheets/asp_cheat_sheet.png">ASP / VBScript</a></li>
        </ul>
        </div>
        <div style="clear:both;"></div>
      </div>
       <div class="cols">
       <div class="left">
      <p><strong>PHP configuration</strong></p>
        <ul>
            <li>Register globals: <strong>
            <?php  echo StartPage::infoIni('register_globals'); ?>
            </strong></li>
            <li>Display errors: <strong>
            <?php  echo StartPage::infoIni('display_errors'); ?>
            </strong></li>
            <li>Log errors: <strong>
            <?php  echo StartPage::infoIni('log_errors'); ?>
            </strong></li>
            <li>Magic Quotes gpc: <strong>
            <?php  echo StartPage::infoIni('magic_quotes_gpc'); ?>
            </strong> </li>
            <li>Safe mode: <strong> <?php  echo StartPage::infoIni('safe_mode'); ?></strong> </li>

            <li>Disable functions: <strong>
            <?php  echo ini_get('disable_functions'); ?></strong> </li>
            <li>Allow url open: <strong>
            <?php  echo StartPage::infoIni('allow_url_fopen'); ?></strong> </li>
            <li>Upload tmp dir: <strong>
            <?php  echo ini_get('upload_tmp_dir'); ?></strong> </li>
            <li>Session save path: <strong>
            <?php  echo ini_get('session.save_path'); ?></strong> </li>
            <li>Session auto start: <strong>
            <?php  echo StartPage::infoIni('session.auto_start'); ?></strong> </li>
            <li>Session use only cookies: <strong>
            <?php  echo StartPage::infoIni('session.use_only_cookies'); ?></strong> </li>
            <li>Session use cookies: <strong>
            <?php  echo StartPage::infoIni('session.use_cookies');  ?></strong> </li>
            <li>Error reporting: <strong>
            <?php  echo ini_get('error_reporting');?></strong> </li>
            <li>Var: post_max_size: <strong>
            <?php  echo ini_get('post_max_size');?></strong> </li>
            <li>Var: upload_max_filesize: <strong>
            <?php  echo ini_get('upload_max_filesize');?></strong> </li>
           </ul>
        </div>
        <div class="right">
        <p><strong>PHP configuration - extension</strong></p>
           <ul>
           <li>Filter: <?php echo StartPage::checkExt("filter"); ?></li>
           <li>Curl: <?php echo StartPage::checkExt("curl"); ?></li>
           <li>PDO: <?php echo StartPage::checkExt("PDO"); ?></li>
           <li>PDO-MYSQL: <?php echo StartPage::checkExt("pdo_mysql"); ?></li>
           <li>PDO-SQLITE: <?php echo StartPage::checkExt("pdo_sqlite"); ?></li>
           <li>PDO-OCI: <?php echo StartPage::checkExt("PDO_OCI"); ?></li>
           <li>PDO-PGSQL: <?php echo StartPage::checkExt("pdo_pgsql"); ?></li>
           <li>LDAP: <?php echo StartPage::checkExt("ldap"); ?></li>
           <li>GD: <?php echo StartPage::checkExt("gd"); ?></li>
           <li>MBSTRING: <?php echo StartPage::checkExt("mbstring"); ?></li>
           <li>EXIF: <?php echo StartPage::checkExt("exif"); ?></li>
           <li>MYSQL: <?php echo StartPage::checkExt("mysql"); ?></li>
           <li>PosgreSQL: <?php echo StartPage::checkExt("pgsql"); ?></li>
           <li>XSL: <?php echo StartPage::checkExt("xsl"); ?></li>
           <li>ICONV: <?php echo StartPage::checkExt("iconv"); ?></li>

           </ul>
            </div>
        <div style="clear:both;"></div>
  </div>
