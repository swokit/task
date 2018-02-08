<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:20
 */

namespace SwooleLib\Task;

/**
 * Interface TaskInterface
 * @package SwooleLib\Task
 */
interface TaskInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param array $args
     * @return mixed
     */
    public function run(array $args = []);
}
