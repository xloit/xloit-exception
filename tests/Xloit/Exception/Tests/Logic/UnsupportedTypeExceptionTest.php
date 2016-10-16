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

namespace Xloit\Exception\Tests\Logic;

use Xloit\Exception\Logic\UnsupportedTypeException;
use Xloit\Exception\Tests\AbstractExceptionTest;

/**
 * Test class for {@link UnsupportedTypeExceptionTest}
 *
 * @package Xloit\Exception\Tests\Logic
 */
class UnsupportedTypeExceptionTest extends AbstractExceptionTest
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->className = UnsupportedTypeException::class;
        $this->messageTemplate = 'Expected argument of type "%type%"; "%source%" given';
        $this->messageVariables = [
            'type' => 'string',
            'source' => new UnsupportedTypeException
        ];
        $this->expectedMessage = sprintf(
            'Expected argument of type "string"; "[Object "%s"]" given',
            UnsupportedTypeException::class
        );
    }
} 
