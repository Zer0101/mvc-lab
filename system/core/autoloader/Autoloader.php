<?php

namespace System\Autoload;

use System\Config\Autoload as AutoloadConfig;

/**
 *
 * @package      System
 * @author       Anton Zencenco
 * @copyright    Copyright (c) 2016 - 2017
 * @license      https://opensource.org/licenses/MIT MIT License
 * @since        0.0.0
 * @filesource
 */

/**
 * Class Autoloader
 *
 * An autoloader, that uses PSR4, traditional classmap and file loading
 *
 * @package System
 */
class Autoloader
{
    /**
     * Array of PSR-4 style pairs namespaces:path
     *
     * @var array
     */
    protected $psr4 = [];

    /**
     * An old fashioned classmap: name if class and path to file
     *
     * @var array
     */
    protected $classmap = [];

    /**
     * An array of files that will be loaded on the start
     *
     * @var array
     */
    protected $files = [];

    /**
     * Allowed extensions
     *
     * @var array
     */
    protected $extensions = ['php', 'inc'];

    /**
     * Autoloader constructor.
     * Gets values from config and begins to work
     *
     * @param \System\Config\Autoload $config
     */
    public function __construct(AutoloadConfig $config)
    {
        $this->psr4 = $config->psr4 ?? $this->psr4;
        $this->classmap = $config->classmap ?? $this->classmap;
        $this->files = $config->files ?? $this->files;
    }

    /**
     * Registrate autoload functions
     */
    public function register()
    {
        // First prepend PSR-4 autoloader
        spl_autoload_register([$this, 'load'], true, true);

        //Second - prepend autoloader for mapped classes
        spl_autoload_register([$this, 'loadMapped'], true, true);

        //Third - connect directly registered static files
        if (!empty($this->files)) {
            foreach ($this->files as $staticFile) {
                $this->load($staticFile);
            }
        }
    }

    /**
     * Unregister current autoloaders
     */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'load']);
        spl_autoload_unregister([$this, 'loadMapped']);
    }

    /**
     * Autoload method to load files from your psr4 table
     *
     * @param      $name
     * @param bool $is_file
     *
     * @return bool
     */
    public function load($name, $is_file = false) :bool
    {
        if (empty($name) || (strpos('\\', $name) === false && !$is_file)) {
            return false;
        }

        if ($is_file) {
            return $this->connectFile($name);
        }

        $name = trim($name, '\\');
        $name = str_ireplace($this->extensions, '', $name);
        foreach ($this->psr4 as $namespace => $directory) {
            if (strpos($name, $namespace) === 0) {
                $length = strlen($namespace);
                $fileName = $directory . str_replace('\\', '/', substr($name, $length)) . '.php';
                $fileName = $this->connectFile($fileName);

                if ($fileName) {
                    return $fileName;
                }
            }
        }

        return false;
    }

    /**
     * Autoload method to load files from your classmap table
     *
     * @param $class
     */
    public function loadMapped($class)
    {
        //If such class is not registered or is not readable - function stop execution
        if (!isset($this->classmap[$class]) || !is_readable($this->classmap[$class])) {
            return;
        }

        //Else file is included
        $this->connectFile($this->classmap[$class]);
    }

    /**
     * Sanitize file name from illegal symbols
     *
     * @param $name
     *
     * @return string
     */
    public function sanitize($name) :string
    {
        //Autoloader MUST not return any value or throw exception
        //so if name was empty (ex. null) simple return empty string
        $name = preg_replace('/[^a-zA-Z0-9\_\-\s\/\.\:\\\\]/', '', $name) ?? '';

        return $name ?? '';
    }

    /**
     * Connect fpuned file
     *
     * @param string $name
     *
     * @return bool
     */
    protected function connectFile(string $name) :bool
    {
        $name = $this->sanitize($name);

        if (is_readable($name)) {
            require $name;

            return true;
        }

        return false;
    }
}