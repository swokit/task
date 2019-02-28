<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 22:37
 */

namespace Swokit\Task\Traits;

use Toolkit\PhpUtil\PhpHelper;

/**
 * Trait CallbackWrapperTaskTrait
 * @package Swokit\Task\Traits
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
    public function setCallback($callback): CallbackWrapperTaskTrait
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
        return PhpHelper::call($this->callback, ...$args);
    }
}
