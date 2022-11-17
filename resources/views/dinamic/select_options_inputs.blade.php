<div class="row select-options-inputs-div">
    {{-- Option Value --}}
    <div class="col-md-4">
        <!-- text input -->
        <div class="form-group">
            <label>Option Value</label>
            <input type="text" name="form_fields[{{ $field_index }}][select_option][{{ $index }}][value]" class="form-control" required
                placeholder="Enter...">
        </div>
    </div>
    {{-- Option Label --}}
    <div class="col-md-4">
        <!-- text input -->
        <div class="form-group">
            <label>Option Label</label>
            <input type="text" name="form_fields[{{ $field_index }}][select_option][{{ $index }}][label]" class="form-control" required
                placeholder="Enter...">
        </div>
    </div>
    {{-- Button Remove Option --}}
    <div class="col-md-4 pt-4">
        <button type="button" class="btn btn-block btn-danger mt-2 remove-option-button">Remove Option <i
                class="fa fa-minus"></i></button>
    </div>

</div>
