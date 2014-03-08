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
            ->duringGenerateCommands($config);
    }

    function it_should_not_allow_non_array_packages_config()
    {
        $config = 'Testing config';
        $this->shouldThrow('Marlek\LaravelAutomigrate\Exceptions\InvalidConfigException')
            ->duringGenerateCommands($config);
    }

    function it_should_not_allow_wrong_options_in_config()
    {
        $config = array(
            'packages' => array(
                array('testing', 'Marlek\LaravelAutomigrate')
            )
        );
        $this->setConfig($config);
        $this->shouldThrow('Marlek\LaravelAutomigrate\Exceptions\WrongParametersException')
            ->duringGenerateCommands();
    }

    function it_should_generate_valid_commands()
    {
        $config = array(
            'packages' => array(
                array('package', 'marlek/laravel-automigrate'),
                array('bench', 'marlek/testing')
            )
        );
        $responseArray = array(
            array('--package' => 'marlek/laravel-automigrate'),
            array('--bench' => 'marlek/testing')
        );

        $this->setConfig($config);
        $this->generateCommands()->shouldReturn($responseArray);
    }
}
