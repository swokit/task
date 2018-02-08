<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午8:06
 */

namespace SwooleLib\Task\CronTab;

use Swoole\Timer;
use SwooleLib\Task\AbstractManager;
use SwooleLib\Task\TaskHelper;

/**
 * Class ScheduleManager
 * @package SwooleLib\Task\Schedule
 *
 * @ref https://github.com/jobbyphp/jobby/blob/master/src/Jobby.php
 */
class ScheduleManager extends AbstractManager
{
    /**
     * @var int
     */
    private $timerId = -1;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function __destruct()
    {
        if ($this->timerId > -1) {
            Timer::clear($this->timerId);
            $this->timerId = -1;
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
        while (true) {
            pcntl_signal_dispatch();

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
