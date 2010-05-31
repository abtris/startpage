# http://hgbook.red-bean.com/read/customizing-the-output-of-mercurial.html
echo '<?xml version="1.0"?>\n<log>\n' >$1.xml
hg log --template '<logentry revision="{rev}">
<author>{author|obfuscate}</author>
<date>{date|isodate}</date>
<msg>{desc|escape}\n</msg>
<paths><path>{files}</path></paths>
</logentry>\n' $1/ >>$1.xml
echo '</log>\n' >>$1.xml
