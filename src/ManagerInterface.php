<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:20
 */

namespace SwoKit\Task;

use Psr\Log\LoggerAwareInterface;

/**
 * Interface ManagerInterface
 * @package SwoKit\Task
 */
interface ManagerInterface extends LoggerAwareInterface
{
    public function start();
}
