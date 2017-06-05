<?php

namespace Service;

/**
 * Class ConfigReader
 * @package Service
 */
final class ConfigReader
{
    /**
     * @var string
     */
    private $configPath;

    /**
     * @var array
     */
    private $configOptions = [];

    /**
     * @var ConfigReader
     */
    private static $instance;

    /**
     * @param $optionName
     * @return string
     */
    public static function get($optionName) : string
    {
        if (!isset(self::$instance)) {
            self::$instance = new ConfigReader(CONFIG_PATH);
        }

        return self::$instance->configOptions[$optionName] ?? '';
    }

    /**
     * ConfigReader constructor.
     * @param $configPath
     */
    private function __construct($configPath)
    {
        $this->configPath = $configPath;
        $this->configOptions = parse_ini_file($this->configPath);
    }

    /**
     *
     */
    private function __clone() {}

}
