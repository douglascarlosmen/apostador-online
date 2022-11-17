function handleModelSelectChange() {
    var $this = $(this),
        modelName = $this.val();
    $('#model-fields').html('');
    $('#model-form-fields').html('');

    if ($this.val() != '') {
        $.ajax({
            url: '/get-model-fields?model_name=' + modelName,
            success: function (response) {
                $('#model-fields').append(response.validation_html);
                $('#model-form-fields').append(response.form_html);
            }
        });
    }
}

function handleApiControllerSelectChange() {
    var $this = $(this);

    if ($this.is(':checked')) {
        $('#form-fields-card').hide();
    } else {
        $('#form-fields-card').show();
    }
}

function handleFormFieldInputTypeChange() {

    var $this = $(this);

    if ($this.val() == 'select') {
        $this.closest('.form-field-inputs-div').find('.select-options-div').show();
    } else {
        $this.closest('.form-field-inputs-div').find('.select-options-div').hide();
    }
}

var selectOptionsIndex = 0;

function handleAddSelectOptionClick() {

    var $this = $(this);

    $.ajax({
        url: '/get-select-options-inputs?index=' + selectOptionsIndex + '&field_index=' + $this.data('index'),
        success: function (response) {
            $this.closest('.select-options-div').find('.select-options-inputs-list').append(response.html);
            selectOptionsIndex++;
        }
    });
}

function handleRmoveSelectOptionClick() {
    $(this).closest('.select-options-inputs-div').remove();
    selectOptionsIndex--;
}
