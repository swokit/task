<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:20
 */

namespace SwooleLib\Task\Timer;

use SwooleLib\Task\TaskInterface;

/**
 * Interface TimerTaskInterface
 * @package SwooleLib\Task\Timer
 */
interface TimerTaskInterface extends TaskInterface
{
    const FOREVER = -1;

    /**
     * @return int
     */
    public function getTimes(): int;
}
