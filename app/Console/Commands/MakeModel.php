<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeModel extends Command
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
    protected $signature = 'make:custom-model {model_name} {table} {fields} {relationships?} {--softdelete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma Model Customizada';

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
        return base_path('app\\Models') . '\\' .  $this->argument('model_name') . '.php';
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
        return __DIR__ . '/../../../stubs/custom-model.stub';
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
            'MODEL_NAME'         => $this->argument('model_name'),
            'TABLE_NAME'         => $this->argument('table'),
            'MODEL_FILLABLE'       => $this->getModelFillable($this->argument('fields')),
            'SOFTDELETE_IMPORT'  => $this->getModelSoftDeleteImport(),
            'USE_SOFTDELETE' => $this->getModelUseSoftDelete(),
            'MODEL_RELATIONSHIPS' => $this->getModelRelationships()
        ];
    }

    public function getModelFillable()
    {
        $fields = '';

        foreach (json_decode($this->argument('fields'), true)['fields'] as $field) {
            $fields .= '"' . $field . '",';
        }

        return $fields;
    }

    public function getModelSoftDeleteImport()
    {
        $string = '';

        if ($this->option('softdelete')) {
            $string = 'use Illuminate\Database\Eloquent\SoftDeletes;';
        }

        return $string;
    }

    public function getModelUseSoftDelete()
    {
        $string = '';

        if ($this->option('softdelete')) {
            $string = ', SoftDeletes';
        }

        return $string;
    }

    public function getModelRelationships()
    {
        $relationships = '';

        if ($this->argument('relationships')) {
            foreach (json_decode($this->argument('relationships'), true) as $name => $params) {

                $relationships .= 'public function ' .
                    $name .
                    '() { return $this->' .
                    $params['type'] .
                    '(' .
                    $params['related_to'] .
                    ', ' .
                    '"' . $params['foreign_key'] . '"' .
                    '); }' .
                    PHP_EOL;
            }
        }

        return $relationships;
    }
}
