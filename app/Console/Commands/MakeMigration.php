<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeMigration extends Command
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
    protected $signature = 'make:custom-migration {table} {fields} {--softdelete} {--model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma Migration Customizada';

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
        return base_path('database\\migrations') . '\\' . date('Y') . '_' . date('m') . '_' . date('d') . '_' . date('H') . date('i') . date('s') . '_create_' . $this->argument('table') . '_table.php';
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
        return __DIR__ . '/../../../stubs/custom-migration.stub';
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
            'TABLE_NAME'         => $this->argument('table'),
            'TABLE_FIELDS'       => $this->getMigrationFields($this->argument('fields')),
            'TABLE_SOFTDELETES'  => $this->getMigrationSoftDelete(),
        ];
    }

    public function getMigrationFields()
    {
        $fields = '';

        foreach (json_decode($this->argument('fields'), true) as $name => $params) {

            $field = '$table->' . $params['type'] . "('";

            if ($params['type'] == 'enum') {
                $field .= "$name', " . $params['enum_options'] . ")";
            } else {
                $field .= "$name')";
            }

            if (isset($params['nullable'])) {
                $field .= '->nullable()';
            }

            if (isset($params['default'])) {
                $field .= '->default(' . $params['default'] . ')';
            }

            $field .= ';' . PHP_EOL;

            if (isset($params['fk_to'])) {
                $field .= '$table->foreign("' . $name . '")->references("id")->on("' . $params['fk_to'] . '");' . PHP_EOL;
            }

            $fields .= $field;
        }

        return $fields;
    }

    public function getMigrationSoftDelete()
    {
        $string = '';

        if ($this->option('softdelete')) {
            $string = '$table->softDeletes();';
        }

        return $string;
    }
}
