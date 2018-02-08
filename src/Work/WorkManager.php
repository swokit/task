<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午2:40
 */

namespace SwooleLib\Task\Work;

use SwooleLib\Task\AbstractManager;
use SwooleLib\Task\CallbackTask;

/**
 * Class WorkManager
 * @package SwooleLib\Task\Work
 */
class WorkManager extends AbstractManager
{
    public function start()
    {
        // TODO: Implement start() method.
    }

    public function wait()
    {

    }

    /**
     * @param $definition
     * @throws \InvalidArgumentException
     */
    public function addTask($definition)
    {
        if (\is_object($definition)) {
            if (!$definition instanceof WorkTaskInterface) {
                $definition = new CallbackTask($definition);
            }

            $this->tasks[$definition->getName()] = $definition;
            return;
        }

        if (\is_string($definition)) {
            if (\class_exists($definition)) {
                $task = new $definition;

                if ($task instanceof WorkTaskInterface) {
                    $this->tasks[$task->getName()] = $task;

                    return;
                }

                $task = new CallbackTask($task);
            } else {
                $task = new CallbackTask($definition);
            }

        } elseif (\is_array($definition) && ($class = $definition['class'] ?? null)) {
            $task = new $class($definition);
        } elseif (\is_callable($definition)) {
            $task = new CallbackTask($definition);
        } else {
            return;
        }

        if ($task instanceof WorkTaskInterface) {
            $this->tasks[$task->getName()] = $task;
        }
    }
}