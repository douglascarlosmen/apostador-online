<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeFormRequest extends Command
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
    protected $signature = 'make:custom-request {model_name} {fields}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um Form Request Customizado';

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
        return base_path('app\\Http\\Requests\\') . '\\' .  $this->argument('model_name') . 'Request.php';
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
        return __DIR__ . '/../../../stubs/custom-form-request.stub';
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
            'REQUEST_NAME'         => $this->argument('model_name'),
            'FIELDS'         => $this->getRequestFields()
        ];
    }

    public function getRequestFields()
    {
        $fields = '';

        foreach (json_decode($this->argument('fields'), true) as $name => $params) {

            $validations = '';

            $fields .= '"' . $name . '" => ';

            if (isset($params['is_required'])) {
                $validations .= '"' . 'required';
                $validations .= isset($params['is_email']) ? '|email' . '",' : '",';
            } else {
                if (isset($params['is_email'])) {
                    $validations .= '"' . 'email' . '",';
                }
            }

            $fields .= $validations;
        }

        return $fields;
    }
}
