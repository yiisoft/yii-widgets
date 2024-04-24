<?php

declare(strict_types=1);

/* @var $this Yiisoft\View\WebView */
/* @var $content string */
?>
<?php $this->beginPage(); ?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Test</title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<?= $content ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>