<div>
    <?php foreach ( $this->last_request as $request): ?>
        <form method="post">
            <input type="text" name="<?=$this->prefix_kebab?>search" value="<?=$request['request']?>" class="form-control">
            <input type="text" name="<?=$this->prefix_kebab?>last" value="<?=$request['id']?>" class="form-control">
            <button type="submit" name="<?=$this->prefix_kebab?>add" value="0" class="btn btn-primary btn-block"><?=$request['request']?></button>
        </form>
    <?php endforeach; ?>
</div>