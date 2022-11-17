@foreach ($model_fields as $index => $field)
    <div class="form-field-inputs-div">
        <div class="row">
            {{-- Field --}}
            <div class="col-md-3">
                <!-- text input -->
                <div class="form-group">
                    <label>Field</label>
                    <input type="text" class="form-control" name="form_fields[{{ $index }}][field]" readonly
                        value="{{ $field }}">
                </div>
            </div>
            {{-- Input Type --}}
            <div class="col-md-3">
                <!-- select -->
                <div class="form-group">
                    <label>Input Type</label>
                    <select class="form-control form-field-input-type"
                        name="form_fields[{{ $index }}][input_type]" required>
                        <option value="text">Text</option>
                        <option value="select">Select</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="switch">Switch</option>
                        <option value="radio">Radio</option>
                    </select>
                </div>
            </div>
            {{-- Is Required --}}
            <div class="col-md-3">
                <!-- select -->
                <div class="form-group">
                    <label>Is Required</label>
                    <select class="form-control form-field-input-type"
                        name="form_fields[{{ $index }}][is_required]" required>
                        <option value="0">no</option>
                        <option value="1">yes</option>
                    </select>
                </div>
            </div>
            {{-- Show in Index --}}
            <div class="col-md-3">
                <!-- select -->
                <div class="form-group">
                    <label>Show in Index</label>
                    <select class="form-control form-field-input-type"
                        name="form_fields[{{ $index }}][show_in_index]" required>
                        <option value="0">no</option>
                        <option value="1">yes</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row select-options-div" style="display: none;">
            <div class="col-md-2">
                <h4>Select Options</h4>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-block btn-success btn-sm add-select-option" data-index="{{ $index }}">Add Option <i
                        class="fa fa-plus"></i></button>
            </div>
            <div class="col-md-12 select-options-inputs-list">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
@endforeach
