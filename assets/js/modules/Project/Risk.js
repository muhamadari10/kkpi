
var formId = false;
dataIn = '';
tableOut = '';

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    //Date picker
    $('#planningSolveRiskDate').datepicker({
        autoclose: true
    })

    $('#caseRiskDate').datepicker({
        autoclose: true
    })

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


    $("#issueTypeOpt").select2({
        ajax: {
            url: current_url + "/ajax/issue_type_option",
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
        placeholder: 'Jenis Isu',
    });

    $("#stakeholderFilter").select2({
        ajax: {
            url: current_url + "/ajax/stakeholder_option",
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
        placeholder: 'Stakeholder',
    });

    $("#phaseFilter").select2({
        ajax: {
            url: current_url + "/ajax/phase_option",
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
        placeholder: 'Fase',
    });

    $("#activityFilter").select2({
        ajax: {
            url: current_url + "/ajax/activity_option",
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
        placeholder: 'Aktivitas',
    });

    $("#phaseOpt").select2({
        ajax: {
            url: current_url + "/ajax/phase_option",
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
        placeholder: 'Fase',
    });

    $("#activityOpt").select2({
        ajax: {
            url: current_url + "/ajax/activity_option",
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
        placeholder: 'Aktivitas',
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

    $("#frequencyLevelOpt").select2({
        ajax: {
            url: current_url + "/ajax/frequency_level_option",
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
        placeholder: 'Frekuensi',
    });

    $("#severityLevelOpt").select2({
        ajax: {
            url: current_url + "/ajax/severity_level_option",
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
        placeholder: 'Tingkat Keparahan',
    });

    $("#stakeholderOpt").select2({
        ajax: {
            url: current_url + "/ajax/stakeholder_option",
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
        placeholder: 'Stakeholder',
    });


    var riskList = {
        id: 'riskList',
        column: [
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
                "orderable": false
            },
            {
                "data": "risk_description",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "impact_duration",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "case_risk_date",
                "orderable": false,
                "render": function (data) {
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "planning_solve_risk_date",
                "orderable": false,
                "render": function (data) {
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "severity_level_risk",
                "orderable": false
            },
            {
                "data": "frequency_level_risk",
                "orderable": false
            },

            {
                "data": "issue_type_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "stakeholder_name",
                "orderable": false,
                "className": "text-left"
            },
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    window.riskGrid = new grid(riskList);
    window.riskGrid.url = current_url + "/grid/risk_list";
    window.riskGrid.type = 'GET';
    window.riskGrid.init();

    var table = riskGrid.getTablesID();

});

$('#riskFilter').on('click', function () {

    window.riskGrid.data = {
        projectFt: $("#projectFilter").val(),
        phaseFt: $("#phaseFilter").val(),
        activityFt: $("#activityFilter").val(),
        stakeholderFt: $("#stakeholderFilter").val(),
    };
    
    window.riskGrid.table.draw();

});


$('#createRisk').on('click', function () {

    formId = false;

    $('#openModalCreate').modal('show');

    $('#riskId').val('');
    $('#riskDescription').val('');
    $('#caseRiskDate').val('');
    $('#planningSolveRiskDate').val('');
    $('#impactDuration').val('');

    $('[name="projectOpt"]').empty().trigger('change');
    $('[name="frequencyLevelOpt"]').empty().trigger('change');
    $('[name="severityLevelOpt"]').empty().trigger('change');
    $('[name="stakeholderOpt"]').empty().trigger('change');
    $('[name="activityOpt"]').empty().trigger('change');
    $('[name="issueTypeOpt"]').empty().trigger('change');
    $('[name="phaseOpt"]').empty().trigger('change');

});

var _gridAction = function () {

    $(".update-row").on("click", function () {

        $('#openModalCreate').modal('show');

        formId = true;

        var rowdata = window.riskGrid.table.row($(this).parents('tr')).data();

        $('#riskId').val(rowdata.id);
        $('#riskDescription').val(rowdata.risk_description);
        $('#caseRiskDate').val(rowdata.case_risk_date);
        $('#planningSolveRiskDate').val(rowdata.planning_solve_risk_date);
        $('#impactDuration').val(rowdata.impact_duration);
        
        var selectedProjectOption = new Option(rowdata.project_name, rowdata.project_mst_id, true, true);
        $('[name="projectOpt"]').append(selectedProjectOption).trigger('change');

        var selectedFrequencyOption = new Option(rowdata.frequency_level_name, rowdata.frequency_level_id, true, true);
        $('[name="frequencyLevelOpt"]').append(selectedFrequencyOption).trigger('change');

        var selectedSeverityOption = new Option(rowdata.severity_level_name, rowdata.severity_level_id, true, true);
        $('[name="severityLevelOpt"]').append(selectedSeverityOption).trigger('change');

        var selectedPhaseOption = new Option(rowdata.phase_name, rowdata.phase_id, true, true);
        $('[name="phaseOpt"]').append(selectedPhaseOption).trigger('change');

        var selectedActivityOption = new Option(rowdata.activity_name, rowdata.activity_id, true, true);
        $('[name="activityOpt"]').append(selectedActivityOption).trigger('change');

        var selectedIssueTypeOption = new Option(rowdata.issue_type_name, rowdata.issue_type_id, true, true);
        $('[name="issueTypeOpt"]').append(selectedIssueTypeOption).trigger('change');

        $('[name="stakeholderOpt"]').empty().trigger('change');

        var selectedStakeholderOption = [];

        for (var key in rowdata.stakeholder_array) {
            if (rowdata.stakeholder_array.hasOwnProperty(key)) {

                selectedStakeholderOption = new Option(rowdata.stakeholder_array[key].name, rowdata.stakeholder_array[key].id, true, true);
                $('[name="stakeholderOpt"]').append(selectedStakeholderOption).trigger('change');

            }
        }

    });

    $(".delete-row").on("click", function () {

        formId = false;

        var rowdata = window.riskGrid.table.row($(this).parents('tr')).data();

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_risk';
        myAjax.async = false;
        myAjax.data = {
            id: rowdata.id,
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

}

$('#saveRisk').on('click', function () {

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-risk').each(function (index, element) {

        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {

            stopProcessing = true;

        }

    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = (formId == false) ? 'create_risk' : 'update_risk';

        _actionInsert($(this).parents('form'), 'Project/Risk/ajax/' + action_url, '.insert-risk');

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

            window.riskGrid.table.draw();
            $('#riskForm')[0].reset();

        } else if (data.status == 500) {

            alert(data.message);

        } else {

            alert(data.message);

            window.riskGrid.table.draw();

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

