<?php

namespace MichaelNabil230\LaravelQueryConditions\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-query-conditions:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the LaravelQueryConditions resources';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->installVueStack();

        return self::SUCCESS;
    }

    /**
     * Install the Vue LaravelQueryConditions stack.
     *
     * @return void
     */
    protected function installVueStack()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                "tailwindcss" => "^3.1.4",
                "@tailwindcss/forms" => "^0.5.2",
                "postcss" => "^8.4.14",
                "vue" => "^2.5.17",
            ] + $packages;
        });

        // Components...
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Components'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/vue/resources/js/Components', resource_path('js/Components'));

        // Tailwind...
        copy(__DIR__ . '/../../stubs/default/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__ . '/../../stubs/default/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__ . '/../../stubs/common/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . '/../../stubs/vue/resources/js/app.js', resource_path('js/app.js'));

        $this->info('LaravelQueryConditions scaffolding installed successfully.');

        $this->comment('Please execute the "npm install" && "npm run dev" commands to build your assets.');
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }
}
