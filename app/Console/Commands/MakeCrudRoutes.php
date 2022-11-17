<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeCrudRoutes extends Command
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
    protected $signature = 'make:crud-routes {model_name} {controller_name} {middleware?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um arquivo de rotas de crud para uma model';

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
        return base_path('routes') . '\\' .  strtolower($this->argument('model_name')) . '.php';
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
        return __DIR__ . '/../../../stubs/custom-routes.stub';
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
        return [
            'IMPORT_CONTROLLER' => 'App\Http\Controllers\\' . $this->argument('controller_name'),
            'ROUTES' => $this->getRoutes()
        ];
    }

    public function getRoutes()
    {
        $route_name = strtolower($this->argument('model_name'));
        $controller_class = $this->argument('controller_name') . '::class';
        $middleware = $this->argument('middleware') ? '->middleware("' . $this->argument('middleware') . '")' : '';

        return "Route::resource('$route_name', $controller_class)$middleware;";
    }
}
