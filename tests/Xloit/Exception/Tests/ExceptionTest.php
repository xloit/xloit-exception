<?php
/**
 * This source file is part of Xloit project.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * <http://www.opensource.org/licenses/mit-license.php>
 * If you did not receive a copy of the license and are unable to obtain it through the world-wide-web,
 * please send an email to <license@xloit.com> so we can send you a copy immediately.
 *
 * @license   MIT
 * @link      http://xloit.com
 * @copyright Copyright (c) 2016, Xloit. All rights reserved.
 */

namespace Xloit\Exception\Tests;

use Exception as PhpException;
use Xloit\Exception\Exception;

/**
 * Test class for {@link ExceptionTest}
 *
 * @package Xloit\Exception\Tests
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testStandardUsage()
    {
        $exception = new Exception('foo');

        static::assertEquals('foo', $exception->getMessage());
    }

    public function testGetPreviousNone()
    {
        $exception = new Exception('foo bar');

        static::assertNull($exception->getPrevious());
    }

    public function testGetCauseException()
    {
        $previous  = new PhpException('foo bar');
        $exception = new Exception('I caught an exception', $previous);

        static::assertNotNull($exception->getPrevious());
        static::assertInstanceOf(PhpException::class, $exception->getPrevious());
        static::assertEquals($previous, $exception->getPrevious());
    }

    public function testCreateMethod()
    {
        $exception = Exception::create(
            'This is %my% %index%st message.',
            [
                'my'    => 'my',
                'index' => 1
            ]
        );

        static::assertEquals('This is my 1st message.', $exception->getMessage());
    }

    /**
     * Nearly identical to the `testCreateUsingFormat()` test, but this time
     * a `$previous` exception will be passed. The message should be the same
     * as before, but the `$previous` exception must be returned this time.
     */
    public function testCreateMethodWithPrevious()
    {
        $previous  = new PhpException('The previous exception.');
        $exception = Exception::create(
            'This is %my% %index%st message.',
            [
                'my'    => 'my',
                'index' => 1
            ],
            null,
            $previous
        );

        static::assertSame($previous, $exception->getPrevious());
        static::assertInstanceOf(PhpException::class, $exception->getPrevious());
        static::assertInstanceOf(Exception::class, $exception);
        static::assertEquals('This is my 1st message.', $exception->getMessage());
    }

    /**
     * **No errors should be generated prior to this test.** This test will
     * check that the default message "(unknown error)" is used if no error
     * has been generated.
     */
    public function testCreateUsingLastErrorWithDefault()
    {
        $exception = Exception::createLastError();

        static::assertEquals('(Unknown Error)', $exception->getMessage());
    }

    /**
     * Like the `testCreateUsingLastErrorWithDefault()` test, no errors should
     * be generated prior to this test. This test will check that the user given
     * default message is used if no error has been generated.
     */
    public function testCreateUsingLastErrorWithDefaultGiven()
    {
        $default   = 'Default message.';
        $exception = Exception::createLastError($default);

        static::assertEquals($default, $exception->getMessage());
    }

    public function testGetCauseMessage()
    {
        $previous  = new PhpException('foo bar', 0, new Exception('The first exception'));
        $exception = new Exception('I caught an exception', $previous);
        $causes    = $exception->getCauseMessage();

        static::assertEquals(Exception::class, $causes[0]['class']);
        static::assertEquals('I caught an exception', $causes[0]['message']);

        static::assertEquals(PhpException::class, $causes[1]['class']);
        static::assertEquals('foo bar', $causes[1]['message']);

        static::assertEquals(Exception::class, $causes[2]['class']);
        static::assertEquals('The first exception', $causes[2]['message']);
    }

    public function testGetTraceSafe()
    {
        $exception = new Exception('oops');

        static::assertInternalType('string', $exception->getTraceSaveAsString());
    }

    public function testToStringMethod()
    {
        $exception = new Exception('oops');

        static::assertInternalType('string', (string) $exception);
        static::assertContains('oops', (string) $exception);
    }

    public function testVariantMessageFormat()
    {
        $exception = Exception::create(
            'Wrong parameters for %class%::%method%([array|string $message]);',
            [
                'class'  => new Exception(),
                'method' => 'setMessage'
            ]
        );

        static::assertEquals(
            'Wrong parameters for [Object "Xloit\Exception\Exception"]::setMessage([array|string $message]);',
            $exception->getMessage()
        );

        $exception = Exception::create(
            'Wrong parameters for %class%::%method%([%type% $message]);',
            [
                'class'  => new Exception(),
                'method' => 'setMessage',
                'type'   => [
                    'array',
                    'string'
                ]
            ]
        );

        static::assertEquals(
            'Wrong parameters for [Object "Xloit\Exception\Exception"]::setMessage([array, string $message]);',
            $exception->getMessage()
        );

        $exception = Exception::create(
            'Wrong parameters for %type%',
            [
                'type' => null
            ]
        );

        static::assertEquals(
            'Wrong parameters for [NULL]',
            $exception->getMessage()
        );
    }

    public function testSetCodeMethod()
    {
        $exception = new Exception('oops');

        $exception->setCode(500);

        static::assertInternalType('integer', $exception->getCode());
        static::assertEquals(500, $exception->getCode());

        $exception->setCode('404');

        static::assertInternalType('string', $exception->getCode());
        static::assertEquals('404', $exception->getCode());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode E_ERROR
     * @expectedExceptionMessage Wrong parameters for Xloit\Exception\Exception::setCode([integer|string $code]);
     *     Xloit\Exception\Exception given.
     */
    public function testSetCodeMethodInvalidArguments()
    {
        $exception = new Exception('oops');

        $exception->setCode(new Exception());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode E_ERROR
     * @expectedExceptionMessage Wrong parameters for Xloit\Exception\Exception::setMessage([array|string $message]);
     *     Xloit\Exception\Exception given.
     */
    public function testSetMessageMethodInvalidArguments()
    {
        $exception = new Exception('oops');

        $exception->setMessage(new Exception());
    }

}
