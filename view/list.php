<div>
    <?php foreach ($this->list as $item): ?>
        <a href="<?= $item['url'] ?>">
            <div class="clearfix p-1">
                <span class="d-inline-block float-left"><?= $item['title'] ?></span>
                <span class="d-inline-block float-right"><?= $item['created_time'] ?></span>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?php if ($this->tags): ?>
    <div class="pt-4">
        <div class="pb-2">分类</div>
        <?php foreach ($this->tags as $tag): ?>
            <div class="d-inline-block">
                <a href="<?= $tag['url'] ?>"><span><?= $tag['name'] ?></span></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>