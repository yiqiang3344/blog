<div>
    <?php foreach ($this->list as $item): ?>
        <ul>
            <li><a href="<?= $item['url'] ?>"><?= $item['title'] ?>(<span><?= $item['created_time'] ?></span>)</a></li>
        </ul>
    <?php endforeach; ?>
</div>