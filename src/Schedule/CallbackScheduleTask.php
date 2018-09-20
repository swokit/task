<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:20
 */

namespace SwoKit\Task\Schedule;

use SwoKit\Task\Traits\CallbackWrapperTaskTrait;

/**
 * Class CallbackScheduleTask
 * @package SwoKit\Task\Schedule
 */
class CallbackScheduleTask extends ScheduleTask
{
    use CallbackWrapperTaskTrait;
}
