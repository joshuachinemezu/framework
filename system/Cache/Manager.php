<?php
/**
 * Cache Manager
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 * @date January 8th, 2016
 */

namespace Nova\Cache;

use Nova\Config;

use \phpFastCahe;

class Manager
{
    // The phpFastCahe instance.
    protected $cache = null;

    // The Cache Manager instances.
    protected static $instances[] = array();

    protected function __construct($storage = '')
    {
        $config = Config::get('cache');

        $config['storage'] = $storage;

        $storage = strtolower($storage);

        if (($storage == '') || ($storage == 'auto')) {
            $storage = phpFastCache::getAutoClass($config);
        }

        $this->cache = phpFastCache($storage, $config);
    }

    public static function getCache($storage = 'files')
    {
        if (! isset(self::$instances[$storage])) {
            self::$instances[$storage] = new self($storage);
        }

        return self::$instances[$storage];
    }

    /**
     * Provide direct access to any of \phpFastCahe methods.
     *
     * @param $name
     * @param $params
     */
    public function __call($method, $params = null)
    {
        if (method_exists($this->cache, $method)) {
            return call_user_func_array(array($this->cache, $method), $params);
        }
    }
}