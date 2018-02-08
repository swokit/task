<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午1:09
 */

namespace SwooleLib\Task;

/**
 * Class TaskHelper
 * @package SwooleLib\Task
 */
final class TaskHelper
{
    /**
     * @param callable $cb
     * @param array ...$args
     * @return mixed
     */
    public static function call(callable $cb, ...$args)
    {
        if (\is_string($cb)) {
            // function
            if (strpos($cb, '::') === false) {
                return $cb(...$args);
            }

            // ClassName::method
            $cb = explode('::', $cb, 2);
        } elseif (\is_object($cb) && method_exists($cb, '__invoke')) {
            return $cb(...$args);
        }

        if (\is_array($cb)) {
            list($obj, $mhd) = $cb;

            return \is_object($obj) ? $obj->$mhd(...$args) : $obj::$mhd(...$args);
        }

        return $cb(...$args);
    }
}