<div class="dropdown d-inline-block">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="<?= $public ?>/src/<?= $tec_language['code'] ?>.png" alt="<?= $tec_language['name'] ?>">
    </a>
    <ul class="dropdown-menu" id="lang">
        <?php foreach( $this->languages as $key => $value ):?>
        <?php if ( $tec_language == $key ) continue ?>
        <li>
            <form method="POST">
                <button class="dropdown-item" type="submit" name="<?=$this->prefix_kebab?>code" value="<?= $key ?>">
                    <img src="<?= $public ?>/src/<?= $key ?>.png" alt="<?= $value['name'] ?>">
                    <?= $value['name'] ?>
                </button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
</div>