
var formId = false;

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    var unitList = {
        id: 'unitList',
        column: [
            {
                "data": "action",
                "orderable": false
            },
            {
                "data": "unit_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "simbol",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "description",
                "orderable": false,
                "className": "text-left"
            }
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    window.unitGrid = new grid(unitList);
    window.unitGrid.url = current_url + "/grid/unit_list";
    window.unitGrid.type = 'GET';
    window.unitGrid.init();

    var table = unitGrid.getTablesID();

});

$('#createUnit').on('click', function () {

    formId = false;

    $('#openModalCreate').modal('show');

    $('#unitId').val('');
    $('#unitName').val('');
    $('#simbol').val('');
    $('#description').val('');

});

var _gridAction = function () {

    $(".update-row").on("click", function () {

        $('#openModalCreate').modal('show');

        formId = true;

        var rowdata = window.unitGrid.table.row($(this).parents('tr')).data();

        $('#unitId').val(rowdata.id);
        $('#unitName').val(rowdata.unit_name);
        $('#simbol').val(rowdata.simbol);
        $('#description').val(rowdata.description);

    });

    $(".delete-row").on("click", function () {

        formId = false;

        var rowdata = window.unitGrid.table.row($(this).parents('tr')).data();

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_unit';
        myAjax.async = false;
        myAjax.data = {
            id: rowdata.id,
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

}

$('#saveUnit').on('click', function () {

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-unit').each(function (index, element) {

        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {

            stopProcessing = true;

        }

    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = (formId == false) ? 'create_unit' : 'update_unit';

        _actionInsert($(this).parents('form'), 'Administration/Unit/ajax/' + action_url, '.insert-unit');

    }

});

_actionInsert = function (element, url, class_identity) {

    var dataset = {};
    var i = 0;

    $(element).find(class_identity).each(function (index, element) {

        i++;
        var value = [];
        if ($(this).attr('name') !== undefined) {
            var key = $(this).attr('name');
            var ids = $(this).attr('ids');
            if ($(this).attr('ids') !== undefined) {
                if ($(this).attr("type") == "hidden") {
                    dataset[key] = $(this).val();
                } else {
                    dataset[key] = $(this).val();
                }
            } else {
                dataset[key] = $(this).val();
            }
        }

    });

    // console.log(dataset);

    // return false;
    _postToAJax(dataset, url);

};

_postToAJax = function (param, url) {

    var myAjax = new ajax();
    myAjax.url = base_url + url;
    myAjax.async = false;
    myAjax.data = param;
    myAjax.timeout = 10000;
    myAjax.callback = _actionCallback;
    myAjax.init();

};

_actionCallback = function (data, status, xhr) {
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status == 200) {

            alert(data.message);

            $('#openModalCreate').modal('hide');

            window.unitGrid.table.draw();
            $('#unitForm')[0].reset();

        } else if (data.status == 500) {

            alert(data.message);

        } else {

            alert(data.message);

            window.unitGrid.table.draw();

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

