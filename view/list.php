<div>
    <?php foreach ($this->list as $item):?>
        <ul>
            <li><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></li>
        </ul>
    <?php endforeach;?>
</div>