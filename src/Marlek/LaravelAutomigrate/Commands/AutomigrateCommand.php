<?php namespace Marlek\LaravelAutomigrate\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Marlek\LaravelAutomigrate\CommandGenerator;

class AutomigrateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'automigrate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run multiple migrations automatically.';

	protected $commandGenerator;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(CommandGenerator $commandGenerator)
	{
		parent::__construct();
		$this->commandGenerator = $commandGenerator;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$commands = $this->commandGenerator->generateCommands();

		$this->call('migrate:reset');
		foreach ($commands as $command)
		{
			$this->call('migrate', $command);
		}

		/**
		 * If --seed is passed we run the seed command
		 */
		if ($this->input->getOption('seed'))
		{
			$this->call('db:seed');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be run after migrations.'),
		);
	}

}
