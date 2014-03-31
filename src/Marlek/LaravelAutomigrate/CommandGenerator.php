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
		if (!(isset($this->config['packages']) && is_array($this->config['packages'])))
		{
			throw new InvalidConfigException('Packages in configuration need to be passed as an array');
		}
	}

	public function parsePackages()
	{
		$this->validateConfig();
		$packages = $this->config['packages'];

		$responseCommands = array();
		foreach ($packages as $package)
		{
			$responseCommands[] = $this->parsePackage($package);
		}

		return $responseCommands;
	}

	public function parsePackage($package)
	{
		if (!$this->checkParameters($package))
		{
			throw new WrongParametersException('Wrong parameters passed to packages array in configuration');
		}

		if ($package[0] === 'package')
		{
			return array('--package' => $package[1]);
		}
		else
		{
			return array('--bench' => $package[1]);
		}
	}

	public function checkParameters($package)
	{
		if (!(is_array($package) && isset($package[0]) && isset($package[1])))
		{
			return false;
		}

		if (!($package[0] === 'package' || $package[0] === 'bench'))
		{
			return false;
		}

		return true;
	}

	function generateCommands()
	{
		return $this->parsePackages();
	}

}
