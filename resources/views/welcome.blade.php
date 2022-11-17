@extends('template.main')

@section('page_header', 'Database Management')

@section('content')

    <form action="/generate-migration-and-model" method="POST">
        @csrf
        <!-- Migration box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Migration</h3>

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
                        <!-- text input -->
                        <div class="form-group">
                            <label>Table Name</label>
                            <input type="text" name="table_name" class="form-control" placeholder="Enter..." required>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-1">
                        <h4>Table Fields</h4>
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="add-field-button" class="btn btn-block btn-success btn-sm">Add Field <i
                                class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div id="table-fields-div">
                    <div class="row table-field-inputs-div">
                        {{-- Column Name --}}
                        <div class="col-md-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Column Name</label>
                                <input type="text" name="table_fields[0][name]" class="form-control" required
                                    placeholder="Enter...">
                            </div>
                        </div>
                        {{-- Column Type --}}
                        <div class="col-md-2">
                            <!-- select -->
                            <div class="form-group">
                                <label>Column Type</label>
                                <select class="form-control" name="table_fields[0][type]" required>
                                    <option value="integer">integer</option>
                                    <option value="decimal">decimal</option>
                                    <option value="unsignedBigInteger">unsignedBigInteger</option>
                                    <option value="string">string</option>
                                    <option value="text">text</option>
                                    <option value="longText">longText</option>
                                    <option value="boolean">boolean</option>
                                    <option value="date">date</option>
                                    <option value="time">time</option>
                                    <option value="dateTime">dateTime</option>
                                    <option value="timestamp">timestamp</option>
                                </select>
                            </div>
                        </div>
                        {{-- Column Nullable --}}
                        <div class="col-md-1">
                            <!-- select -->
                            <div class="form-group">
                                <label>Is Null</label>
                                <select class="form-control" name="table_fields[0][nullable]" required>
                                    <option>no</option>
                                    <option>yes</option>
                                </select>
                            </div>
                        </div>
                        {{-- Column Default Value --}}
                        <div class="col-md-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Default Value</label>
                                <input type="text" class="form-control" name="table_fields[0][default]"
                                    placeholder="Enter...">
                            </div>
                        </div>
                        {{-- Column Is Foreign Key --}}
                        <div class="col-md-1">
                            <!-- select -->
                            <div class="form-group">
                                <label>Is F.K.</label>
                                <select class="form-control is-fk-field-select" name="table_fields[0][is_fk]" required>
                                    <option value=0>no</option>
                                    <option value=1>yes</option>
                                </select>
                            </div>
                        </div>
                        {{-- Column FK TO --}}
                        <div class="col-md-2 fk-to-field-div" style="display: none;">
                            <!-- select -->
                            <div class="form-group">
                                <label>F.K To</label>
                                <select class="form-control" name="table_fields[0][fk_to]">
                                    <option value="">Select ....</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table }}">{{ $table }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Button Remove Field --}}
                        <div class="col-md-2 pt-4">
                            <button type="button" class="btn btn-block btn-danger mt-2 remove-field-button">Remove Field <i
                                    class="fa fa-minus"></i></button>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="softdelete">
                                <label class="custom-control-label" for="customSwitch1">Add SoftDelete Column</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Model box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Model</h3>

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
                        <!-- text input -->
                        <div class="form-group">
                            <label>Model Name</label>
                            <input required type="text" name="model_name" class="form-control"
                                placeholder="Enter..." required>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-1">
                        <h4>Relations</h4>
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="add-relation-button" class="btn btn-block btn-success btn-sm">Add
                            Relation <i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div id="model-relations-div">
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
    <script src="{{ asset('js/database_management.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#add-field-button').on('click', addTableFieldDiv);
            $('body').on('click', '.remove-field-button', removeTableFieldDiv);
            $('body').on('change', '.is-fk-field-select', handleIsFkSelectChange);

            $('#add-relation-button').on('click', addModelRelationDiv);
            $('body').on('click', '.remove-relation-button', removeModelRelationDiv);
        });
    </script>
@endsection
