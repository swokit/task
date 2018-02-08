<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:18
 */

namespace SwooleLib\Task\Timer;

use SwooleLib\Task\BaseTask;

/**
 * Class TimerTask
 * @package SwooleLib\Task\Timer
 */
abstract class TimerTask extends BaseTask implements TimerTaskInterface
{
    /**
     * @var int The timer id
     */
    protected $id = -1;

    /**
     * @var int
     */
    protected $times = self::FOREVER;

    /**
     * @var int The timer interval time.(unit: ms)
     */
    protected $interval = 1000;

    /**
     * @return $this
     */
    public function forever(): TimerTask
    {
        $this->times = self::FOREVER;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimes(): int
    {
        return $this->times;
    }

    /**
     * @param int $times
     */
    public function setTimes(int $times)
    {
        $this->times = $times;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     */
    public function setInterval(int $interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
