<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午8:06
 */

namespace SwooleKit\Task\Schedule;

use Swoole\Timer;
use SwooleKit\Task\AbstractManager;
use SwooleKit\Task\TaskHelper;

/**
 * Class ScheduleManager
 * @package SwooleKit\Task\Schedule
 *
 * @ref https://github.com/jobbyphp/jobby/blob/master/src/Jobby.php
 */
class ScheduleManager extends AbstractManager
{
    /**
     * @var int
     */
    private $timerId = -1;

    /**
     * @var CallbackScheduleTask
     */
    protected $basicTask;

    protected function init()
    {
        parent::init();

        $this->basicTask = new CallbackScheduleTask();
    }

    public function __destruct()
    {
        if ($this->timerId > -1) {
            Timer::clear($this->timerId);
            $this->timerId = -1;
        }
    }

    /**
     * @param ScheduleTaskInterface|mixed $definition
     * @throws \InvalidArgumentException
     */
    public function addTask($definition)
    {
        $task = null;

        if (\is_object($definition) && $definition instanceof ScheduleTaskInterface) {
            $this->tasks[$definition->getName()] = $definition;
            return;
        }

        if (\is_string($definition) && \class_exists($definition)) {
            $obj = new $definition;

            if ($obj instanceof ScheduleTaskInterface) {
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

        if ($task && $task instanceof ScheduleTaskInterface) {
            $this->tasks[$task->getName()] = $task;
        }
    }

    public function start()
    {
        if (TaskHelper::hasSwoole()) {
            $this->startWithSwoole();
        } elseif (TaskHelper::hasPcntl()) {
            $this->startWithPcntl();
        } else {
            $this->startWithRaw();
        }
    }

    protected function startWithSwoole($wait = true)
    {
        // add a timer,
        $this->timerId = Timer::tick(1, function (){
            $this->dispatch();
        });

        if ($wait) {
            swoole_event_wait();
        }
    }

    public function startWithPcntl()
    {
        pcntl_signal(SIGALRM, $handler);


        while (true) {
            pcntl_signal_dispatch();

            $this->dispatch();
        }
    }

    public function startWithRaw()
    {
        while (true) {
            $this->dispatch();
        }
    }

    /**
     * dispatch schedule task
     */
    public function dispatch()
    {

    }

    /**
     * @return int
     */
    public function getTimerId(): int
    {
        return $this->timerId;
    }

    /**
     * @param string $job
     * @param array  $config
     */
    protected function runUnix($job, array $config)
    {
        $command = $this->getExecutableCommand($job, $config);
        $binary = $this->getPhpBinary();
        $output = $config['debug'] ? 'debug.log' : '/dev/null';

        exec("$binary $command 1> $output 2>&1 &");
    }

    /**
     * @param string $job
     * @param array  $config
     */
    protected function runWindows($job, array $config)
    {
        // Run in background (non-blocking). From
        // http://us3.php.net/manual/en/function.exec.php#43834
        $binary = $this->getPhpBinary();
        $command = $this->getExecutableCommand($job, $config);

        pclose(popen("start \"blah\" /B \"$binary\" $command", 'r'));
    }

    private function getPhpBinary()
    {
        return 'php';
    }

    private function getExecutableCommand($job, $config): string
    {
        return '';
    }
}
