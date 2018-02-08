<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:31
 */

namespace SwooleLib\Task\Schedule;

use Inhere\Library\Helpers\Sys;
use SwooleLib\Task\BaseTask;

/**
 * Class ScheduleTask
 * @package SwooleLib\Task\Schedule
 */
class ScheduleTask extends BaseTask implements ScheduleTaskInterface
{
    private $enabled = true;

    /**
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

    protected $options = [
        'jobClass'       => 'Jobby\BackgroundJob',
        'recipients'     => null,
        'mailer'         => 'sendmail',
        'maxRuntime'     => null,
        'smtpHost'       => null,
        'smtpPort'       => 25,
        'smtpUsername'   => null,
        'smtpPassword'   => null,
        'smtpSender'     => '',
        'smtpSenderName' => 'jobby',
        'smtpSecurity'   => null,
        'runUser'        => null, // www
        'environment'    => 'pdt',
        'runOnHost'      => 'localhost',
        'output'         => null,
        'dateFormat'     => 'Y-m-d H:i:s',
        'enabled'        => true,
        'haltDir'        => null,
        'debug'          => false,
    ];

    protected function runFile()
    {
        // Start execution. Run in foreground (will block).
        $user = $this->options['runUser'];
        $command = $this->options['command'];

        Sys::exec($command, $this->getLogfile(), $user);
    }

    /**
     * @return string
     */
    protected function getLogfile()
    {
        if (!$logfile = $this->options['output']) {
            return false;
        }

        $logs = \dirname($logfile);

        if (!file_exists($logs)) {
            mkdir($logs, 0755, true);
        }

        return $logfile;
    }

    /**
     * @param array $args
     * @return mixed
     */
    public function exec(array $args)
    {
        // TODO: Implement exec() method.
    }
}
