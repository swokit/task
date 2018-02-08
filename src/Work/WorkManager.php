<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午5:56
 */

namespace SwooleLib\Task\Work;

use SwooleLib\Task\AbstractManager;

/**
 * Class WorkManager
 * @package SwooleLib\Task\Work
 */
class WorkManager extends AbstractManager
{
    protected static $taskInterface = WorkTaskInterface::class;

    /**
     * @var CallbackWork
     */
    protected $basicTask;

    protected function init()
    {
        parent::init();

        $this->basicTask = new CallbackWork();
    }

    /**
     * @param WorkTaskInterface|mixed $definition
     * @throws \InvalidArgumentException
     */
    public function addTask($definition)
    {
        if (\is_object($definition)) {
            if ($definition instanceof WorkTaskInterface) {
                $this->tasks[$definition->getName()] = $definition;
            } elseif (\is_callable($definition)) {
                $task = clone $this->basicTask;
                $task->setCallback($definition);

                $this->tasks[$task->getName()] = $task;
            }

            return;
        }

        if (\is_string($definition)) {
            if (\class_exists($definition)) {
                $obj = new $definition;

                if ($obj instanceof WorkTaskInterface) {
                    $this->tasks[$obj->getName()] = $obj;

                } elseif (\is_callable($obj)) {
                    $task = clone $this->basicTask;
                    $task->setName($definition);
                    $task->setCallback($obj);
                    $this->tasks[$task->getName()] = $task;
                }
            } else {
                $task = new CallbackTask($definition);
            }

            return;
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


    public function start()
    {
        // TODO: Implement start() method.
    }
}
