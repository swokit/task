<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午5:26
 */

require dirname(__DIR__) . '/test/boot.php';

$q = new \SwooleLib\Task\Work\WorkQueue();

$q->add(function () {
    echo 'he';
});

$q->add(function () {
    echo 'llo';
});

$q->run();