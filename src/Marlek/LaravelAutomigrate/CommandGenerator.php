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

    public function checkParameters($package)
	{
		if (!(is_array($package) && isset($package[0]) && isset($package[1])))
		{
			return false;
		}

		if (!($package[0] === 'package' || $package[0] === 'bench' || $package[0] === 'path'))
		{
			return false;
		}

		return true;
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
