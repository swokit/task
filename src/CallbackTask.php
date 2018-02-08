<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午3:42
 */

namespace SwooleLib\Task;

/**
 * Class CallbackTask
 * @package SwooleLib\Task
 */
class CallbackTask extends BaseTask
{
    /**
     * @param array $args
     * @return mixed
     */
    protected function exec(array $args)
    {
        return TaskHelper::call($this->handler, ...$args);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function genName(): string
    {
        $callback = $this->handler;

        if (\is_string($callback)) {
            $name = $callback;
        } elseif (\is_object($callback)) {
            $name = spl_object_hash($callback);
        } elseif (\is_array($callback)) {
            $name = implode(':', $callback);
        } else {
            throw new \InvalidArgumentException('Invalid param for create callback task');
        }

        return $name;
    }

}
