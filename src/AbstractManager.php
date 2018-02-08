<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午2:04
 */

namespace SwooleLib\Task;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

/**
 * Class AbstractManager
 * @package SwooleLib\Task
 */
abstract class AbstractManager implements ManagerInterface
{
    use LoggerAwareTrait;

    protected static $taskInterface = TaskInterface::class;

    /**
     * @var array
     */
    protected $tasks = [];

    /**
     * class constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if ($config) {
            TaskHelper::initObject($this, $config);
        }

        $this->init();
    }

    protected function init()
    {
        if (!$this->logger) {
            $this->setLogger(new NullLogger());
        }
    }

    /**
     * @param TaskInterface|mixed $definition
     * @throws \InvalidArgumentException
     */
    public function addTask($definition)
    {
        if (\is_object($definition)) {
            if (!$definition instanceof static::$taskInterface) {
                $definition = new CallbackTask($definition);
            }

            $this->tasks[$definition->getName()] = $definition;
            return;
        }

        if (\is_string($definition)) {
            if (\class_exists($definition)) {
                $task = new $definition;

                if ($task instanceof static::$taskInterface) {
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

        if ($task instanceof static::$taskInterface) {
            $this->tasks[$task->getName()] = $task;
        }
    }

    /**
     * @param array $tasks
     * @return AbstractManager
     */
    public function setTasks(array $tasks): AbstractManager
    {
        foreach ($tasks as $task) {
            $this->addTask($task);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }
}