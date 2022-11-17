@extends('template.main')

@section('page_header', 'Routes, Controller and FormRequest')

@section('content')

    <form action="/generate-routes-controller-request" method="POST">
        @csrf

         <!-- Routes box -->
         <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tema</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- select -->
                        <div class="form-group">
                            <label>Escolha o tema</label>
                            <select class="form-control" name="theme_name" required>
                                <option value="">Select ...</option>
                                <option value="adminlte3">AdminLTE3</option>
                                <option value="powerbi_vertical">PowerBi Vertical</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

        <!-- Routes box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Routes</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- select -->
                        <div class="form-group">
                            <label>CRUD Routes to Model</label>
                            <select class="form-control" id="model-select" name="model_name" required>
                                <option value="">Select ...</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model }}">{{ $model }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Validation box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Fields Validation</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" id="model-fields">

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Controller box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Controller</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch3"
                                    name="generate_api_controller">
                                <label class="custom-control-label" for="customSwitch3">Generate API Controller</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Form box -->
        <div class="card" id="form-fields-card">
            <div class="card-header">
                <h3 class="card-title">Form Fields</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" id="model-form-fields">

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

        <!-- Default box -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-info">Create</button>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </form>

@endsection

@section('scripts')
    <script src="{{ asset('js/route_controller_management.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#model-select').on('click', handleModelSelectChange);
            $('#customSwitch3').on('change', handleApiControllerSelectChange);
            $('body').on('click', '.form-field-input-type', handleFormFieldInputTypeChange);
            $('body').on('click', '.add-select-option', handleAddSelectOptionClick);
            $('body').on('click', '.remove-option-button', handleRmoveSelectOptionClick);

        });
    </script>
@endsection
