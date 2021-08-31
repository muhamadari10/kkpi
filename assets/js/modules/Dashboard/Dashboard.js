
$(document).ajaxStart(function () {
    Pace.restart()
});


$(document).ready(function () {

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

    
    window.activityCharts = new ajax();
    window.activityCharts.url = current_url + "/ajax/activity_charts";
    window.activityCharts.async = false;
    window.activityCharts.callback = _activityChartsActionCallback;
    window.activityCharts.init();
    
    window.fundIndicationCharts = new ajax();
    window.fundIndicationCharts.url = current_url + "/ajax/fund_indication_charts";
    window.fundIndicationCharts.async = false;
    window.fundIndicationCharts.callback = _fundIndicationChartsActionCallback;
    window.fundIndicationCharts.init();
    
    window.issueCharts = new ajax();
    window.issueCharts.url = current_url + "/ajax/issue_charts";
    window.issueCharts.async = false;
    window.issueCharts.callback = _issueChartsActionCallback;
    window.issueCharts.init();

});

_projectLocationActionCallback = function (data, status, xhr) {

    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {
            $(".btn-status").removeClass('fa fa-spin fa-refresh');
            
            $(".design").text(data.data.design.label);
            $(".construction").text(data.data.construction.label);
            $(".preparation").text(data.data.preparation.label);
            $(".transaction").text(data.data.transaction.label);
            
            $(".design-value").text(data.data.design.value);
            $(".construction-value").text(data.data.construction.value);
            $(".preparation-value").text(data.data.preparation.value);
            $(".transaction-value").text(data.data.transaction.value);
            

        } else {

            alert(data.message);
            $(".btn-status").removeClass('fa fa-spin fa-refresh');            

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
        $(".btn-status").removeClass('fa fa-spin fa-refresh');        
    }

};

$('#dashboardSubmit').on('click', function () {

    window.activityCharts.data = {
        sectorFt: $("#sectorOpt").val(),
        pjpFt: $("#pjpOpt").val(),
    }
    window.activityCharts.init();
    
    window.fundIndicationCharts.data = {
        sectorFt: $("#sectorOpt").val(),
        pjpFt: $("#pjpOpt").val(),
    }
    window.fundIndicationCharts.init();
    
    window.issueCharts.data = {
        sectorFt: $("#sectorOpt").val(),
        pjpFt: $("#pjpOpt").val(),
    }
    window.issueCharts.init();

});

