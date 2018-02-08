<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 22:37
 */

namespace SwooleLib\Task;

/**
 * Trait CallbackWrapperTaskTrait
 * @package SwooleLib\Task
 */
trait CallbackWrapperTaskTrait
{
    /**
     * @var callable|mixed
     */
    private $callback;

    /**
     * @param callable|mixed $callback
     * @return CallbackWrapperTaskTrait
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @param array $args
     * @return mixed
     */
    protected function exec(array $args)
    {
        return TaskHelper::call($this->callback, ...$args);
    }
}
