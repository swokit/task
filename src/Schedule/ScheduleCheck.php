<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午8:13
 */

namespace SwooleLib\Task\Schedule;

// use Cron\CronExpression;

/**
 * Class ScheduleCheck
 * @package SwooleLib\Task
 */
class ScheduleCheck
{
    /**
     * @param string|callable|int $schedule
     * - int        A timestamp.  eg 1518162090
     * - callable   A callback. eg function($date) { return bool;}
     * - string
     *   - A date string. eg '2018-02-12 23:45:90'
     *   - A cron expression. eg. '0/5 * * * * *'
     * @return bool
     */
    public static function isDue($schedule): bool
    {
        $curDate = date('Y-m-d H:i:s');

        if (\is_callable($schedule)) {
            return $schedule($curDate);
        }

        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $schedule);

        if ($dateTime !== false) {
            return $dateTime->format('Y-m-d H:i:s') === $curDate;
        }

        return CronExpression::factory((string)$schedule)->isDue();
    }
}
