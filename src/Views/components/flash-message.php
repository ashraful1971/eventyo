<?php if ($msg = flash_message('success')) : ?>
    <div class="p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
        <strong>Success!</strong> <?php __($msg) ?>
    </div>
<?php endif ?>
<?php if ($msg = flash_message('error')) : ?>
    <div class="p-4 my-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
        <strong>Error!</strong> <?php __($msg) ?>
    </div>
<?php endif ?>
<?php if ($msg = flash_message('warning')) : ?>
    <div class="p-4 my-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 border border-yellow-200" role="alert">
        <strong>Warning!</strong> <?php __($msg) ?>
    </div>
<?php endif ?>