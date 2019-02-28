<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午1:09
 */

namespace Swokit\Task;

use Swoole\Server;

/**
 * Class TaskHelper
 * @package Swokit\Task
 */
final class TaskHelper
{
    /**
     * @return  boolean
     */
    public static function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * @return  boolean
     */
    public static function isWin(): bool
    {
        return DIRECTORY_SEPARATOR === '\\';
    }

    /**
     * @return bool
     */
    public static function hasSwoole(): bool
    {
        return \class_exists(Server::class, false);
    }

    /**
     * @return bool
     */
    public static function hasPcntl(): bool
    {
        return \extension_loaded('pcntl');
    }

    /**
     * @return bool
     */
    public static function hasPosix(): bool
    {
        return \extension_loaded('posix');
    }

    /**
     * @param       $obj
     * @param array $config
     */
    public static function initObject($obj, array $config): void
    {
        foreach ($config as $name => $value) {
            $setter = 'set' . ucfirst($name);

            if (\method_exists($obj, $setter)) {
                $obj->$setter($value);
            } elseif (\property_exists($obj, $name)) {
                $obj->$name = $value;
            }
        }
    }

    /**
     * @param callable $cb
     * @param array    ...$args
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
            [$obj, $mhd] = $cb;

            return \is_object($obj) ? $obj->$mhd(...$args) : $obj::$mhd(...$args);
        }

        return $cb(...$args);
    }

    /**
     * @param string               $command
     * @param null|string|resource $output
     * - string     It is log file path
     * - resource   It is opened file handle
     * @param string|null          $user
     * @return string
     */
    public static function exec(string $command, $output = null, string $user = null): string
    {
        return \exec($command);
    }

    /**
     * @param string $dir
     * @param int    $mode
     * @throws \RuntimeException
     */
    public static function mkdir(string $dir, int $mode = 0775): void
    {
        if (!file_exists($dir) && !mkdir($dir, $mode, true) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }
    }

}
