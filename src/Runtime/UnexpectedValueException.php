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

namespace Xloit\Exception\Runtime;

use Xloit\Exception\RuntimeException;

/**
 * An {@link UnexpectedValueException} class will thrown if a value does not match with a set of values.
 * Typically this happens when a function calls another function and expects the return value to be of a
 * certain type or value not including arithmetic or buffer related errors.
 *
 * @link    http://php.net/manual/en/class.unexpectedvalueexception.php
 *
 * @package Xloit\Exception\Runtime
 */
class UnexpectedValueException extends RuntimeException
{
    /**
     * Code of the exception.
     *
     * @var integer|string
     */
    const CODE = 304;
} 
