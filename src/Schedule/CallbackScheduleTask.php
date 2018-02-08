<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:20
 */

namespace SwooleLib\Task\Schedule;

use SwooleLib\Task\CallbackWrapperTaskTrait;

/**
 * Class CallbackScheduleTask
 * @package SwooleLib\Task\Schedule
 */
class CallbackScheduleTask extends ScheduleTask
{
    use CallbackWrapperTaskTrait;
}