_activityChartsActionCallback = function (data, status, xhr) {
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {

            // console.log(data.data);
            

            new Morris.Donut({
                element: 'activityChart',
                resize: true,   
                colors: ["#3c8dbc", "#f56954", "#00a65a", "#ffa500", "#FF00FF", "#FFFF00", "#00FFFF"],
                data: [
                    { label: data.data.design.label, value: data.data.design.value },
                    { label: data.data.preparation.label, value: data.data.preparation.value },
                    { label: data.data.transaction.label, value: data.data.transaction.value },
                    
                    { label: data.data.constructionAfter2019.label, value: data.data.constructionAfter2019.value },
                    { label: data.data.constructionOperation2019.label, value: data.data.constructionOperation2019.value },
                    { label: data.data.constructionOperation2018.label, value: data.data.constructionOperation2018.value },
                    { label: data.data.constructionAndOperation.label, value: data.data.constructionAndOperation.value }
                ],
                hideHover: 'auto'
            });

            $(".statdesign-bg").css("background-color", "#3c8dbc");
            $(".statpreparation-bg").css("background-color", "#f56954");
            $(".stattransaction-bg").css("background-color", "#00a65a");
            
            $(".constructionAfter2019-bg").css("background-color", "#ffa500");
            $(".constructionOperation2019-bg").css("background-color", "#FF00FF");
            $(".constructionOperation2018-bg").css("background-color", "#FFFF00");
            $(".constructionAndOperation-bg").css("background-color", "#00FFFF");

            $(".statdesign-description").text(data.data.design.label);
            $(".statpreparation-description").text(data.data.preparation.label);
            $(".stattransaction-description").text(data.data.transaction.label);
            
            $(".constructionAfter2019-description").text(data.data.constructionAfter2019.label);
            $(".constructionOperation2019-description").text(data.data.constructionOperation2019.label);
            $(".constructionOperation2018-description").text(data.data.constructionOperation2018.label);
            $(".constructionAndOperation-description").text(data.data.constructionAndOperation.label);
            
            $(".statdesign-value").text(data.data.design.value);
            $(".statpreparation-value").text(data.data.preparation.value);
            $(".stattransaction-value").text(data.data.transaction.value);
            
            $(".constructionAfter2019-value").text(data.data.constructionAfter2019.value);
            $(".constructionOperation2019-value").text(data.data.constructionOperation2019.value);
            $(".constructionOperation2018-value").text(data.data.constructionOperation2018.value);
            $(".constructionAndOperation-value").text(data.data.constructionAndOperation.value);

            
            $(".statdesign-description").data('statdesign', data.data.design.ids);
            $(".statpreparation-description").data('statpreparation', data.data.preparation.ids);
            $(".stattransaction-description").data('stattransaction', data.data.transaction.ids);
            
            $(".constructionAfter2019-description").data('constructionAfter2019', data.data.constructionAfter2019.ids);
            $(".constructionOperation2019-description").data('constructionOperation2019', data.data.constructionOperation2019.ids);
            $(".constructionOperation2018-description").data('constructionOperation2018', data.data.constructionOperation2018.ids);
            $(".constructionAndOperation-description").data('constructionAndOperation', data.data.constructionAndOperation.ids);
            
            $(".statdesign-description").css('color', 'black');
            $(".statpreparation-description").css('color', 'black');
            $(".stattransaction-description").css('color', 'black');
            
            $(".constructionAfter2019-description").css('color', 'black');
            $(".constructionOperation2019-description").css('color', 'black');
            $(".constructionOperation2018-description").css('color', 'black');
            $(".constructionAndOperation-description").css('color', 'black');
            
        } else {

            alert(data.message);

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

_fundIndicationChartsActionCallback = function (data, status, xhr) {
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {

            // console.log(data.data);
            

            new Morris.Donut({
                element: 'fundIndicationChart',
                resize: true,   
                colors: ["#3c8dbc", "#f56954", "#00a65a"],
                data: [
                    { label: data.data.apbnd.label, value: data.data.apbnd.value },
                    { label: data.data.bumnd.label, value: data.data.bumnd.value },
                    { label: data.data.swasta.label, value: data.data.swasta.value }
                ],
                hideHover: 'auto'
            });

            $(".statapbnd-bg").css("background-color", "#3c8dbc");
            $(".statbumnd-bg").css("background-color", "#f56954");
            $(".statswasta-bg").css("background-color", "#00a65a");

            $(".statapbnd-description").text(data.data.apbnd.label);
            $(".statbumnd-description").text(data.data.bumnd.label);
            $(".statswasta-description").text(data.data.swasta.label);

            
            $(".statapbnd-value").text(currencyDollar((data.data.apbnd.value == null)?0:data.data.apbnd.value));
            $(".statbumnd-value").text(currencyDollar((data.data.bumnd.value == null)?0:data.data.bumnd.value));
            $(".statswasta-value").text(currencyDollar((data.data.swasta.value == null)?0:data.data.swasta.value));
            
        } else {

            alert(data.message);

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

_issueChartsActionCallback = function (data, status, xhr) {
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {

            // console.log(data.data);
            

            new Morris.Donut({
                element: 'issueChart',
                resize: true,   
                colors: ["#3c8dbc", "#f56954", "#00a65a", "#ffa500", "#808080"],
                data: [
                    { label: data.data.construction.label, value: data.data.construction.value },
                    { label: data.data.licensing.label, value: data.data.licensing.value },
                    { label: data.data.fund.label, value: data.data.fund.value },
                    { label: data.data.landacquisition.label, value: data.data.landacquisition.value },
                    { label: data.data.planning.label, value: data.data.planning.value }
                ],
                hideHover: 'auto'
            });

            $(".issstatconstruction-bg").css("background-color", "#3c8dbc");
            $(".statlicensing-bg").css("background-color", "#f56954");
            $(".statfund-bg").css("background-color", "#00a65a");
            $(".statlandacquisition-bg").css("background-color", "#ffa500");
            $(".statplanning-bg").css("background-color", "#808080");

            $(".issstatconstruction-description").text(data.data.construction.label);
            $(".statlicensing-description").text(data.data.licensing.label);
            $(".statfund-description").text(data.data.fund.label);
            $(".statlandacquisition-description").text(data.data.landacquisition.label);
            $(".statplanning-description").text(data.data.planning.label);

            $(".issstatconstruction-description").css('color', 'black');
            $(".statlicensing-description").css('color', 'black');
            $(".statfund-description").css('color', 'black');
            $(".statlandacquisition-description").css('color', 'black');
            $(".statplanning-description").css('color', 'black');

            $(".issstatconstruction-value").text(data.data.construction.value);
            $(".statlicensing-value").text(data.data.licensing.value);
            $(".statfund-value").text(data.data.fund.value);
            $(".statlandacquisition-value").text(data.data.landacquisition.value);
            $(".statplanning-value").text(data.data.planning.value);

            
            $(".issstatconstruction-description").data('issstatconstruction', data.data.construction.ids);
            $(".statlicensing-description").data('statlicensing', data.data.licensing.ids);
            $(".statfund-description").data('statfund', data.data.fund.ids);
            $(".statlandacquisition-description").data('statlandacquisition', data.data.landacquisition.ids);
            $(".statplanning-description").data('statplanning', data.data.planning.ids);

        } else {

            alert(data.message);

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

// status code call project detail
$('.btn-statdesign').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('statdesign'), 'project_detail_list');

});

$('.btn-statpreparation').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('statpreparation'), 'project_detail_list');

});

