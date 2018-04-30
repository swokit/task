<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:20
 */

namespace SwooleKit\Task\Schedule;

use SwooleKit\Task\Traits\CallbackWrapperTaskTrait;

/**
 * Class CallbackScheduleTask
 * @package SwooleKit\Task\Schedule
 */
class CallbackScheduleTask extends ScheduleTask
{
    use CallbackWrapperTaskTrait;
}
