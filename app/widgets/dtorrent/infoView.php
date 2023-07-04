<div class="header-content"><span class="heading"><?= $labels['torrent_list_info'] ?></span></div>
<div class="fill-table">
    <div id="files-box">
        <?= !empty($this->info) ? $this->info : $labels['no_torrent_list_info'] ?>
    </div>
</div>
<div class="end"></div>