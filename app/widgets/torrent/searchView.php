<div class="<?=$this->prefix_kebab?>search-div">
  <form method="post">
    <table class="<?=$this->prefix_kebab?>search-cat-table">
      <tr class="<?=$this->prefix_kebab?>search-cat-table-tr">
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-5']?><input name="<?=$this->prefix_kebab?>cat-5" type="checkbox"
        <?php echo $this->cat['cat-5'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-28']?><input name="<?=$this->prefix_kebab?>cat-28" type="checkbox"
        <?php echo $this->cat['cat-28'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-18']?><input name="<?=$this->prefix_kebab?>cat-18" type="checkbox"
        <?php echo $this->cat['cat-18'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-51']?><input name="<?=$this->prefix_kebab?>cat-51" type="checkbox"
        <?php echo $this->cat['cat-51'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-75']?><input name="<?=$this->prefix_kebab?>cat-75" type="checkbox"
        <?php echo $this->cat['cat-75'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-10']?><input name="<?=$this->prefix_kebab?>cat-10" type="checkbox"
        <?php echo $this->cat['cat-10'] ? 'checked' : '';?>/></td>
      </tr>
      <tr class="<?=$this->prefix_kebab?>search-cat-table-tr">
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-55']?><input name="<?=$this->prefix_kebab?>cat-55" type="checkbox"
        <?php echo $this->cat['cat-55'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-52']?><input name="<?=$this->prefix_kebab?>cat-52" type="checkbox"
        <?php echo $this->cat['cat-52'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-1']?><input name="<?=$this->prefix_kebab?>cat-1" type="checkbox"
        <?php echo $this->cat['cat-1'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-22']?><input name="<?=$this->prefix_kebab?>cat-22" type="checkbox"
        <?php echo $this->cat['cat-22'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-33']?><input name="<?=$this->prefix_kebab?>cat-33" type="checkbox"
        <?php echo $this->cat['cat-33'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-72']?><input name="<?=$this->prefix_kebab?>cat-72" type="checkbox"
        <?php echo $this->cat['cat-72'] ? 'checked' : '';?>/></td>
      </tr>
      <tr class="<?=$this->prefix_kebab?>search-cat-table-tr">
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-70']?><input name="<?=$this->prefix_kebab?>cat-70" type="checkbox"
        <?php echo $this->cat['cat-70'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-76']?><input name="<?=$this->prefix_kebab?>cat-76" type="checkbox"
        <?php echo $this->cat['cat-76'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-74']?><input name="<?=$this->prefix_kebab?>cat-74" type="checkbox"
        <?php echo $this->cat['cat-74'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-41']?><input name="<?=$this->prefix_kebab?>cat-41" type="checkbox"
        <?php echo $this->cat['cat-41'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-71']?><input name="<?=$this->prefix_kebab?>cat-71" type="checkbox"
        <?php echo $this->cat['cat-71'] ? 'checked' : '';?>/></td>
        <td class="<?=$this->prefix_kebab?>search-cat-table-tr"><?=$labels['cat-54']?><input name="<?=$this->prefix_kebab?>cat-54" type="checkbox"
        <?php echo $this->cat['cat-54'] ? 'checked' : '';?>/></td>
      </tr>
    </table>
    <div class="<?=$this->prefix_kebab?>search-search-div">
      <div class="col-sm-8">
        <input type="text" name="<?=$this->prefix_kebab?>search" value="<?php echo $_SESSION[$this->prefix_kebab . 'search'] ?? '';?>" class="form-control" placeholder="<?=$labels['searchph']?>">
      </div>
      <div class="col-sm-4">
        <button type="submit" name="<?=$this->prefix_kebab?>add" value="1" class="btn btn-primary btn-block"><?=$labels['search']?></button>
      </div>
    </div>
  </form>
</div>