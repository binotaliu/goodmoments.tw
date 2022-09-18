<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

final class ListLicenseCommand extends Command
{
    protected $signature = 'license:list';
    protected $description = 'Generate a list of license';

    public function handle(): int
    {
        $this->line('Running licensed...');
        (new Process(['licensed', 'cache']))->run();

        $this->line('Rendering licenses...');
        $files = (new Finder())
            ->in(base_path('.licensed'))
            ->name('*.yml')
            ->files();

        $licensesFileHandler = fopen(resource_path('licenses.html'), 'w+');

        foreach ($files as $file) {
            $license = Yaml::parse($file->getContents());

            fwrite($licensesFileHandler, $this->renderLicense($license));
        }

        fclose($licensesFileHandler);

        $this->info('Successfully generated licenses.html');

        return self::SUCCESS;
    }

    private function renderLicense(array $license): string
    {
        return view('license', $license)->render();
    }
}
