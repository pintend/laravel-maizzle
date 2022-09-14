<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MaizzleCompile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maizzle:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proof of concept to compile blade views through maizzle';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = resource_path('views/emails/example.blade.php');

        $compiled = Blade::compileString(file_get_contents($file));

        $maizzle = <<<MAIZZLE
// https://maizzle.com/docs/api#options
const Maizzle = require('@maizzle/framework')

const options = require('./maizzle.config.js');

Maizzle
    .render(String.raw`$compiled`, options)
    .then(({html}) => console.log(html))
    .catch(error => console.log(error));

MAIZZLE;

        $process = new Process(['node', '-e', $maizzle]);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $bladeTemplate = $process->getOutput();

        $this->output->write(Blade::render($bladeTemplate, deleteCachedView: true));

        return 0;
    }
}
