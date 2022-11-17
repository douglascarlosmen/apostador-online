@extends('template.main')

@section('page_header', 'Routes, Controller and FormRequest')

@section('content')

    <form action="/generate-api-integrations" method="POST">
        @csrf
        <!-- APIs box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">APIs</h3>

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
                    <div class="col-md-3">
                        <!-- select -->
                        <div class="form-group">
                            <label>Via CEP</label>
                            <select class="form-control" name="via_cep" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
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
