
$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

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

    var projectList = {
        id: 'projectList',
        column: [
            {
                "data": "id",
                "orderable": false,
                'sortable': false,
                "visible": false,
            },
            {
                "data": "action",
                "orderable": false
            },
            {
                "data": "external_code",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "project_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "sector_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "fund_indication_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "total_fund",
                "orderable": false,
                "render": $.fn.dataTable.render.number('.', ',', 2),
                "className": "text-right"
            },
            {
                "data": "pjp_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "start_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                },
                "className": "text-left"
            },
            {
                "data": "end_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                },
                "className": "text-left"
            },
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    window.projectGrid = new grid(projectList);
    window.projectGrid.url = current_url + "/grid/project_list_v2";
    window.projectGrid.type = 'GET';
    window.projectGrid.init();

    var table = projectGrid.getTablesID();

    table.on('responsive-resize', function (e, datatable, columns) {
        var count = columns.reduce(function (a, b) {
            return b === false ? a + 1 : a;
        }, 0);

        console.log(count + ' column(s) are hidden');
    });

});

$("#createCloseTopModal").on('click', function () {

    $("#openModalCreate").modal('hide');

});

$("#createCloseBottomModal").on('click', function () {

    $("#openModalCreate").modal('hide');

});

var _gridAction = function () {

    $(".view-row").on("click", function () {

        $("#openModalCreate").modal({
            backdrop: "static",
            keyboard: false
        });

        $('#openModalCreate').modal('show');

        var rowdata = window.projectGrid.table.row($(this).parents('tr')).data();

        $('#project-name').text(rowdata.project_name);
        $('#pjp').text(rowdata.pjp_name);
        $('#external-code').text(rowdata.external_code);
        $('#contact-person').text(rowdata.contact_person);
        $('#sector').text(rowdata.sector_name);
        $('#currency').text(rowdata.currency);
        $('#output').text(rowdata.output + ' ' + rowdata.unit_name);

        $('#province-island').text(rowdata.province_name + ', ' + rowdata.island_name);

        var dataOut = [];

        for (var index = 0; index < rowdata.fund_indication_array.length; index++) {

            dataOut += '<span class="label ' + labelColor[index] + '">' + rowdata.fund_indication_array[index].name + '</span> ';

        }

        $('#fund-indication').html(dataOut);
        $('#description').text(rowdata.description);
        $('#status').text(rowdata.status);

        $('#start-date').text(rowdata.start_date);
        $('#transaction-date').text(rowdata.transaction_date);
        $('#construction-date').text(rowdata.construction_date);
        $('#operation-date').text(rowdata.operation_date);
        $('#end-date').text(rowdata.end_date);

        $('#apbnd').text(currencyDollar(rowdata.total_fund_apbnd));
        $('#bumnd').text(currencyDollar(rowdata.total_fund_bumnd));
        $('#swasta').text(currencyDollar(rowdata.total_fund_swasta));
        $('#total').text(currencyDollar(rowdata.total_fund));


    });

}

$('#resumeSubmit').on('click', function () {

    window.projectGrid.data = {
        projectFt: $("#projectOpt").val(),
        sectorFt: $("#sectorOpt").val(),
        pjpFt: $("#pjpOpt").val(),
    };

    window.projectGrid.table.draw();

});

// $('#resumeSubmit').on('click', function () {

//     var myAjax = new ajax();
//     myAjax.url = current_url + '/ajax/' + 'project_list';
//     myAjax.async = false;
//     myAjax.data = {
//         projectId: $('#projectOpt').val(),
//         pjpId: $('#pjpOpt').val(),
//         sectorId: $('#sectorOpt').val(),
//     };
//     myAjax.callback = _actionCallback;
//     myAjax.init();

// });

var labelColor = [
    'label-danger',
    'label-success',
    'label-info',
    'label-warning',
    'label-primary',
    'label-default',
];

_actionCallback = function (data, status, xhr) {

    try {
        
        var data = JSON.parse(data);
        
        if (xhr.status == 200) {

            if (data.status == true) {

                console.log(data.data);

                $('#project-name').text(data.data.project_name);
                $('#pjp').text(data.data.pjp_name);
                $('#external-code').text(data.data.external_code);
                $('#contact-person').text(data.data.contact_person);
                $('#sector').text(data.data.sector_name);
                $('#currency').text(data.data.currency);
                $('#output').text(data.data.output + ' ' + data.data.unit_name);

                $('#province-island').text(data.data.province_name + ', ' + data.data.island_name);
                
                var dataOut = [];

                for (var index = 0; index < data.data.fund_indication_array.length; index++) {

                    dataOut += '<span class="label ' + labelColor[index] + '">' + data.data.fund_indication_array[index].name + '</span> ';
                    
                }

                $('#fund-indication').html(dataOut);
                $('#description').text(data.data.description);
                $('#status').text(data.data.status);

                $('#start-date').text(data.data.start_date);
                $('#transaction-date').text(data.data.transaction_date);
                $('#construction-date').text(data.data.construction_date);
                $('#operation-date').text(data.data.operation_date);
                $('#end-date').text(data.data.end_date);

                $('#apbnd').text( currencyDollar(data.data.total_fund_apbnd) );
                $('#bumnd').text( currencyDollar(data.data.total_fund_bumnd) );
                $('#swasta').text( currencyDollar(data.data.total_fund_swasta) );
                $('#total').text( currencyDollar(data.data.total_fund) );

            } else {

                alert(data.message);
                
            }
        
        } else {

            alert((data.message == "" ? "Check your input" : data.message));
        
        }
        
    } catch (error) {
        
        alert(JSON.stringify(error));
    
    }
    
};

var currencyDollar = function (number) {
    var number = number.toString(),
        dollars = number.split('.')[0],
        cents = (number.split('.')[1] || '') + '00';
    dollars = dollars.split('').reverse().join('')
        .replace(/(\d{3}(?!$))/g, '$1.')
        .split('').reverse().join('');
    return 'Rp. ' + dollars + ',' + cents.slice(0, 2);
}

