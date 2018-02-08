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
     * @var callable|mixed
     */
    private $callback;

    /**
     * CallbackWrokTask constructor.
     * @param mixed $callback
     * @throws \InvalidArgumentException
     */
    public function __construct($callback)
    {
        $this->callback = $callback;

        if (\is_string($callback)) {
            $name = md5($callback);
        } elseif (\is_object($callback)) {
            $name = spl_object_hash($callback);
        } elseif (\is_array($callback)) {
            $name = md5(\json_encode($callback));
        } else {
            throw new \InvalidArgumentException('Invalid param for create work');
        }

        parent::__construct(['name' => $name]);
    }

    /**
     * @param array $args
     * @return mixed
     */
    public function exec(array $args)
    {
        return TaskHelper::call($this->callback, ...$args);
    }
}