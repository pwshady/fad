<div class="<?=$this->prefix_kebab?>result-sort-div">
    <div class="col-sm-6">
        <div class="input-group mb-3">
            <label class="input-group-text" for="input-pad">pag</label>
            <select class="form-select" id="input-pag">
                <option value="p1">1</option>
                <option>2</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="input-group mb-3">
            <label class="input-group-text" for="input-sort">sort</label>
            <select class="form-select" id="input-sort">
                <option>1</option>
                <option>2</option>
            </select>
            <select class="form-select" id="input-sort">
                <option>1</option>
                <option>2</option>
            </select>
        </div>
    </div>
</div>
<?php foreach ( $this->result as $result): ?>
        <form method="post">
            <input type="text" name="<?=$this->prefix_kebab?>add" value="0" class="form-control">
            <input type="text" name="<?=$this->prefix_kebab?>name" value="<?=$result['name']?>" class="form-control">
            <button type="submit" name="<?=$this->prefix_kebab?>hash" value="<?=$result['hash']?>" class="btn btn-primary btn-block">details</button>
        </form>
<?php endforeach; ?>