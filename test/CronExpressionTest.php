<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2018/02/5
 * Time: 下午7:53
 */

namespace Swokit\Task\Test;

use PHPUnit\Framework\TestCase;
use Swokit\Task\CronExpression;

/**
 *
 */
class CronExpressionTest extends TestCase
{

    public function testParse()
    {
        // $time = CronExpression::parse('*/1 * * * *');
        // var_dump($time, CronExpression::getNodes());

        $time = CronExpression::parse('* * * * * *');

        var_dump($time);
    }
}
