<?ph
/**
 * @package startpage
 * @author Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright Copyright (c) 2007-2008
 * @version $Id: 404.php,v 58aa8855a2ab 2009/03/09 08:25:16 ladislav $
 * @filesource
 */
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="content-language" content="en" />
	<meta name="author" content="Prometheus Design, 2004; mailto:webmaster[at]prskavec.net" />
	<meta name="copyright" content="Ladislav Prskavec [abtris] - xhtml,css and php" />
	<title>HTTP 404 [Page not found | Stránka nenalezena]</title>
	<style type="text/css">
         html, body   {
                        background:black;
                        color: white;
                        font:10pt/1.5 "verdana ce", verdana, "helvetica ce", helvetica, "arial ce", arial, sans-serif;
                        margin: 0px auto; padding: 10px;
                      }
         a:link,a:visited { color:red; }

         h2 { color:red; }
         hr { width:80%;
              text-align: left;
              margin-left: 0;
              background-color: white;
              height: 3px;
         }
         acronym:hover { cursor:pointer; }
  </style>

</head>
<body>

<h1>HTTP 404 [Page not found | Stránka nenalezena]</h1>
<?php
 if ($_SERVER["SERVER_PROTOCOL"]==HTTP/1.1) $protokol="http://";
?>
<h2><acronym title='Uniform Resource Locator - The address of a file or page accessible on the Internet'>URL</acronym>:
<?php echo $protokol.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?></h2>
<hr />
<p>
Sorry, but the page <em><?php echo $protokol.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?></em>
doesn't exist on this server.
The link you have followed may be broken or out of date.</p>

<h3>Maybe can help following:</h3>
  <ul>
    <li>please check the URL to ensure that the path is correct.</li>
    <li>go to web <a href='/' title='go to homepage'>homepage</a></li>
    <li>finally, send me e-mail <a href='mailto:webmaster@prskavec.net'>webmaster@prskavec.net</a></li>
  </ul>

<hr />
<p>Je mi líto, požadovaná stránka <em><?php echo $protokol.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?></em>
se bohužel na serveru nenachází. Patrně byla odstraněna, přemístěna nebo přejmenována.</p>

<h3>Pomoci vám může následující:</h3>
  <ul>
    <li>pokud jste zapsali adresu do prohlížeče ručně, zkontrolujte zadanou URL.</li>
    <li>přejděte na úvodní <a href='/' title='Přejít na homepage'>stránku webu</a> a dál pokračujte odtud</li>
    <li>pokud nic nepomůe napište mi na mail <a href='mailto:webmaster@prskavec.net'>webmaster@prskavec.net</a></li>
  </ul>

</body>
</html>
