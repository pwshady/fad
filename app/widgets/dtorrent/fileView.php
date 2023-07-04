<div class="header-content"><span class="heading"><?= $labels['file_list_info'] ?></span></div>
<div class="fill-table">
    <div id="files-box">
        <?php if (count($this->files) > 0): ?>
            <?php foreach($this->files as $key=>$value): ?>
                <div class="f-txt"><?= $value[$this->configs['files']['name']] . '(' . $value[$this->configs['files']['size']] . ')' ?></div><div class="d"></div>
            <?php endforeach; ?>
        <?php else: ?>
            <?= $labels['no_file_list_info'] ?>
        <?php endif; ?>
    </div>
</div>
<div class="end"></div>