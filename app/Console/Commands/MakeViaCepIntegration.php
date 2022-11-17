<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeViaCepIntegration extends Command
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
    protected $signature = 'make:via-cep-integration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria as classes necessárias para integração via cep';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller_path = $this->getControllerSourceFilePath();
        $route_path = $this->getRouteSourceFilePath();
        $service_path = $this->getServiceSourceFilePath();

        $this->makeDirectory(dirname($controller_path));
        $this->makeDirectory(dirname($route_path));
        $this->makeDirectory(dirname($service_path));

        if (!$this->files->exists($controller_path)) {
            $controller_contents = $this->getSourceFile('controller');
            $this->files->put($controller_path, $controller_contents);
            $this->info("File : {$controller_path} created");
        } else {
            $this->info("File : {$controller_path} already exits");
        }

        if (!$this->files->exists($route_path)) {
            $route_contents = $this->getSourceFile('route');
            $this->files->put($route_path, $route_contents);
            $this->info("File : {$route_path} created");
        } else {
            $this->info("File : {$route_path} already exits");
        }

        if (!$this->files->exists($service_path)) {
            $service_contents = $this->getSourceFile('service');
            $this->files->put($service_path, $service_contents);
            $this->info("File : {$service_path} created");
        } else {
            $this->info("File : {$service_path} already exits");
        }
    }

    public function getControllerSourceFilePath()
    {
        return base_path('app\\Http\\Controllers') . '\\' .  'ViaCepApiController.php';
    }

    public function getRouteSourceFilePath()
    {
        return base_path('routes') . '\\' .  'via_cep.php';
    }

    public function getServiceSourceFilePath()
    {
        return base_path('app\\Services') . '\\' .  'ViaCepService.php';
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
    public function getSourceFile(string $type)
    {
        return $this->getStubContents($this->getStubPath($type), $this->getStubVariables());
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
    public function getStubPath(string $type)
    {
        $path = __DIR__ . '/../../../stubs/ViaCep/';

        if ($type == 'controller') {
            $path .= 'via-cep-controller.stub';
        }

        if ($type == 'route') {
            $path .= 'via-cep-route.stub';
        }

        if ($type == 'service') {
            $path .= 'via-cep-service.stub';
        }

        return $path;
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
        return [];
    }
}
