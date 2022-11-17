<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeController extends Command
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:custom-controller {controller_name} {model} {--api}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um Controller Customizado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app\\Http\\Controllers') . '\\' .  $this->argument('controller_name') . '.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../stubs/' . ($this->option('api') ? 'custom-api-controller.stub' : 'custom-web-controller.stub');
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        $variables = [
            'CONTROLLER_NAME'    => $this->argument('controller_name'),
            'MODEL_NAME'         => $this->argument('model'),
            'SINGULAR_PHP_VAR'     => '$' . strtolower($this->argument('model'))
        ];

        if (!$this->option('api')) {

            $lower_model_name = strtolower($this->argument('model'));
            $variables['SINGULAR_VIEW_VAR'] = $lower_model_name;
            $variables['PLURAL_VIEW_VAR'] = $lower_model_name . 's';
            $variables['LOWER_MODEL_NAME'] = $lower_model_name;
        }

        return $variables;
    }
}
