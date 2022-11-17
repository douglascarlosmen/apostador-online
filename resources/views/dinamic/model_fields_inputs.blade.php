@foreach ($model_fields as $index => $field)
    <div class="row table-field-inputs-div">
        {{-- Field --}}
        <div class="col-md-4">
            <!-- text input -->
            <div class="form-group">
                <label>Field</label>
                <input type="text" class="form-control" name="model_fields[{{ $index }}][field]" readonly value="{{ $field }}">
            </div>
        </div>
        {{-- Is Required --}}
        <div class="col-md-4">
            <!-- select -->
            <div class="form-group">
                <label>Is Required</label>
                <select class="form-control" name="model_fields[{{ $index }}][is_required]" required>
                    <option value="0">no</option>
                    <option value="1">yes</option>
                </select>
            </div>
        </div>
        {{-- Is Email --}}
        <div class="col-md-4">
            <!-- select -->
            <div class="form-group">
                <label>Is Email</label>
                <select class="form-control" name="model_fields[{{ $index }}][is_email]" required>
                    <option value="0">no</option>
                    <option value="1">yes</option>
                </select>
            </div>
        </div>
    </div>
@endforeach
