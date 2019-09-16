<!DOCTYPE html>
<html>
<head>
    <title><?= $this->title ?></title>
    <?= $this->cssStyle ?>
</head>
<body>
<div class="container">
    <div class="header-title"><a href="/">西德尼易的博客</a></div>
</div>
<div class="container">
    <?= $this->content ?>
</div>
<?= $this->jsScript ?>
</body>
</html>