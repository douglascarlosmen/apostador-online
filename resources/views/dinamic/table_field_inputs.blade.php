<div class="row table-field-inputs-div">
    {{-- Column Name --}}
    <div class="col-md-2">
        <!-- text input -->
        <div class="form-group">
            <label>Column Name</label>
            <input type="text" name="table_fields[{{$index}}][name]" class="form-control" required placeholder="Enter...">
        </div>
    </div>
    {{-- Column Type --}}
    <div class="col-md-2">
        <!-- select -->
        <div class="form-group">
            <label>Column Type</label>
            <select class="form-control" name="table_fields[{{$index}}][type]" required>
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
            <select class="form-control" name="table_fields[{{$index}}][nullable]" required>
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
            <input type="text" class="form-control" name="table_fields[{{$index}}][default]" placeholder="Enter...">
        </div>
    </div>
    {{-- Column Is Foreign Key --}}
    <div class="col-md-1">
        <!-- select -->
        <div class="form-group">
            <label>Is F.K.</label>
            <select class="form-control is-fk-field-select" name="table_fields[{{$index}}][is_fk]" required>
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
            <select class="form-control" name="table_fields[{{$index}}][fk_to]">
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
