<?php

namespace spec\Marlek\LaravelAutomigrate;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Marlek\LaravelAutomigrate\CommandGenerator');
    }

    function it_should_require_packages_config()
    {
        $config = array();
        $this->shouldThrow('Marlek\LaravelAutomigrate\Exceptions\InvalidConfigException')
            ->duringValidateConfig();
    }

    function it_should_not_allow_non_array_packages_config()
    {
        $config = 'Testing config';
        $this->setConfig($config);
        $this->shouldThrow('Marlek\LaravelAutomigrate\Exceptions\InvalidConfigException')
            ->duringValidateConfig();
    }

    function it_should_not_allow_wrong_options_in_config()
    {
        $package = array('testing', 'Marlek\LaravelAutomigrate');
        $this->shouldThrow('Marlek\LaravelAutomigrate\Exceptions\WrongParametersException')
            ->duringParsePackage($package);
    }

    function it_should_generate_valid_commands()
    {
        $config = array(
            'packages' => array(
                array('package', 'marlek/laravel-automigrate'),
                array('bench', 'marlek/testing'),
                array('path', 'app/database/migrations_two')
            )
        );
        $responseArray = array(
            array('--package' => 'marlek/laravel-automigrate'),
            array('--bench' => 'marlek/testing'),
            array('--path' => 'app/database/migrations_two')
        );

        $this->setConfig($config);
        $this->generateCommands()->shouldReturn($responseArray);
    }
}
