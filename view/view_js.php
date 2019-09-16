<h1><?= $this->title ?></h1>
<div class="text-right">
    <span>创建时间 <?= $this->created_time ?></span>
</div>
<div id="content"></div>
<script src="/js/jquery.js"></script>
<script src="/js/Parser.js"></script>
<script>
    var parser = new HyperDown,
        markdownText = <?=$this->content?>;
    html = parser.makeHtml(markdownText);
    $('#content').html(html);
</script>