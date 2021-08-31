
var formId = false;
var formProjectId = false;
dataIn = '';
tableOut = '';

var formStatus = true;


$(document).ajaxStart(function () {
    Pace.restart();
});

$(document).ready(function () {

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


    $("#statusCodeFilter").select2({
        ajax: {
            url: current_url + "/ajax/status_code_option",
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
        placeholder: 'Kode Status',
    });

    //Date picker
    $('#startDate').datepicker({
        autoclose: true
    })
    $('#transactionDate').datepicker({
        autoclose: true
    })
    $('#constructionDate').datepicker({
        autoclose: true
    })
    $('#operationDate').datepicker({
        autoclose: true
    })
    $('#endDate').datepicker({
        autoclose: true
    })

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

    $("#fundIndicationOpt").select2({
        ajax: {
            url: current_url + "/ajax/fund_indication_option",
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
        placeholder: 'Indikasi Dana',
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
        placeholder: 'Pjp',
    });

    
    $("#statusCodeOpt").select2({
        ajax: {
            url: current_url + "/ajax/status_code_option",
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
        placeholder: 'Kode Status',
    });

    $("#provinceOpt").select2({
        ajax: {
            url: current_url + "/ajax/province_option",
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
        placeholder: 'Provinsi',
    });

    $("#islandOpt").select2({
        ajax: {
            url: current_url + "/ajax/island_option",
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
        placeholder: 'Pulau',
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

    $("#unitOpt").select2({
        ajax: {
            url: current_url + "/ajax/unit_option",
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
        placeholder: 'Unit',
    }); 

    // multi project

    //Date picker
    $('#startDateMul').datepicker({
        autoclose: true
    })
    $('#transactionDateMul').datepicker({
        autoclose: true
    })
    $('#constructionDateMul').datepicker({
        autoclose: true
    })
    $('#operationDateMul').datepicker({
        autoclose: true
    })
    $('#endDateMul').datepicker({
        autoclose: true
    })
    $('#signatureDateMul').datepicker({
        autoclose: true
    })
    $('#effectiveDateMul').datepicker({
        autoclose: true
    })

    $("#fundIndicationOptMul").select2({
        ajax: {
            url: current_url + "/ajax/fund_indication_option",
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
        placeholder: 'Indikasi Dana',
    });

    $("#pjpOptMul").select2({
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
        placeholder: 'Pjp',
    });

    $("#sectorOptMul").select2({
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

    $("#unitOptMul").select2({
        ajax: {
            url: current_url + "/ajax/unit_option",
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
        placeholder: 'Unit',
    }); 


    var projectList = {
        id: 'projectList',
        detail: function (dIn, el) {

            $.ajax({
                url: current_url + '/grid/project_detail_list',
                method: "POST",
                async: false,
                cache: false,
                data: { id: dIn.id },
                beforeSend: function () {
                    $('#projectList_processing').attr('style', 'display: block; z-index: 10000 !important');
                },
                success: function (d, status, xhr) {

                    tableOut = '';

                    tableOut += '<div class="table-responsive no-padding"><table class="table table-hover" style="text-align: center;">';

                    tableOut += '<tr>' +
                            '<th style="text-align:center;min-width: 130px !important; color: #00c0ef;">Config</th>' +
                            '<th style="text-align:center;color: #00c0ef;">Project</th>' +
                            '<th style="text-align:center;color: #00c0ef;">Sektor</th>' +
                            '<th style="text-align:center;min-width: 100px !important;color: #00c0ef;">Indikasi Dana</th>' +
                            '<th style="text-align:center;color: #00c0ef;">Jumlah Dana</th>' +
                            '<th style="text-align:center;min-width: 80px !important;color: #00c0ef;">Kode Status</th>' +
                            '<th style="text-align:center;color: #00c0ef;">Pjp</th>' +
                            '<th style="text-align:center;color: #00c0ef;">Tgl. Mulai</th>' +
                            '<th style="text-align:center;color: #00c0ef;">Tgl. Berakhir</th>' +
                        '</tr>';

                    try {

                        dataIn = JSON.parse(d);

                        if (xhr.status == 200) {
                            if (dataIn.status == true) {

                                for (var index = 0; index < dataIn.data.length; index++) {

                                    tableOut += '<tr>' +
                                        '<td>' + dataIn.data[index].action + '</td>' +
                                        '<td>' + dataIn.data[index].project_name + '</td>' +
                                        '<td>' + dataIn.data[index].sector_name + '</td>' +
                                        '<td>' + dataIn.data[index].fund_indication_name + '</td>' +
                                        '<td>' + dataIn.data[index].total_fund + '</td>' +
                                        '<td>' + dataIn.data[index].status_code_name + '</td>' +
                                        '<td>' + dataIn.data[index].pjp_name + '</td>' +
                                        '<td>' + dataIn.data[index].start_date + '</td>' +
                                        '<td>' + dataIn.data[index].end_date + '</td>' +
                                        '</tr>';

                                }

                                $('#projectList_processing').attr('style', 'display: none;');

                            } else if (dataIn.status == false) {

                                // alert(dataIn.message);

                                tableOut += '<tr> <td colspan="10">Data Kosong...</td> </tr>';
                                $('#projectList_processing').attr('style', 'display: none;');
                                
                                // window.projectGrid.table.draw();
                                
                            } else {
                                
                                // alert(dataIn.message);
                                
                                tableOut += '<tr> <td colspan="10">Data Kosong...</td> </tr>';
                                $('#projectList_processing').attr('style', 'display: none;');
                                // window.projectGrid.table.draw();

                            }
                        } else {
                            alert((dataIn.message == "" ? "Check your input" : dataIn.message));
                            $('#projectList_processing').attr('style', 'display: none;');
                        }


                    } catch (error) {

                        $('#projectList_processing').attr('style', 'display: none;');

                        alert(error);

                    }

                    tableOut += '</table></div>'

                },
                error: function (x) {
                    console.log(x);
                }
            });

            return tableOut;

        },
        column: [
            {
                "data": "id",
                "orderable": false,
                'sortable': false,
                "visible": false,
            },
            {
                "data": "icon",
                "class": "details-control",
                "orderable": false,
                'sortable': false,
                "visible": true,
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
            // {
            //     "data": "currency",
            //     "orderable": false
            // },
            // {
            //     "data": "status",
            //     "orderable": false
            // },
            {
                "data": "total_fund",
                "orderable": false,
                "render": $.fn.dataTable.render.number('.', ',', 2),
                "className": "text-right"
            },
            // {
            //     "data": "total_fund_apbnd",
            //     "orderable": false,
            //     "render": $.fn.dataTable.render.number('.', ',', 2)
            // },
            // {
            //     "data": "total_fund_bumnd",
            //     "orderable": false,
            //     "render": $.fn.dataTable.render.number('.', ',', 2)
            // },
            // {
            //     "data": "total_fund_swasta",
            //     "orderable": false,
            //     "render": $.fn.dataTable.render.number('.', ',', 2)
            // },
            {
                "data": "status_code_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "pjp_name",
                "orderable": false,
                "className": "text-left"
            },
            // {
            //     "data": "contact_person",
            //     "orderable": false
            // },
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
    window.projectGrid.url = current_url + "/grid/project_list";
    window.projectGrid.type = 'GET';
    window.projectGrid.init();

    var table = projectGrid.getTablesID();

    table.on('responsive-resize', function (e, datatable, columns) {
        var count = columns.reduce(function (a, b) {
            return b === false ? a + 1 : a;
        }, 0);

        // console.log(count + ' column(s) are hidden');
    });

    $("#totalFund").attr('disabled', true);

});

$('#projectSearch').on('click', function () {

    window.projectGrid.data = {
        projectFt: $("#projectFilter").val(),
        sectorFt: $("#sectorFilter").val(),
        statusCodeFt: $("#statusCodeFilter").val(),
    };

    window.projectGrid.table.draw();

});

var _actionPropForm = function(status){

    if ( formStatus == false ) {
        
        $("#externalCode").removeAttr("disabled");
        $("#projectName").removeAttr("disabled");
        $("#currency").removeAttr("disabled");
        $("#output").removeAttr("disabled");
        $("#contactPerson").removeAttr("disabled");
        $("#description").removeAttr("disabled");
        $("#status").removeAttr("disabled");
        $("#startDate").removeAttr("disabled");
        $("#transactionDate").removeAttr("disabled");
        $("#constructionDate").removeAttr("disabled");
        $("#operationDate").removeAttr("disabled");
        $("#endDate").removeAttr("disabled");
        $("#totalFundApbnd").removeAttr("disabled");
        $("#totalFundBumnd").removeAttr("disabled");
        $("#totalFundSwasta").removeAttr("disabled");
        // $("input[name=totalFund]").removeAttr("disabled");

        $('[name="sectorOpt"]').removeAttr("disabled");

        $('[name="statusCodeOpt"]').removeAttr("disabled");
        $('[name="pjpOpt"]').removeAttr("disabled");

        $('[name="unitOpt"]').removeAttr("disabled");

        $('[name="fundIndicationOpt"]').removeAttr("disabled");

        $('[name="provinceOpt"]').removeAttr("disabled");
        $('[name="projectOpt"]').removeAttr("disabled");
        $('[name="statusOpt"]').removeAttr("disabled");

        $('[name="islandOpt"]').removeAttr("disabled");

        $("#saveProject").removeAttr("disabled");

        $("#actionSubmit").text("View");

    } else {


        $("#externalCode").prop("disabled", status);
        $("#projectName").prop("disabled", status);
        $("#currency").prop("disabled", status);
        $("#output").prop("disabled", status);
        $("#contactPerson").prop("disabled", status);
        $("#description").prop("disabled", status);
        $("#status").prop("disabled", status);
        $("#startDate").prop("disabled", status);
        $("#transactionDate").prop("disabled", status);
        $("#constructionDate").prop("disabled", status);
        $("#operationDate").prop("disabled", status);
        $("#endDate").prop("disabled", status);
        $("#totalFundApbnd").prop("disabled", status);
        $("#totalFundBumnd").prop("disabled", status);
        $("#totalFundSwasta").prop("disabled", status);
        // $("input[name=totalFund]").prop("disabled", status);
    
        $('[name="sectorOpt"]').prop("disabled", status);
    
        $('[name="statusCodeOpt"]').prop("disabled", status);
        $('[name="pjpOpt"]').prop("disabled", status);
    
        $('[name="unitOpt"]').prop("disabled", status);
    
        $('[name="fundIndicationOpt"]').prop("disabled", status);
    
        $('[name="provinceOpt"]').prop("disabled", status);
        $('[name="projectOpt"]').prop("disabled", status);
        $('[name="statusOpt"]').prop("disabled", status);
    
        $('[name="islandOpt"]').prop("disabled", status);
    
        $("#saveProject").prop("disabled", status);
    
        $("#actionSubmit").text('Edit');

    }


};

$("#actionSubmit").on('click', function(){
    
    if ( formStatus == true ) {

        formStatus = false;
        
        _actionPropForm(false);
        
    } else {

        formStatus = true;
        
        _actionPropForm(true);

    }

});

$("#createCloseTopModal").on('click', function(){

    formStatus = true;
    formProjectId = false;

    _formProjectId();

    $("#openModalCreate").modal('hide');

});

$("#createCloseBottomModal").on('click', function(){

    formStatus = true;
    formProjectId = false;

    _formProjectId();

    $("#openModalCreate").modal('hide');

});


$("#totalFundApbnd").keyup(function () {


    var totalFundBumnd = $("#totalFundBumnd").val();
    var totalFundSwasta = $("#totalFundSwasta").val();

    // _totalThreeFund(Number($(this).val()) + Number(totalFundBumnd) + Number(totalFundSwasta));
    $("#totalThreeFund").text( currencyDollar(Number($(this).val()) + Number(totalFundBumnd) + Number(totalFundSwasta)) );
    $("input[name=totalFund]").val( Number($(this).val()) + Number(totalFundBumnd) + Number(totalFundSwasta) );

});

$("#totalFundBumnd").keyup(function () {


    var totalFundApbnd = $("#totalFundApbnd").val();
    var totalFundSwasta = $("#totalFundSwasta").val();

    // _totalThreeFund(Number(totalFundApbnd) + Number($(this).val()) + Number(totalFundSwasta));
    $("#totalThreeFund").text( currencyDollar(Number(totalFundApbnd) + Number($(this).val()) + Number(totalFundSwasta)) );
    $("input[name=totalFund]").val( Number(totalFundApbnd) + Number($(this).val()) + Number(totalFundSwasta) );

});

$("#totalFundSwasta").keyup(function () {


    var totalFundApbnd = $("#totalFundApbnd").val();
    var totalFundBumnd = $("#totalFundBumnd").val();

    // _totalThreeFund(Number(totalFundApbnd) + Number(totalFundBumnd) + Number($(this).val()));
    $("#totalThreeFund").text( currencyDollar(Number(totalFundApbnd) + Number(totalFundBumnd) + Number($(this).val())) );
    $("input[name=totalFund]").val( Number(totalFundApbnd) + Number(totalFundBumnd) + Number($(this).val()) );

});

$('#statusOpt').on('change', function(){

    _formProjectStatus();

});

var _formProjectStatus = function(){
    
    if ( $('[name="statusOpt"]').val() == 'parent' ) {

        formProjectId = false;
        $('[name="projectOpt"]').empty().trigger('change');
        
        $('#form-project').css('display', 'none');
        
    } else if ( $('[name="statusOpt"]').val() == 'child' ) {

        formProjectId = true;
        $('[name="projectOpt"]').empty().trigger('change');
        
        $('#form-project').css('display', 'block');

    }

}

var _formProjectId = function(){
    
    if ( formProjectId == false ) {

        $('#form-project').css('display', 'none');
        $('[name="statusOpt"]').val('parent')
        
    } else if ( formProjectId == true ) {
        
        $('#form-project').css('display', 'block');
        $('[name="statusOpt"]').val('child')

    }

}


$('#createProject').on('click', function(){

    $("#openModalCreate").modal({ backdrop: "static", keyboard: false });

    $("#actionSubmit").hide();
    
    formStatus = false;
    
    formProjectId = false;
    
    $('#openModalCreate').modal('show');

    _formProjectId();
    _formProjectStatus();
    _actionPropForm(false);

    formId = false;




    $('[name="statusOpt"]').val('parent');
    $('#id').val('');
    $('#externalCode').val('');
    $('#projectName').val('');
    $('#currency').val('');
    // $('#totalFund').val('');
    $('#output').val('');
    $('#contactPerson').val('');
    $('#description').val('');
    $('#status').val('');
    $('#startDate').val('');
    $('#transactionDate').val('');
    $('#constructionDate').val('');
    $('#operationDate').val('');
    $('#endDate').val('');
    $('#totalFundApbnd').val(0);
    $('#totalFundBumnd').val(0);
    $('#totalFundSwasta').val(0);
    $("input[name=totalFund]").val(0);
    $("#totalThreeFund").text(0);

    $('[name="sectorOpt"]').empty().trigger('change');

    $('[name="statusCodeOpt"]').empty().trigger('change');
    $('[name="pjpOpt"]').empty().trigger('change');
    $('[name="projectOpt"]').empty().trigger('change');

    $('[name="unitOpt"]').empty().trigger('change');

    $('[name="fundIndicationOpt"]').empty().trigger('change');
    $('[name="provinceOpt"]')
      .empty()
      .trigger("change");
    $('[name="islandOpt"]')
      .empty()
      .trigger("change");


});


var _gridAction = function () {

    $(".update-row").on("click", function () {

        $("#openModalCreate").modal({
          backdrop: "static",
          keyboard: false
        });

        $("#actionSubmit").show();
        
        $('#openModalCreate').modal('show');

        formProjectId = false;
        formId = true;

        _formProjectId();

        _formProjectStatus();


        var rowdata = window.projectGrid.table.row($(this).parents('tr')).data();

        $('#id').val(rowdata.id);
        $('#externalCode').val(rowdata.external_code);
        $('#projectName').val(rowdata.project_name);
        $('#currency').val(rowdata.currency);
        $('#totalFund').val(rowdata.total_fund);
        $('#output').val(rowdata.output);
        $('#contactPerson').val(rowdata.contact_person);
        $('#description').val(rowdata.description);
        $('#status').val(rowdata.status);
        $('#startDate').val(rowdata.start_date);
        $('#transactionDate').val(rowdata.transaction_date);
        $('#totalFundApbnd').val(rowdata.total_fund_apbnd);
        $('#totalFundBumnd').val(rowdata.total_fund_bumnd);
        $('#totalFundSwasta').val(rowdata.total_fund_swasta);
        $('#constructionDate').val(rowdata.construction_date);
        $('#constructionDate').val(rowdata.construction_date);
        $('#operationDate').val(rowdata.operation_date);
        $('#endDate').val(rowdata.end_date);

        var selectedSectorOption = new Option(rowdata.sector_name, rowdata.sector_id, true, true);
        $('[name="sectorOpt"]').append(selectedSectorOption).trigger('change');
        
        var selectedStatusCodeOption = new Option(rowdata.status_code_name, rowdata.status_code_id, true, true);
        $('[name="statusCodeOpt"]').append(selectedStatusCodeOption).trigger('change');
        
        var selectedPjpOption = new Option(rowdata.pjp_name, rowdata.pjp_id, true, true);
        $('[name="pjpOpt"]').append(selectedPjpOption).trigger('change');
        
        var selectedUnitOption = new Option(rowdata.unit_name, rowdata.unit_id, true, true);
        $('[name="unitOpt"]').append(selectedUnitOption).trigger('change');


        var selectedProvinceOption = new Option(rowdata.province_name, rowdata.province_id, true, true);
        $('[name="provinceOpt"]').append(selectedProvinceOption).trigger('change');

        var selectedIslandOption = new Option(rowdata.island_name, rowdata.island_id, true, true);
        $('[name="islandOpt"]').append(selectedIslandOption).trigger('change');


        $('[name="fundIndicationOpt"]').empty().trigger('change');
        
        var selectedfundIndicationOption = [];

        for (var key in rowdata.fund_indication_array) {
            if (rowdata.fund_indication_array.hasOwnProperty(key)) {

                selectedfundIndicationOption = new Option(rowdata.fund_indication_array[key].name, rowdata.fund_indication_array[key].id, true, true);
                
                $('[name="fundIndicationOpt"]').append(selectedfundIndicationOption).trigger('change');
                
            }
        }

        $("#totalThreeFund").text( currencyDollar( rowdata.total_fund ) );

        _actionPropForm(true);


    });

    $(".delete-row").on("click", function () {

        if (confirm('Apakah Anda yakin ingin menghapus proyek?')) {
            
            formId = false;

            var rowdata = window.projectGrid.table.row($(this).parents('tr')).data();

            var myAjax = new ajax();
            myAjax.url = current_url + '/ajax/' + 'delete_project';
            myAjax.async = false;
            myAjax.data = {
                id: rowdata.id,
            };
            myAjax.callback = _reloadGridCallback;
            myAjax.init();

        } else {
            alert('Proyek batal dihapus.');
        }

    });

}

var _deleteMultiProject = function (id) {
    

    if (confirm('Apakah Anda yakin ingin menghapus proyek?')) {
            
        formId = false;
        formProjectId = false;

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_multi_project';
        myAjax.async = false;
        myAjax.data = {
            id: id,
        };
        myAjax.callback = _reloadGridCallback;
        myAjax.init();

    } else {
        alert('Proyek batal dihapus.');
    }

}

var _updateMultiProject = function (id) {

    
    $("#openModalCreate").modal({
        backdrop: "static",
        keyboard: false
    });

    $("#actionSubmit").show();

    $('#openModalCreate').modal('show');

    formProjectId = true;
    formId = true;

    _formProjectId();

    _formProjectStatus();

    _actionPropForm(true);

    var myAjax = new ajax();
    myAjax.url = current_url + '/ajax/' + 'get_multi_project';
    myAjax.async = false;
    myAjax.data = {
        id: id,
    };
    myAjax.callback = _detailMultiProjectCallback;
    myAjax.init();
    
};

$('#saveProject').on('click', function () {

    // formId = false;

    var stopProcessing = false;

    if ( formProjectId == true ) {

        if ( ($('[name="projectOpt"]').val() == '') || ($('[name="projectOpt"]').val() == null) ) {
            
            alert('Field Proyek masih kosong. Perhatikan data anda!');
            return false;

        }
        
    }

    $($(this).parents('form')).find('.insert-project').each(function (index, element) {
        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {
            
            stopProcessing = true;
        }
    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = '';

        if ( formProjectId == false ) {

            if (formId == true) {
                action_url = 'update_project';
            } else {
                action_url = 'create_project';
            }
            
        } else {
            
            if (formId == true) {
                action_url = 'update_multi_project';
            } else {
                action_url = 'create_multi_project';
            }

        }


        _actionInsert($(this).parents('form'), 'Project/Project/ajax/' + action_url, '.insert-project');

    }

});

$('#saveMultiProject').on('click', function () {

    // formId = false;

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-multi-project').each(function (index, element) {
        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {

            stopProcessing = true;
        }
    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = '';

        if (formId == true) {
            action_url = 'update_multi_project';
        } else {
            action_url = 'create_multi_project';
        }

        _actionInsert($(this).parents('form'), 'Project/Project/ajax/' + action_url, '.insert-multi-project');

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
            $('#openModalCreateMulti').modal('hide');

            window.projectGrid.table.draw();
            $('#projectForm')[0].reset();
            $('#multiProjectForm')[0].reset();

        } else if (data.status == 500) {
            alert(data.message);
        } else {
            
            alert(data.message);
            
            window.projectGrid.table.draw();
        
        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

var _detailMultiProjectCallback = function (data, status, xhr) {
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {

            var rowdata = data.data;

            $('#id').val(rowdata.id);
            $('#externalCode').val(rowdata.external_code);
            $('#projectName').val(rowdata.project_name);
            $('#currency').val(rowdata.currency);
            $('#totalFund').val(rowdata.total_fund);
            $('#output').val(rowdata.output);
            $('#contactPerson').val(rowdata.contact_person);
            $('#description').val(rowdata.description);
            $('#status').val(rowdata.status);
            $('#startDate').val(rowdata.start_date);
            $('#transactionDate').val(rowdata.transaction_date);
            $('#totalFundApbnd').val(rowdata.total_fund_apbnd);
            $('#totalFundBumnd').val(rowdata.total_fund_bumnd);
            $('#totalFundSwasta').val(rowdata.total_fund_swasta);
            $('#constructionDate').val(rowdata.construction_date);
            $('#constructionDate').val(rowdata.construction_date);
            $('#operationDate').val(rowdata.operation_date);
            $('#endDate').val(rowdata.end_date);

            var selectedProjectOption = new Option(rowdata.project_mst_name, rowdata.project_mst_id, true, true);
            $('[name="projectOpt"]').append(selectedProjectOption).trigger('change');

            var selectedSectorOption = new Option(rowdata.sector_name, rowdata.sector_id, true, true);
            $('[name="sectorOpt"]').append(selectedSectorOption).trigger('change');
            
            var selectedStatusCodeOption = new Option(rowdata.status_code_name, rowdata.status_code_id, true, true);
            $('[name="statusCodeOpt"]').append(selectedStatusCodeOption).trigger('change');
            
            var selectedPjpOption = new Option(rowdata.pjp_name, rowdata.pjp_id, true, true);
            $('[name="pjpOpt"]').append(selectedPjpOption).trigger('change');
            
            var selectedUnitOption = new Option(rowdata.unit_name, rowdata.unit_id, true, true);
            $('[name="unitOpt"]').append(selectedUnitOption).trigger('change');

            var selectedProvinceOption = new Option(rowdata.province_name, rowdata.province_id, true, true);
            $('[name="provinceOpt"]').append(selectedProvinceOption).trigger('change');

            var selectedIslandOption = new Option(rowdata.island_name, rowdata.island_id, true, true);
            $('[name="islandOpt"]').append(selectedIslandOption).trigger('change');


            $('[name="fundIndicationOpt"]').empty().trigger('change');
            
            var selectedfundIndicationOption = [];

            for (var key in rowdata.fund_indication_array) {
                if (rowdata.fund_indication_array.hasOwnProperty(key)) {

                    selectedfundIndicationOption = new Option(rowdata.fund_indication_array[key].name, rowdata.fund_indication_array[key].id, true, true);
                    
                    $('[name="fundIndicationOpt"]').append(selectedfundIndicationOption).trigger('change');
                    
                }
            }

            $("#totalThreeFund").text( currencyDollar( rowdata.total_fund ) );


        } else {
            alert(data.message);
        }
    } else
        alert((data.message == "" ? "Check your input" : data.message));
};

var _reloadGridCallback = function (data, status, xhr) {
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {

            alert(data.message);

            $('#openModalCreate').modal('hide');
            // $('#openModalCreateMulti').modal('hide');

            window.projectGrid.table.draw();

        } else {
            alert(data.message);
        }
    } else
        alert((data.message == "" ? "Check your input" : data.message));
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
