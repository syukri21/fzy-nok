<?php if ($this->isOpen()): ?>
<div class="alert alert-<?= esc($type, 'attr') ?>">
    <?= $this->getMessage() ?>
</div>
<?php endif ?>