<?php

namespace System\Config;

/**
 * Class Autoload
 * Class for decoration Base configs, Will be transferred afterwards to Autoload
 *
 * @package System\Config
 */
class Autoload implements \System\Config\Config
{
    protected $config;

    /**
     * PSR4 style default values
     *
     * @var array
     */
    protected $psr4 = [];

    /**
     * Standard classmap only used for mapping of all classes existing in project
     *
     * @var array
     */
    protected $classmap = [
        'System\\Http\\Request' => SYSPATH . 'core/request/Request.php',
    ];

    /**
     * Default static files
     *
     * @var array
     */
    protected $files = [];

    /**
     * Autoload class constructor - main constructor of this class
     *
     * @param \System\Config\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        //Decorate psr4
        if (!empty($this->config->psr4)) {
            $this->psr4 = array_merge($this->psr4, $this->config->toArray('psr4'));
        }

        //Decorate classmap
        if (!empty($this->config->classmap)) {
            $this->classmap = array_merge($this->classmap, $this->config->toArray('classmap'));

        }

        //Decorate static files
        if (!empty($this->config->files)) {
            $this->files = array_merge($this->files, $this->config->toArray('files'));
        }
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if (!empty($this->$name) && $name !== 'config') {
            return $this->$name;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function __set(string $name, $value)
    {
        if (!empty($this->$name) && $name !== 'config') {
            $this->$name = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function toArray($index = null) :array
    {
        if (!empty($this->$index) && $index !== 'config') {
            return $this->$index;
        }

        return [
            'psr4'     => $this->psr4,
            'classmap' => $this->classmap,
            'files'    => $this->files,
        ];
    }
}