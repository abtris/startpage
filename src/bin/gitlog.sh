# http://www.kernel.org/pub/software/scm/git/docs/git-whatchanged.html
cd $1;
git pull
echo '<?xml version="1.0"?>\n<log>' >$1.xml
git log --pretty=format:' 
<logentry revision="%h">
<author>%an</author>
<date>%ai</date>
<msg><![CDATA[%s%n%b]]></msg>
</logentry>' >>$1.xml
echo '</log>' >>$1.xml
