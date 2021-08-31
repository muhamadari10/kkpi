
var formId = false;

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    var islandList = {
        id: 'islandList',
        column: [
            {
                "data": "action",
                "orderable": false
            },
            {
                "data": "island_name",
                "orderable": false,
                "className": "text-left"
            }
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    window.islandGrid = new grid(islandList);
    window.islandGrid.url = current_url + "/grid/island_list";
    window.islandGrid.type = 'GET';
    window.islandGrid.init();

    var table = islandGrid.getTablesID();

});

$('#createIsland').on('click', function () {

    formId = false;

    $('#openModalCreate').modal('show');

    $('#islandId').val('');
    $('#islandName').val('');

});

var _gridAction = function () {

    $(".update-row").on("click", function () {

        $('#openModalCreate').modal('show');

        formId = true;

        var rowdata = window.islandGrid.table.row($(this).parents('tr')).data();

        $('#islandId').val(rowdata.id);
        $('#islandName').val(rowdata.island_name);

    });

    $(".delete-row").on("click", function () {

        formId = false;

        var rowdata = window.islandGrid.table.row($(this).parents('tr')).data();

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_island';
        myAjax.async = false;
        myAjax.data = {
            id: rowdata.id,
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

}

$('#saveIsland').on('click', function () {

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-island').each(function (index, element) {

        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {

            stopProcessing = true;

        }

    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = (formId == false) ? 'create_island' : 'update_island';

        _actionInsert($(this).parents('form'), 'Administration/Island/ajax/' + action_url, '.insert-island');

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

            window.islandGrid.table.draw();
            $('#islandForm')[0].reset();

        } else if (data.status == 500) {

            alert(data.message);

        } else {

            alert(data.message);

            window.islandGrid.table.draw();

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

