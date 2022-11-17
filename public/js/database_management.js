// Migration
var tableFieldIndex = 1;

function addTableFieldDiv() {
    $.ajax({
        url: '/add-table-field-row?index=' + tableFieldIndex,
        success: function (response) {
            $('#table-fields-div').append(response.html);
            tableFieldIndex++;
        }
    });
}

function removeTableFieldDiv() {
    tableFieldIndex--;
    $(this).closest('.table-field-inputs-div').remove();
}

function handleIsFkSelectChange() {
    var $this = $(this),
        fkToFieldDiv = $this.closest('.table-field-inputs-div').find('.fk-to-field-div');

    if ($this.val() == 1) {
        fkToFieldDiv.find('select').prop('required', true).val('').trigger('change');
        fkToFieldDiv.show();
    } else {
        fkToFieldDiv.hide();
        fkToFieldDiv.find('select').prop('required', false).val('').trigger('change')
    }
}

// Model
var modelRelationIndex = 1;

function addModelRelationDiv() {
    $.ajax({
        url: '/add-model-relation-row?index=' + modelRelationIndex,
        success: function (response) {
            $('#model-relations-div').append(response.html);
            modelRelationIndex++;
        }
    });
}

function removeModelRelationDiv() {
    modelRelationIndex--;
    $(this).closest('.model-relation-inputs-div').remove();
}
