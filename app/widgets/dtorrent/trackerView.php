<div class="header-content"><span class="heading"><?= $labels['tracker_list_info'] ?></span></div>
<div class="fill-table">
    <div id="files-box">
        <?php if (count($this->trackers) > 0): ?>
            <?php foreach($this->trackers as $key=>$value): ?>
                <div class="f-txt"><?= $value[$this->configs['trackers']['trackers']]; ?></div><div class="d"></div>
            <?php endforeach; ?>
        <?php else: ?>
            <?= $labels['no_tracker_list_info'] ?>
        <?php endif; ?>
    </div>
</div>
<div class="end"></div>