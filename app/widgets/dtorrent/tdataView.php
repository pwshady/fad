<div class="header-content"><span class="heading"><?= $labels['name'] ?><?= $this->tdata['name'] ?></span></div>
<div class="fill-content"><br>
<dl class="col1">
 <dt><?= $labels['download'] ?></dt>
  <dd><a href="<?= $this->tdata['magnet'] ?>"><?= $labels['link'] ?></a></dd>
 <dt><?= $labels['name'] ?></dt>
  <dd class="t1"><?= $labels[$this->tdata['cat']] ?></dd>
 <dt><?= $labels['total_files'] ?></dt>
  <dd><?= count($this->files) ?></dd>
 <dt><?= $labels['total_size'] ?></dt>
  <dd><?= $this->tdata['size'] ?></dd>
</dl>
<dl class="col2">
 <dt><?= $labels['found'] ?></dt>
  <dd><?= date("j, n, Y, G:i:s", $this->tdata['dtime']) ?></dd>
 <dt><?= $labels['seeders'] ?></dt>
  <dd class="s"><?= $this->tdata['seed'] ?></dd>
 <dt><?= $labels['leechers'] ?></dt>
  <dd class="l"><?= $this->tdata['leech'] ?></dd>
 <dt><?= $labels['hash'] ?></dt>
  <dd><?= $this->tdata['hash'] ?></dd>
</dl>
</div>
<div class="end"></div>