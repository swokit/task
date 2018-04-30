<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:18
 */

namespace SwooleKit\Task\Example;

use SwooleKit\Task\Timer\TimerTask;

/**
 * Class DemoTimerTask
 * @package SwooleKit\Task\Timer\Example
 */
class DemoTimerTask extends TimerTask
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'demo-timer';
    }

    protected function exec(array $args)
    {
        echo __METHOD__ . PHP_EOL;
    }
}
