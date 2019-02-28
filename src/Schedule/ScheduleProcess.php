<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午5:00
 */

namespace Swokit\Task\Schedule;

use Swoole\Process;

/**
 * Class ScheduleProcess
 * @package Swokit\Task\Schedule
 */
class ScheduleProcess
{
    /**
     * @var string
     */
    private $name = 'cron process';

    /**
     * @var int
     */
    private $pid = 0;

    /**
     * @var Process
     */
    private $process;

    /**
     * ScheduleProcess constructor.
     */
    public function __construct()
    {
        $this->process = new Process(function (Process $process) {
            $this->run($process);
        }, false, false);
    }

    public function start(): void
    {
        $this->pid = $this->process->start();
    }

    public function run(Process $process): void
    {

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }
}
