<script type="text/javascript">
    $(document).ready(function(){
        var viewportwidth;
        var viewportheight;

        // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight

        if (typeof window.innerWidth != 'undefined')
        {
            viewportwidth = window.innerWidth,
            viewportheight = window.innerHeight
        }

        // IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)

        else if (typeof document.documentElement != 'undefined'
            && typeof document.documentElement.clientWidth !=
            'undefined' && document.documentElement.clientWidth != 0)
        {
            viewportwidth = document.documentElement.clientWidth,
            viewportheight = document.documentElement.clientHeight
        }

        // older versions of IE

        else
        {
            viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
            viewportheight = document.getElementsByTagName('body')[0].clientHeight
        }
        $('.auto-height').css('height', viewportheight-150);
    });

</script>

<div id="main-content">
    <br/>
    <iframe src="http://www.danareksa-research.com/stock/app/ChartTechnicalA.php" width="100%" class="auto-height" frameborder=0></iframe>
</div>
</div>
</body>
</html>