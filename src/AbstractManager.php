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
     * @param string $namespace
     * @param string $dirPath
     * @throws \InvalidArgumentException
     */
    public function loadFromNamespace(string $namespace, string $dirPath)
    {
        $length = \strlen($dirPath) + 1;

        foreach (glob("$dirPath/*.php") as $file) {
            $class = $namespace . '\\' . \substr($file, $length, -4);
            $this->addTask(new $class);
        }
    }

    /**
     * @param TaskInterface|mixed $definition
     */
    abstract public function addTask($definition);

    /**
     * @param mixed $callback
     * @return string
     * @throws \InvalidArgumentException
     */
    public function generateName($callback): string
    {
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
