<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:20
 */

namespace SwoKit\Task\Timer;

use SwoKit\Task\TaskInterface;

/**
 * Interface TimerTaskInterface
 * @package SwoKit\Task\Timer
 */
interface TimerTaskInterface extends TaskInterface
{
    const FOREVER = -1;

    /**
     * @return int
     */
    public function getTimes(): int;
}
