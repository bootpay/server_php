<?php

namespace BootPay\Rest;

trait Singleton
{
    /**
     * Container for the objects.
     *
     * @since   0.1
     */
    private static $instances = null;

    /**
     * Get an instance of the current, called class.
     *
     * @since   0.1
     * @access  public
     * @return  object An instance of $cls
     */
    public static function instance()
    {
        !isset(static::$instances) && self::$instances = new static;
        return static::$instances;
    }
}