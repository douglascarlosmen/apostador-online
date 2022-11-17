<div class="row model-relation-inputs-div">
    {{-- Relation Name --}}
    <div class="col-md-3">
        <!-- text input -->
        <div class="form-group">
            <label>Relation Name</label>
            <input type="text" name="relations[{{$index}}][relation_name]" class="form-control" required placeholder="Enter...">
        </div>
    </div>
    {{-- Relation Type --}}
    <div class="col-md-2">
        <!-- select -->
        <div class="form-group">
            <label>Relation Type</label>
            <select class="form-control" name="relations[{{$index}}][relation_type]" required>
                <option value="belongsTo">belongsTo</option>
                <option value="belongsToMany">belongsToMany</option>
                <option value="hasMany">hasMany</option>
                <option value="hasOne">hasOne</option>
            </select>
        </div>
    </div>
    {{-- Relates To --}}
    <div class="col-md-2">
        <!-- select -->
        <div class="form-group">
            <label>Relates To</label>
            <select class="form-control" name="relations[{{$index}}][relates_to]" required>
                <option value="">Select ...</option>
                @foreach ($models as $model)
                    <option value="{{ $model }}">{{ $model }}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{-- Foreing Key --}}
    <div class="col-md-2">
        <!-- text input -->
        <div class="form-group">
            <label>Foreing Key</label>
            <input type="text" name="relations[{{$index}}][fk]" class="form-control" required placeholder="Enter...">
        </div>
    </div>
    {{-- Button Remove Relation --}}
    <div class="col-md-3 pt-4">
        <button type="button" class="btn btn-block btn-danger mt-2 remove-relation-button">Remove
            Relation <i class="fa fa-minus"></i></button>
    </div>
</div>
