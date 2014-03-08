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

	private function validateConfig()
	{
		if (!(isset($this->config['packages']) && is_array($this->config['packages'])))
		{
			throw new InvalidConfigException('Packages in configuration need to be passed as an array');
		}
	}

	private function parsePackages()
	{
		$this->validateConfig();
		$packages = $this->config['packages'];

		$responseCommands = array();
		foreach ($packages as $package)
		{
			if (!(is_array($package) && isset($package[0]) && isset($package[1]) && ($package[0] === 'package' || $package[0] === 'bench')))
			{
				throw new WrongParametersException('Wrong parameters passed to packages array in configuration');
			}

			if ($package[0] === 'package')
			{
				$responseCommands[] = array('--package' => $package[1]);
			}
			else
			{
				$responseCommands[] = array('--bench' => $package[1]);
			}
		}
		
		return $responseCommands;
	}

	function generateCommands()
	{
		return $this->parsePackages();
	}

}