$('.btn-stattransaction').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('stattransaction'), 'project_detail_list');

});

$('.btn-constructionAfter2019').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('constructionAfter2019'), 'project_detail_list');

});

$('.btn-constructionOperation2019').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('constructionOperation2019'), 'project_detail_list');

});

$('.btn-constructionOperation2018').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('constructionOperation2018'), 'project_detail_list');

});

$('.btn-constructionAndOperation').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('constructionAndOperation'),'project_detail_list');

});

// end of status code call project detail


// issue call project detail

$('.btn-issstatconstruction').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('issstatconstruction'), 'project_detail_issue');

});

$('.btn-statlicensing').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('statlicensing'), 'project_detail_issue');

});

$('.btn-statfund').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('statfund'), 'project_detail_issue');

});

$('.btn-statlandacquisition').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('statlandacquisition'), 'project_detail_issue');

});

$('.btn-statplanning').on('click', function(elm){

    $(".btn-status").addClass("fa fa-spin fa-refresh");
    
    _callProjectDetail($($(elm)[0].target).data('statplanning'), 'project_detail_issue');

});

// end of issue call project detail


var labelColor = [
    "label-danger",
    "label-success",
    "label-info",
    "label-warning",
    "label-primary",
    "label-secondary",
    "label-default"
];

var _callProjectDetail = function(dt, uri) {

    $("#openModalProject").modal({
        backdrop: "static",
        keyboard: false
    });

    $("#openModalProject").modal("show");

    var projectInfo = new ajax();
    projectInfo.url = current_url + "/ajax/" + uri;
    projectInfo.async = false;
    projectInfo.data = {
        statusCode: dt,
        sectorFt: $("#sectorOpt").val(),
        pjpFt: $("#pjpOpt").val()
    };
    projectInfo.callback = _projectInfoActionCallback;
    projectInfo.init();

}


