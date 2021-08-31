
var formId = false;
dataIn = '';
tableOut = '';

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    //Date picker
    $('#startActualDate').datepicker({
        autoclose: true
    });

    $('#startPlanDate').datepicker({
        autoclose: true
    });

    //Date picker
    $('#endActualDate').datepicker({
        autoclose: true
    });

    $('#endPlanDate').datepicker({
        autoclose: true
    });

    $("#projectFilter").select2({
        ajax: {
            url: current_url + "/ajax/project_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Proyek',
    });


    $("#pjpFilter").select2({
        ajax: {
            url: current_url + "/ajax/pjp_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'PJP',
    });

    $("#sectorFilter").select2({
        ajax: {
            url: current_url + "/ajax/sector_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Sektor',
    });


    $("#projectOpt").select2({
        ajax: {
            url: current_url + "/ajax/project_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Proyek',
    });


    $("#pjpOpt").select2({
        ajax: {
            url: current_url + "/ajax/pjp_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'PJP',
    });

    $("#sectorOpt").select2({
        ajax: {
            url: current_url + "/ajax/sector_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Sektor',
    });

    var scheduleList = {
        id: 'scheduleList',
        column: [
            {
                "data": "action",
                "orderable": false
            },
            {
                "data": "schedule_activity_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "schedule_status",
                "orderable": false
            },
            {
                "data": "start_plan_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "start_actual_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }

            },
            {
                "data": "deviation",
                "orderable": false
            },
            {
                "data": "end_actual_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }

            },
            {
                "data": "end_plan_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }

            }
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    window.scheduleGrid = new grid(scheduleList);
    window.scheduleGrid.url = current_url + "/grid/schedule_list";
    window.scheduleGrid.type = 'GET';
    window.scheduleGrid.init();

    var table = scheduleGrid.getTablesID();

});

$('#scheduleFilter').on('click', function () {

    window.scheduleGrid.data = {
        projectFt: $("#projectFilter").val(),
        pjpFt: $("#pjpFilter").val(),
        sectorFt: $("#sectorFilter").val(),
    };
    
    window.scheduleGrid.table.draw();

});


$('#createSchedule').on('click', function () {

    formId = false;

    $('#openModalCreate').modal('show');

    $('#scheduleId').val('');
    $('#projectOpt').val('').trigger('change');
    $('#pjpOpt').val('').trigger('change');
    $('#sectorOpt').val('').trigger('change');
    $('#scheduleActivityName').val('');
    $('#scheduleStatus').val('');
    $('#startPlanDate').val('');
    $('#startActualDate').val('');
    $('#deviation').val('');
    $('#endActualDate').val('');
    $('#endPlanDate').val('');


});

var _gridAction = function () {

    $(".update-row").on("click", function () {

        $('#openModalCreate').modal('show');

        formId = true;

        var rowdata = window.scheduleGrid.table.row($(this).parents('tr')).data();

        $('#scheduleId').val(rowdata.id);
        $('#projectOpt').val('').trigger('change');
        $('#pjpOpt').val('').trigger('change');
        $('#sectorOpt').val('').trigger('change');
        $('#scheduleActivityName').val(rowdata.schedule_activity_name);
        $('#scheduleStatus').val(rowdata.schedule_status);
        $('#startPlanDate').val(rowdata.start_plan_date);
        $('#startActualDate').val(rowdata.start_actual_date);
        $('#deviation').val(rowdata.deviation);
        $('#endActualDate').val(rowdata.end_actual_date);
        $('#endPlanDate').val(rowdata.end_plan_date);

    });

    $(".delete-row").on("click", function () {

        formId = false;

        var rowdata = window.scheduleGrid.table.row($(this).parents('tr')).data();

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_schedule';
        myAjax.async = false;
        myAjax.data = {
            id: rowdata.id,
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

}

$('#saveSchedule').on('click', function () {

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-schedule').each(function (index, element) {

        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {

            stopProcessing = true;

        }

    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = (formId == false) ? 'create_schedule' : 'update_schedule';

        _actionInsert($(this).parents('form'), 'Project/Schedule/ajax/' + action_url, '.insert-schedule');

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

            window.scheduleGrid.table.draw();
            $('#scheduleForm')[0].reset();

        } else if (data.status == 500) {

            alert(data.message);

        } else {

            alert(data.message);

            window.scheduleGrid.table.draw();

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

