<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:18
 */

namespace SwooleLib\Task;

/**
 * Class TimerTask
 * @package SwooleLib\Task
 */
abstract class TimerTask implements TaskInterface
{
    /**
     * @param array $args
     */
    public function beforeRun(array $args)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function run(array $args)
    {
        $this->beforeRun($args);
        $this->doRun($args);
        $this->afterRun($args);
    }

    /**
     * @param array $args
     * @return mixed
     */
    abstract public function doRun(array $args);

    /**
     * @param array $args
     */
    public function afterRun(array $args)
    {
    }
}
