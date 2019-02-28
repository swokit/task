<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午5:56
 */

namespace Swokit\Task\Work;

use Swokit\Task\AbstractManager;

/**
 * Class WorkManager
 * @package Swokit\Task\Work
 */
class WorkManager extends AbstractManager
{
    /**
     * @var CallbackWork
     */
    protected $basicTask;

    protected function init(): void
    {
        parent::init();

        $this->basicTask = new CallbackWork();
    }

    /**
     * @param WorkTaskInterface|mixed $definition
     * @throws \InvalidArgumentException
     */
    public function addTask($definition): void
    {
        $task = null;

        if (\is_object($definition) && $definition instanceof WorkTaskInterface) {
            $this->tasks[$definition->getName()] = $definition;
            return;
        }

        if (\is_string($definition) && \class_exists($definition)) {
            $obj = new $definition;

            if ($obj instanceof WorkTaskInterface) {
                $this->tasks[$obj->getName()] = $obj;
                return;
            }

            // reset
            $definition = $obj;
        }

        if (\is_callable($definition)) {
            $task = clone $this->basicTask;
            $task->setName($definition);
            $task->setCallback($definition);
        } elseif (\is_array($definition)) {
            $task = clone $this->basicTask;
            $task->config($definition);
        }

        if ($task && $task instanceof WorkTaskInterface) {
            $this->tasks[$task->getName()] = $task;
        }
    }

    public function start(): void
    {
        // TODO: Implement start() method.
    }
}
