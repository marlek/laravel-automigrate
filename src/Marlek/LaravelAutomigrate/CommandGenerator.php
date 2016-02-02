<?php namespace Marlek\LaravelAutomigrate;

use Marlek\LaravelAutomigrate\Exceptions\InvalidConfigException;
use Marlek\LaravelAutomigrate\Exceptions\WrongParametersException;

class CommandGenerator
{

	protected $config;

	public function setConfig($config)
	{
		$this->config = $config;
	}

	public function validateConfig()
	{
		if (!(isset($this->config['paths']) && is_array($this->config['paths'])))
		{
			throw new InvalidConfigException('Pahts need to be passed as an array in configuration');
		}
	}

    function generateCommands()
    {
        $this->validateConfig();
        $paths = $this->config['paths'];

        $responseCommands = [];
        foreach ($paths as $path)
        {
            $responseCommands[] = ['--path' => $path];
        }

        return $responseCommands;
    }

}
