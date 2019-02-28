<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:53
 */

namespace Swokit\Task\Schedule;

/**
 * Class CronExpression 解析 CronTab格式
 * @package Swokit\Task\Schedule
 * Schedule parts must map to:
 * - second [0-59],
 * - minute [0-59],
 * - hour [0-23],
 * - day of month, month [1-12|JAN-DEC],
 * - day of week [1-7|MON-SUN],
 * - and an optional year.
 */
class CronExpression
{
    public const MONTHS = [
        'JAN',
        'FEB',
        'MAR',
        'APR',
        'MAY',
        'JUN',
        'JUL',
        'AUG',
        'SEP',
        'OCT',
        'NOV',
        'DEC'
    ];

    public const DayOfWeek = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

    /** @var string|null */
    public static $error;

    /** @var array */
    public static $nodes = [];

    /**
     * 解析cronTab的定时格式，linux只支持到分钟，这个类支持到秒
     * @param string $expression :
     *      0     1    2    3    4    5
     *      *     *    *    *    *    *
     *      -     -    -    -    -    -
     *      |     |    |    |    |    |
     *      |     |    |    |    |    +----- day of week (0 - 6) (Sunday=0)
     *      |     |    |    |    +----- month (1 - 12)
     *      |     |    |    +------- day of month (1 - 31)
     *      |     |    +--------- hour (0 - 23)
     *      |     +----------- min (0 - 59)
     *      +------------- sec (0-59)
     * @example
     * // 15minutes between 6pm and 6am
     * '0,15,30,45 18-06 * * *'
     * // 每小时的第3和第15分钟执行
     * '3,15 * * * *'
     * @param int    $startTime timestamp [default=current timestamp]
     * @return bool|int Unix timestamp - 下一分钟内执行是否需要执行任务，如果需要，则把需要在那几秒执行返回
     * @throws \InvalidArgumentException 错误信息
     */
    public static function parse(string $expression, int $startTime = null)
    {
        $expression = \str_replace(["\t", "\n", '  '], ' ', \trim($expression));
        // $nodes = explode(' ', $expression);
        $nodes  = \preg_split("/[\s]+/i", $expression);
        $length = \count($nodes);

        if ($length === 6) {
            self::$nodes = $date = [
                'sec'   => empty($nodes[0]) ? [1 => 1] : self::parseNode($nodes[0], 0, 59),
                'min'   => self::parseNode($nodes[1], 0, 59),
                'hour'  => self::parseNode($nodes[2], 0, 23),
                'day'   => self::parseNode($nodes[3], 1, 31),
                'month' => self::parseNode($nodes[4], 1, 12),
                'week'  => self::parseNode($nodes[5], 0, 6),
            ];
        } elseif ($length === 5) {
            self::$nodes = $date = [
                'sec'   => [1 => 1],
                'min'   => self::parseNode($nodes[0], 0, 59),
                'hour'  => self::parseNode($nodes[1], 0, 23),
                'day'   => self::parseNode($nodes[2], 1, 31),
                'month' => self::parseNode($nodes[3], 1, 12),
                'week'  => self::parseNode($nodes[4], 0, 6),
            ];
        } else {
            self::$error = "Invalid cron expression: $expression";
            return false;
        }

        if ($startTime <= 0) {
            $startTime = time();
        }

        // string(13) "07 16 12 4 10"
        // $dateStr = date('i H d w m', $startTime);
        $sample = explode(' ', date('i G j w n', $startTime));

        if (
            \in_array((int)$sample[0], $date['min'], true) &&
            \in_array((int)$sample[1], $date['hour'], true) &&
            \in_array((int)$sample[2], $date['day'], true) &&
            \in_array((int)$sample[3], $date['week'], true) &&
            \in_array((int)$sample[4], $date['month'], true)
        ) {
            return $date['sec'];
        }

        return false;
    }

    /**
     * 解析单个配置的含义
     * @param string $s
     * @param int    $min
     * @param int    $max
     * @return array
     */
    protected static function parseNode(string $s, int $min, int $max): array
    {
        $result = [];
        $v1     = \explode(',', $s);

        foreach ($v1 as $v2) {
            $v3   = \explode('/', $v2);
            $v4   = \explode('-', $v3[0]);
            $step = empty($v3[1]) ? 1 : (int)$v3[1];

            // $_min = count($v4) === 2 ? (int)$v4[0] : ($v3[0] === '*' ? $min : (int)$v3[0]);
            // $_max = count($v4) === 2 ? (int)$v4[1] : ($v3[0] === '*' ? $max : (int)$v3[0]);

            if (\count($v4) === 2) {
                $_min = (int)$v4[0];
                $_max = (int)$v4[1];
            } else {
                $_min = $v3[0] === '*' ? $min : (int)$v3[0];
                $_max = $v3[0] === '*' ? $max : (int)$v3[0];
            }

            for ($i = $_min; $i <= $_max; $i += $step) {
                if ($i < $min) {
                    $result[$min] = $min;
                } elseif ($i > $max) {
                    $result[$max] = $max;
                } else {
                    $result[$i] = $i;
                }
            }
        }

        ksort($result);

        return $result;
    }

    public static function getError(): ?string
    {
        return self::$error;
    }

    /**
     * @return array
     */
    public static function getNodes(): array
    {
        return self::$nodes;
    }
}
