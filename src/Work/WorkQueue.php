<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午5:25
 */

namespace Swokit\Task\Work;

use Swokit\Task\AbstractManager;

/**
 * Class WorkQueue
 * @package Swokit\Task\Work
 * @from GuzzleHttp\Promise\TaskQueue
 */
class WorkQueue extends AbstractManager
{
    protected static $taskInterface = WorkTaskInterface::class;

    /**
     * @var bool
     */
    private $enableShutdown = true;

    /**
     * WorkQueue constructor.
     * @param bool $withShutdown
     */
    public function __construct($withShutdown = true)
    {
        parent::__construct();

        if ($withShutdown) {
            register_shutdown_function(function () {
                if ($this->enableShutdown) {
                    // Only run the tasks if an E_ERROR didn't occur.
                    $err = error_get_last();
                    if (!$err || ($err['type'] ^ E_ERROR)) {
                        $this->run();
                    }
                }
            });
        }
    }

    public function isEmpty(): bool
    {
        return !$this->tasks;
    }

    /**
     * @param callable|mixed $task
     * @throws \InvalidArgumentException
     */
    public function add($task): void
    {
        $this->addTask($task);
    }

    public function start(): void
    {
        $this->run();
    }

    public function run(): void
    {
        /** @var WorkTask $task */
        while ($task = array_shift($this->tasks)) {
            $task->run();
        }
    }

    /**
     * The task queue will be run and exhausted by default when the process
     * exits IFF the exit is not the result of a PHP E_ERROR error.
     *
     * You can disable running the automatic shutdown of the queue by calling
     * this function. If you disable the task queue shutdown process, then you
     * MUST either run the task queue (as a result of running your event loop
     * or manually using the run() method) or wait on each outstanding promise.
     *
     * Note: This shutdown will occur before any destructors are triggered.
     */
    public function disableShutdown(): void
    {
        $this->enableShutdown = false;
    }

}
