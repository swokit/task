<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:31
 */

namespace Swokit\Task\Schedule;

use Swokit\Task\BaseTask;
use Swokit\Task\TaskHelper;

/**
 * Class ScheduleTask
 * @package Swokit\Task\Schedule
 */
class ScheduleTask extends BaseTask implements ScheduleTaskInterface
{
    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * schedule expression
     *
     * format:
     *  '0 * * * *'
     * or
     *  '2017-05-03 17:15:00'
     * or
     * ```php
     * function() {
     *   // Run on even minutes
     *   return date('i') % 2 === 0;
     * }
     * ```
     * @var string|\Closure
     */
    private $schedule;

    /**
     * string:
     * 'ls'
     * callback:
     *  function() { echo "I'm a function!\n"; return true; }
     * @var mixed
     */
    private $command;

    /**
     * @var array
     */
    protected $options = [
        'jobClass' => 'Jobby\BackgroundJob',
        'recipients' => null,
        'mailer' => 'sendmail',
        'maxRuntime' => null,
        'smtpHost' => null,
        'smtpPort' => 25,
        'smtpUsername' => null,
        'smtpPassword' => null,
        'smtpSender' => '',
        'smtpSenderName' => 'jobby',
        'smtpSecurity' => null,
        'runUser' => null, // www
        'environment' => 'pdt',
        'runOnHost' => 'localhost',
        'output' => null,
        'dateFormat' => 'Y-m-d H:i:s',
        'enabled' => true,
        'haltDir' => null,
        'debug' => false,
    ];

    /**
     * @param \Closure|string $schedule
     * @return ScheduleTask
     */
    public function setSchedule($schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * @return \Closure|string
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return ScheduleTask
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @param mixed $command
     * @return ScheduleTask
     */
    public function setCommand($command): self
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @throws \RuntimeException
     */
    protected function runFile()
    {
        // Start execution. Run in foreground (will block).
        $user = $this->options['runUser'];
        $command = $this->options['command'];

        TaskHelper::exec($command, $this->getLogfile(), $user);
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    protected function getLogfile(): string
    {
        if (!$logfile = $this->options['output']) {
            return false;
        }

        $logs = \dirname($logfile);

        if (!file_exists($logs)) {
            TaskHelper::mkdir($logs, 0755);
        }

        return $logfile;
    }

    /**
     * @param array $args
     * @return mixed
     */
    protected function exec(array $args)
    {
        // TODO: Implement exec() method.
    }
}
