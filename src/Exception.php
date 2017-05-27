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

use Exception as PhpException;
use InvalidArgumentException;
use Traversable;
use Xloit\Std\Interop\Action\ToStringInterface;

/**
 * An {@link Exception} class.
 *
 * @package Xloit\Exception
 */
class Exception extends PhpException implements ToStringInterface
{
    /**
     * Code of the exception.
     *
     * @var int|string
     */
    const CODE = 1;

    /**
     * The header message.
     *
     * @var string
     */
    const EXC_HEADER_INFO = 'The exception has been thrown';

    /**
     * The template of detail cause exception messages.
     *
     * @var string
     */
    const EXC_CAUSE_MESSAGE_DETAILS = "- %class% : '%message%' in '%file%' on line %line% [CODE : %code%]";

    /**
     * Code of the exception.
     *
     * @var int|string
     */
    protected $code = self::CODE;

    /**
     * The exception message template.
     *
     * @var string
     */
    protected $messageTemplate = 'Unknown Exception Reason.';

    /**
     * Container of the options.
     *
     * @var array
     */
    protected $options = [];

    /**
     *
     *
     * @var array
     */
    protected $messageVariables = [];

    /**
     *
     *
     * @var null|PhpException
     */
    private $_previous;

    /**
     * Constructor to prevent {@link Exception} from being loaded more than once.
     *
     * @link   http://php.net/manual/en/exception.construct.php
     *
     * @param string       $message  The message format.
     * @param int|string   $code     The code of this exception.
     * @param PhpException $previous The previous exception.
     *
     * @throws InvalidArgumentException
     */
    public function __construct($message = null, $code = null, PhpException $previous = null)
    {
        if ($code instanceof PhpException) {
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $previous = $code;
            $code     = static::CODE;
        }

        if (!is_numeric($code)) {
            $code = static::CODE;
        }

        $this->setCode($code);

        if ($message) {
            $this->setMessage($message);
        } else {
            $this->setMessage($this->getMessageVariables());
        }

        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            // @codeCoverageIgnoreStart
            $this->_previous = $previous;

            parent::__construct($this->getMessage(), $this->getCode());
            // @codeCoverageIgnoreEnd
        } else {
            parent::__construct($this->getMessage(), $this->getCode(), $previous);
        }
    }

    /**
     * Creates a new exception by the given arguments.
     *
     * @param string       $message          The message format.
     * @param array        $messageVariables The message variables.
     * @param int|string   $code             The code of this exception.
     * @param PhpException $previous         The previous exception.
     *
     * @return Exception The new exception.
     * @throws InvalidArgumentException
     */
    public static function create($message, $messageVariables = null, $code = null, PhpException $previous = null)
    {
        $messageFormat = [
            'message'          => $message,
            'messageVariables' => $messageVariables
        ];

        return new static($messageFormat, $code, $previous);
    }

    /**
     * Uses the last error message to create a new exception.
     *
     * A new exception will be created using the last error message, which is returned by the `error_get_last()`
     * function. If no error message was generated, the `$default` message will be used. By default, that message
     * is "(unknown error)".
     *
     * @param string $default The default message.
     *
     * @return Exception The new exception.
     * @throws InvalidArgumentException
     */
    public static function createLastError($default = '(Unknown Error)')
    {
        $message = error_get_last();

        if (null === $message) {
            $message = $default;
        }

        return static::create($message);
    }

    /**
     *
     * @codeCoverageIgnore
     *
     * @param array|Traversable $options
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public function setOptions($options)
    {
        if (!is_array($options) && !$options instanceof Traversable) {
            throw new InvalidArgumentException(__METHOD__ . ' expects an array or Traversable');
        }

        if ($options instanceof Traversable) {
            $options = iterator_to_array($options);
        }

        foreach ($options as $name => $option) {
            $method = 'set' . ucfirst($name);

            if (($name !== 'setOptions') && method_exists($this, $name)) {
                $this->{$name}($option);
            } elseif (($method !== 'setOptions') && method_exists($this, $method)) {
                $this->{$method}($option);
            } else {
                $this->options[$name] = $option;
            }
        }

        return $this;
    }

    /**
     *
     * @codeCoverageIgnore
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the Exception code.
     *
     * @param int|string $code
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public function setCode($code)
    {
        if (!is_scalar($code)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Wrong parameters for %s([int|string $code]); %s given.',
                    __METHOD__,
                    is_object($code) ? get_class($code) : gettype($code)
                ),
                E_ERROR
            );
        }

        $this->code = $code;

        return $this;
    }

    /**
     * Sets the Exception generated message.
     *
     * @param array|string $message
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public function setMessage($message)
    {
        $messageVariables = null;

        if (is_array($message)) {
            if (array_key_exists('messageVariables', $message)) {
                $messageVariables = $message['messageVariables'];
            }

            if (array_key_exists('message', $message)) {
                $message = $message['message'];
            } else {
                $messageVariables = $message;
                $message          = $this->messageTemplate;
            }
        }

        if (!is_string($message)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Wrong parameters for %s([array|string $message]); %s given.',
                    __METHOD__,
                    is_object($message) ? get_class($message) : gettype($message)
                ),
                E_ERROR
            );
        }

        $this->message = $this->createMessage($message, $messageVariables);

        return $this;
    }

    /**
     * Sets the variables that are used in constructing exception messages.
     *
     * @codeCoverageIgnore
     *
     * @param string $key
     * @param string $variable
     *
     * @return static
     */
    public function setMessageVariable($key, $variable)
    {
        $this->messageVariables[$key] = $variable;

        return $this;
    }

    /**
     * Returns an array of the names of variables that are used in constructing exception messages.
     *
     * @return array
     */
    public function getMessageVariables()
    {
        return $this->messageVariables;
    }

    /**
     * Constructs and returns a exception message with the given message key and value.
     * Returns null if and only if the given key does not correspond to an existing template.
     *
     * @param string $message
     * @param array  $variables
     *
     * @return string
     */
    protected function createMessage($message, $variables = null)
    {
        if (null !== $variables && is_array($variables)) {
            $variables = array_merge($this->getMessageVariables(), $variables);
        } else {
            $variables = $this->getMessageVariables();
        }

        foreach ($variables as $variableKey => $variable) {
            if (is_array($variable) || ($variable instanceof Traversable)) {
                $variable = implode(', ', array_values($variable));
            }

            if (!is_scalar($variable)) {
                $variable = $this->switchType($variable);
            }

            $message = str_replace("%$variableKey%", (string) $variable, $message);
        }

        return $message;
    }

    /**
     * Get the message of caused exceptions.
     *
     * @return array
     */
    public function getCauseMessage()
    {
        $causes  = [];
        $current = [
            'class'   => get_class($this),
            'message' => $this->getMessage(),
            'code'    => $this->getCode(),
            'file'    => $this->getFile(),
            'line'    => $this->getLine()
        ];

        $causes[] = $current;
        $previous = $this->getPrevious();

        while ($previous !== null) {
            if ($previous instanceof Exception) {
                $prevCauses = $previous->getCauseMessage();

                foreach ($prevCauses as $cause) {
                    $causes[] = $cause;
                }
            } elseif ($previous instanceof PhpException) {
                $causes[] = [
                    'class'   => get_class($previous),
                    'message' => $previous->getMessage(),
                    'code'    => $previous->getCode(),
                    'file'    => $previous->getFile(),
                    'line'    => $previous->getLine()
                ];
            }

            $previous = $previous->getPrevious();
        }

        return $causes;
    }

    /**
     * Gets the stack trace as a string.
     *
     * @link  http://php.net/manual/en/exception.gettraceasstring.php
     *
     * @return string
     */
    public function getTraceSaveAsString()
    {
        $traces   = $this->getTrace();
        $messages = ['STACK TRACE DETAILS : '];

        foreach ($traces as $index => $trace) {
            $message = sprintf('#%d ', $index + 1);

            /** @noinspection UnSafeIsSetOverArrayInspection */
            if (isset($trace['file'])) {
                if (!is_string($trace['file'])) {
                    $message .= '[Unknown Function]: ';
                } else {
                    $line = 0;

                    /** @noinspection UnSafeIsSetOverArrayInspection */
                    if (isset($trace['line']) && is_int($trace['line'])) {
                        $line = $trace['line'];
                    }

                    $message .= sprintf('%s(%d): ', $trace['file'], $line);
                }
            } else {
                $message .= '[Internal Function]: ';
            }

            /** @noinspection UnSafeIsSetOverArrayInspection */
            if (isset($trace['class']) && is_string($trace['class'])) {
                $message .= $trace['class'] . ' ';
            }

            /** @noinspection UnSafeIsSetOverArrayInspection */
            if (isset($trace['type']) && is_string($trace['type'])) {
                $message .= $trace['type'] . ' ';
            }

            /** @noinspection UnSafeIsSetOverArrayInspection */
            if (isset($trace['function']) && is_string($trace['function'])) {
                $message .= $trace['function'] . '(';

                /** @noinspection UnSafeIsSetOverArrayInspection */
                if (isset($trace['args']) && count($trace['args']) > 0) {
                    /** @var array $arguments */
                    $arguments    = $trace['args'];
                    $argVariables = [];

                    foreach ($arguments as $argument) {
                        $argVariables[] = $this->switchType($argument);
                    }

                    $message .= implode(', ', $argVariables);
                }

                $message .= ')';
            }

            $messages[] = trim($message);
        }

        return implode("\n", $messages);
    }

    /**
     * Convert type to string.
     *
     * @param mixed $argument
     *
     * @return string
     */
    protected function switchType($argument)
    {
        $stringType = null;
        $type       = strtolower(gettype($argument));

        switch ($type) {
            case 'boolean':
                $stringType = sprintf(
                    '[%s "%s"]', ucwords($type),
                    ((int) $argument === 1) ? 'True' : 'False'
                );
                break;
            case 'integer':
            case 'double':
            case 'float':
            case 'string':
                $stringType = sprintf('[%s "%s"]', ucwords($type), $argument);
                break;
            case 'array':
                $stringType = sprintf(
                    '[%s {value: %s}]', ucwords($type), var_export($argument, true)
                );
                break;
            case 'object':
                $stringType = sprintf('[%s "%s"]', ucwords($type), get_class($argument));
                break;
            case 'resource':
                $stringType = sprintf('[%s]', ucwords($type));
                break;
            case 'null':
                $stringType = '[NULL]';
                break;
            default;
                $stringType = '[Unknown Type]';
                break;
        }

        return $stringType;
    }

    /**
     * Overloading for PHP < 5.3.0, provides access to the getPrevious() method.
     *
     * @codeCoverageIgnore
     *
     * @param string $method
     * @param array  $args
     *
     * @return null|PhpException
     */
    public function __call($method, array $args)
    {
        if ('getPrevious' === $method) {
            return $this->_previous;
        }

        return null;
    }

    /**
     * String representation of the exception.
     *
     * @link  http://php.net/manual/en/exception.tostring.php
     *
     * @return string
     */
    public function __toString()
    {
        $causes  = $this->getCauseMessage();
        $message = sprintf(
            "%s (%s - %d) : \n",
            $this->createMessage(self::EXC_HEADER_INFO),
            __CLASS__,
            $this->getCode()
        );

        foreach ($causes as $index => $cause) {
            $message .= sprintf(
                "%s%s\n",
                str_repeat('  ', $index) . '--> ',
                $this->createMessage(self::EXC_CAUSE_MESSAGE_DETAILS, $cause)
            );
        }

        return $message . $this->getTraceSaveAsString();
    }
}
