<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeCrudViews extends Command
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
    protected $signature = 'make:crud-views {model_name} {theme_name} {inputs} {table_data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria as blades de crud para uma model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $views_names = ['index', 'create', 'edit', 'show'];

        foreach ($views_names as $view_name) {
            $path = $this->getSourceFilePath($view_name);

            $this->makeDirectory(dirname($path));

            $contents = $this->getSourceFile($view_name);

            if (!$this->files->exists($path)) {
                $this->files->put($path, $contents);

                $this->info("File : {$path} created");
            } else {
                $this->info("File : {$path} already exits");
            }
        }
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath(string $view_name)
    {
        return base_path(
            'resources\\views\\application'
        ) .
            '\\' .
            strtolower(
                $this->argument('model_name') .
                    '\\' .
                    $view_name .
                    '.blade.php'
            );
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
    public function getSourceFile(string $view_name)
    {
        return $this->getStubContents($this->getStubPath($view_name), $this->getStubVariables($view_name));
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
    public function getStubPath(string $view_name)
    {
        $path = __DIR__ . '/../../../stubs/themes/' . $this->argument('theme_name') . '/';


        if ($view_name == 'index') {
            $path .= 'blades/table.stub';
        } else {
            $path .= 'blades/form.stub';
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
    public function getStubVariables(string $view_name)
    {
        if ($view_name == 'index') {
            $stub_variables = [
                'TABLE_HEADER' => $this->argument('model_name') . 's',
                'TABLE_THS' => $this->getTableHeads(),
                'TABLE_TRS'  => $this->getTableRows(),
                'CREATE_BUTTON' => $this->getCreateButton(),
            ];
        } else {
            $stub_variables = [
                'FORM_HEADER' => $this->argument('model_name'),
                'FORM_ACTION' => $this->getFormAction($view_name),
                'FORM_INPUTS' => $this->getFormInputs($view_name),
                'FORM_BUTTON' => $this->getFormButton($view_name),
                'FORM_METHOD' => $this->getFormMethod($view_name),
            ];
        }

        return $stub_variables;
    }

    /**
     * Table functions
     */
    public function getTableHeads()
    {
        $table_heads_string = '';

        foreach (json_decode($this->argument('table_data'), true)['table_heads'] as $head) {
            $table_heads_string .= '<th>' . $head . '</th>' . PHP_EOL;
        }
        $table_heads_string .= '<th> # </th>'.PHP_EOL;

        return $table_heads_string;
    }

    public function getTableRows()
    {
        $table_rows_string = '';
        $lower_model_name = strtolower($this->argument('model_name'));
        $table_rows_string .= "@foreach($" . $lower_model_name . "s as $". $lower_model_name . ")";
        $table_rows_string .= '<tr>';
        foreach (json_decode($this->argument('table_data'), true)['table_rows']['data'] as $row) {
            $table_rows_string .= '<td>{{ $' . $lower_model_name . '->' . $row . ' }}</td>';
        }

        //Action Buttons
        $table_rows_string .= '<td class="d-flex flex-row justify-content-around">' .PHP_EOL.
                            '<a href="/'.$lower_model_name.'/{{$'.$lower_model_name . '->id}}'.'/edit" class="btn btn-sm btn-warning">'.PHP_EOL.
                                'Editar'.PHP_EOL.
                            '</a>'.PHP_EOL.
                            '<form action="/'.$lower_model_name.'/{{$'.$lower_model_name . '->id}}" method="POST">'.PHP_EOL.
                                '@csrf'.PHP_EOL.
                                '@method("delete")'.PHP_EOL.
                                '<button onclick="confirmDelete()" class="btn btn-sm btn-danger">'.PHP_EOL.
                                    'Deletar'.PHP_EOL.
                                '</button>'.PHP_EOL.
                            '</form>'.PHP_EOL.
                    '</td>'.PHP_EOL;

        $table_rows_string .= '</tr>';
        $table_rows_string .= '@endforeach';

        return $table_rows_string;
    }

    public function getCreateButton(){
        $lower_model_name = strtolower($this->argument('model_name'));
        return '<a href="/'.$lower_model_name.'/create" class="btn btn-sm btn-success w-100">'.PHP_EOL.
            'Criar'.PHP_EOL.
        '</a>'.PHP_EOL;
    }

    /**
     * Forms Functions
     */
    public function getFormAction(string $view_name)
    {
        $form_action = '/' . strtolower($this->argument('model_name'));

        if ($view_name == 'edit') {
            $form_action .= '/{{ $' . strtolower($this->argument('model_name')) . '->id }}';
        }

        return $form_action;
    }

    public function getFormInputs(string $view_name)
    {
        $input_string = '';

        foreach (json_decode($this->argument('inputs'), true) as $input_label => $params) {
            $input_string .= $this->getStubContents($this->getInputStubPath($params['input_type']), $this->getInputStubVariables($params['input_type'], $params, $input_label, $view_name));
        }

        return $input_string;
    }

    public function getInputStubPath(string $input_type)
    {
        return __DIR__ . '/../../../stubs/themes/' . $this->argument('theme_name') . '/blades/inputs/' . $input_type . '.stub';
    }

    public function getInputStubVariables(string $input_type, array $params, string $input_label, string $view_name)
    {
        $stub_variables = [
            'INPUT_LABEL' => $input_label,
            'INPUT_NAME'  => $params['input_name'],
            'INPUT_REQUIRED' => isset($params['required']) ? 'required' : '',
            'INPUT_DISABLED' => ''
        ];

        if ($view_name != 'create') {
            $stub_variables['INPUT_VALUE'] = '{{ $' . strtolower($this->argument('model_name')) . '->' . $params['input_name'] . ' }}';
        } else {
            $stub_variables['INPUT_VALUE'] = '';
        }

        if ($input_type == 'text') {
            $stub_variables['INPUT_TYPE'] = $params['input_type'];
        }

        if ($input_type == 'select') {
            $stub_variables['INPUT_OPTIONS'] = $this->getSelectOptions($params['input_options']);
        }

        if ($input_type != 'text' && $input_type != 'select') {
            $stub_variables['INPUT_CHECKED'] = isset($params['input_checked']) ? 'checked' : '';
        }

        if ($view_name == 'show') {
            $stub_variables['INPUT_DISABLED'] = 'disabled';
        }

        return $stub_variables;
    }

    public function getFormButton(string $view_name)
    {
        if ($view_name != 'show') {
            return $this->getStubContents($this->getButtonStubPath(), $this->getButtonStubVariables($view_name));
        }

        return '';
    }

    public function getButtonStubPath()
    {
        return __DIR__ . '/../../../stubs/themes/' . $this->argument('theme_name') . '/blades/box_with_button.stub';
    }

    public function getButtonStubVariables(string $view_name)
    {
        return [
            'BUTTON_TEXT' => $view_name == 'create' ? 'Cadastrar' : 'Atualizar'
        ];
    }

    public function getSelectOptions(array $options)
    {
        $options_string = '';

        foreach ($options as $option) {
            $options_string .=
                '<option value="' .
                $option['value'] .
                '">' .
                $option['label'] .
                '</option>' .
                PHP_EOL;
        }

        return $options_string;
    }

    public function getFormMethod(string $view_name)
    {
        if ($view_name == 'edit') {
            return "@method('put')";
        }
    }
}
