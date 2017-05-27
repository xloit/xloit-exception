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

namespace Xloit\Exception;

/**
 * A {@link LogicException} class represents error in the program logic. This kind of exceptions should directly
 * lead to a fix in your code.
 *
 * @link    http://php.net/manual/en/class.logicexception.php
 *
 * @package Xloit\Exception
 */
class LogicException extends Exception
{
    /**
     * Code of the exception.
     *
     * @var int|string
     */
    const CODE = 2;
} 
