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
        TaskHelper::initObject($this, $config);

        $this->init();
    }

    protected function init()
    {
        if (!$this->logger) {
            $this->setLogger(new NullLogger());
        }
    }

    abstract public function addTask($definition);

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