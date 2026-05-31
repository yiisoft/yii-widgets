<?php

declare(strict_types=1);

/* @var $this Yiisoft\View\ViewInterface */
/* @var $content string */

$title = $this->hasParameter('title') ? $this->getParameter('title') : '';
?>
<main><?= $title ?><?= $content ?></main>
