<div id="content"></div>
<script src="/js/jquery.js"></script>
<script src="/js/Parser.js"></script>
<script>
    var parser = new HyperDown,
        markdownText = <?=$this->content?>;
    html = parser.makeHtml(markdownText);
    $('#content').html(html);
</script>