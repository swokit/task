<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:20
 */

namespace Swokit\Task\Schedule;

use Swokit\Task\Traits\CallbackWrapperTaskTrait;

/**
 * Class CallbackScheduleTask
 * @package Swokit\Task\Schedule
 */
class CallbackScheduleTask extends ScheduleTask
{
    use CallbackWrapperTaskTrait;
}
