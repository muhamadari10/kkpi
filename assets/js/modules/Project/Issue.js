
var formId = false;
dataIn = '';
tableOut = '';

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    //Date picker
    $('#planningSolveIssueDate').datepicker({
        autoclose: true
    })

    $('#caseIssueDate').datepicker({
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


    var issueList = {
        id: 'issueList',
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
                "data": "issue_description",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "impact_duration",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "case_issue_date",
                "orderable": false,
                "render": function (data) {
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "planning_solve_issue_date",
                "orderable": false,
                "render": function (data) {
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "severity_level_issue",
                "orderable": false
            },
            {
                "data": "frequency_level_name",
                "orderable": false
            },
            {
                "data": "stakeholder_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "issue_type_name",
                "orderable": false,
                "className": "text-left"
            },
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    // $('#' + issueList.id + ' tfoot th').each(function () {
    //     var title = $(this).text();
    //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    // });

    window.issueGrid = new grid(issueList);
    window.issueGrid.url = current_url + "/grid/issue_list";
    window.issueGrid.type = 'GET';
    window.issueGrid.init();

    var table = issueGrid.getTablesID();

    // table.columns().every(function () {
    //     var that = this;

    //     $('input', this.footer()).on('keyup change', function () {
    //         if (that.search() !== this.value) {
    //             that
    //                 .search(this.value)
    //                 .draw();
    //         }
    //     });
    // });

});

$('#issueFilter').on('click', function () {

    window.issueGrid.data = {
        projectFt: $("#projectFilter").val(),
        phaseFt: $("#phaseFilter").val(),
        activityFt: $("#activityFilter").val(),
        stakeholderFt: $("#stakeholderFilter").val(),
    };

    window.issueGrid.table.draw();

});


$('#createIssue').on('click', function(){

    formId = false;

    $('#openModalCreate').modal('show');

    $('#issueId').val('');
    $('#issueDescription').val('');
    $('#caseIssueDate').val('');
    $('#planningSolveIssueDate').val('');
    $('#impactDuration').val('');

    $('[name="projectOpt"]').empty().trigger('change');
    $('[name="frequencyLevelOpt"]').empty().trigger('change');
    $('[name="severityLevelOpt"]').empty().trigger('change');
    $('[name="stakeholderOpt"]').empty().trigger('change');
    $('[name="issueTypeOpt"]').empty().trigger('change');
    $('[name="activityOpt"]').empty().trigger('change');
    $('[name="phaseOpt"]').empty().trigger('change');

});

var _gridAction = function () {

    $(".update-row").on("click", function () {

        $('#openModalCreate').modal('show');

        formId = true;

        var rowdata = window.issueGrid.table.row($(this).parents('tr')).data();

        $('#issueId').val(rowdata.id);
        $('#projectOpt').val('').trigger('change');
        $('#issueDescription').val(rowdata.issue_description);
        $('#caseIssueDate').val(rowdata.case_issue_date);
        $('#planningSolveIssueDate').val(rowdata.planning_solve_issue_date);
        $('#impactDuration').val(rowdata.impact_duration);
        $('#frequencyLevelOpt').val('').trigger('change');
        $('#severityLevelOpt').val('').trigger('change');
        $('#issueTypeOpt').val('').trigger('change');
        $('#stakeholderOpt').val('').trigger('change');
        $('#activityOpt').val('').trigger('change');
        $('#phaseOpt').val('').trigger('change');

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

        var rowdata = window.issueGrid.table.row($(this).parents('tr')).data();

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_issue';
        myAjax.async = false;
        myAjax.data = {
            id: rowdata.id,
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

}

$('#saveIssue').on('click', function () {

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-issue').each(function (index, element) {
        
        if (( ($(this).val() == '') || ($(this).val() == null) ) && ($(this).hasClass("validate"))) {
            
            stopProcessing = true;
        
        }

    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = (formId == false) ? 'create_issue' : 'update_issue';

        _actionInsert($(this).parents('form'), 'Project/Issue/ajax/' + action_url, '.insert-issue');

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

    $(".modal-footer button i").addClass('fa fa-spin fa-refresh');
    $(".modal-footer button").prop("disabled", true);

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

            window.issueGrid.table.draw();
            $('#issueForm')[0].reset();

            $(".modal-footer button i").removeClass('fa fa-spin fa-refresh');
            $(".modal-footer button").prop("disabled", false);

        } else if (data.status == 500) {
            
            alert(data.message);

            $(".modal-footer button i").removeClass('fa fa-spin fa-refresh');
            $(".modal-footer button").prop("disabled", false);

        } else {
            
            alert(data.message);
            
            window.issueGrid.table.draw();

            $(".modal-footer button i").removeClass('fa fa-spin fa-refresh');
            $(".modal-footer button").prop("disabled", false);
        
        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
        
        $(".modal-footer button i").removeClass('fa fa-spin fa-refresh');
        $(".modal-footer button").prop("disabled", false);
    }
};