var _projectInfoActionCallback = function (data, status, xhr) {

    $("#projectInfoList").empty();

    var dataOut = '';   
    
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {

            $(".box-project-info").text(data.headerTitle);
            $(".box-project-province").text(data.headerProvince);
            
            var num = 0;

            for (var index = 0; index < data.data.length; index++) {
                
                num++;
                
                dataOut += '<tr>';
                
                dataOut += "<td>" + num + "</td>";
                 dataOut += "<td>" + data.data[index].external_code + "</td>";
                dataOut += "<td>" + data.data[index].project + "</td>";
                dataOut += "<td>" + data.data[index].sector + "</td>";
                dataOut += "<td>" + data.data[index].pjp + "</td>";

                var dataFund = '';

                for (var j = 0; j < data.data[index].fundNameArr.length; j++) {

                    dataFund += '<span class="label ' + labelColor[j] + '">' + data.data[index].fundNameArr[j].name + "</span> ";

                }

                dataOut += "<td>" + dataFund + "</td>";
                dataOut += "<td><span class='badge bg-light-blue'>" + currencyDollar(data.data[index].totalFund) + "</span></td>";
                dataOut += '<td><div class="btn-group"><button onclick="return _viewDetRow(' + data.data[index].id + ')" type="button" data-toggle="tooltip" title="View" class="btn btn-warning btn-flat"><i class="fa fa-search-plus"></i></button></div></td>';

                dataOut += '</tr>';


            }

            $("#projectInfoList").html(dataOut);

            setTimeout(() => {
                
                $(".btn-status").removeClass("fa fa-spin fa-refresh");      
                
            }, 600);


        } else {

            
            
            alert(data.message + ', Data Kosong...');
            $(".btn-status").removeClass('fa fa-spin fa-refresh');

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
        $(".btn-status").removeClass('fa fa-spin fa-refresh');
    }

};

$("#createCloseTopModalProjectInfo").on('click', function () {

    $("#openModalProject").modal('hide');

});

$("#createCloseBottomModalProjectInfo").on('click', function () {

    $("#openModalProject").modal('hide');

});

$("#createCloseTopModal").on('click', function () {

    $("#openModalResume").modal('hide');

});

$("#createCloseBottomModal").on('click', function () {

    $("#openModalResume").modal('hide');

});

$(document).on('show.bs.modal', function (event) {
    if (!event.relatedTarget) {
        $('.modal').not(event.target).modal('hide');
    };
    if ($(event.relatedTarget).parents('.modal').length > 0) {
        $(event.relatedTarget).parents('.modal').modal('hide');
    };
});

$(document).on('shown.bs.modal', function (event) {
    if ($('body').hasClass('modal-open') == false) {
        $('body').addClass('modal-open');
    };
});

var _viewDetRow = function (dt) {
    
    // console.log(dt);
    // return false;

    $(".btn-status-resume").addClass("fa fa-spin fa-refresh");

    $("#openModalResume").modal({
        backdrop: "static",
        keyboard: false
    });

    $('#openModalResume').modal('show');

    // return false;

    var resumeProject = new ajax();
    resumeProject.url = current_url + "/ajax/resume_project";
    resumeProject.async = false;
    resumeProject.data = {
        dt: dt
    };
    resumeProject.callback = _resumeProjectActionCallback;
    resumeProject.init();
    
};

var _resumeProjectActionCallback = function (data, status, xhr) {

    _emptyResume();

    var dataOut = '';   
    
    var data = JSON.parse(data);
    if (xhr.status == 200) {
        if (data.status) {
            
            var rowdata = data.data;

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

            setTimeout(() => {
                
                $(".btn-status-resume").removeClass("fa fa-spin fa-refresh");      
                
            }, 600);


        } else {

            alert(data.message + ', Data Kosong...');
            $(".btn-status-resume").removeClass('fa fa-spin fa-refresh');

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
        $(".btn-status-resume").removeClass('fa fa-spin fa-refresh');
    }

}

var _emptyResume = function(){

    $('#project-name').text('');
    $('#pjp').text('');
    $('#external-code').text('');
    $('#contact-person').text('');
    $('#sector').text('');
    $('#currency').text('');
    $('#output').text('');

    $('#province-island').text('');

    $('#fund-indication').empty();
    $('#description').text('');
    $('#status').text('');

    $('#start-date').text('');
    $('#transaction-date').text('');
    $('#construction-date').text('');
    $('#operation-date').text('');
    $('#end-date').text('');

    $('#apbnd').text('');
    $('#bumnd').text('');
    $('#swasta').text('');
    $('#total').text('');

}

var currencyDollar = function (number) {
    var number = number.toString(),
        dollars = number.split('.')[0],
        cents = (number.split('.')[1] || '') + '00';
    dollars = dollars.split('').reverse().join('')
        .replace(/(\d{3}(?!$))/g, '$1.')
        .split('').reverse().join('');
    return 'Rp. ' + dollars + ',' + cents.slice(0, 2);
}


$('.product-title').on('click', function(){

    alert('Comming soon!');

});
