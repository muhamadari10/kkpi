
var formId = false;

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    $("#groupOpt").select2({
        ajax: {
            url: current_url + "/ajax/group_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {

                $("#pjpOpt").empty().trigger('change');

                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Group Access',
    });

    $("#pjpOpt").select2({
        ajax: {
            url: current_url + "/ajax/pjp_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    group: $("#groupOpt").val()
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

    var userAccessList = {
        id: 'userAccessList',
        column: [
            {
                "data": "action",
                "orderable": false
            },
            {
                "data": "active_status",
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "full_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "username",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "group_desc",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "pjp_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "phone_number",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "email",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "address",
                "orderable": false,
                "className": "text-left"
            }
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    window.userAccessGrid = new grid(userAccessList);
    window.userAccessGrid.url = current_url + "/grid/user_access_list";
    window.userAccessGrid.type = 'GET';
    window.userAccessGrid.init();

    var table = userAccessGrid.getTablesID();

});

$('#createUserAccess').on('click', function () {

    formId = false;

    $('#openModalCreate').modal('show');

    $('#userAccessId').val('');
    $('#name').val('');
    $('#username').val('');
    $('#password').val('');
    $('#groupOpt').empty().trigger('change');
    $('#pjpOpt').empty().trigger('change');
    $('#email').val('');
    $('#phoneNumber').val('');
    $('#address').val('');

});

var _gridAction = function () {

    $(".update-row").on("click", function () {

        $('#openModalCreate').modal('show');

        formId = true;

        var rowdata = window.userAccessGrid.table.row($(this).parents('tr')).data();

        $('#id').val(rowdata.id);
        $('#name').val(rowdata.userAccess_name);
        $('#userAccessAddress').val(rowdata.userAccess_address);

        $('#userAccessId').val(rowdata.id);
        $('#name').val(rowdata.full_name);
        $('#username').val(rowdata.username);
        // $('#password').val(rowdata.password);
        
        var selectedGroupOption = new Option(rowdata.group_desc, rowdata.group_id, true, true);
        $('[name="groupOpt"]').append(selectedGroupOption).trigger('change');
        
        var selectedPjpOption = new Option(rowdata.pjp_name, rowdata.pjp_id, true, true);
        $('[name="pjpOpt"]').append(selectedPjpOption).trigger('change');

        $('#email').val(rowdata.email);
        $('#phoneNumber').val(rowdata.phone_number);
        $('#address').val(rowdata.address);

    });

    $(".delete-row").on("click", function () {

        formId = false;

        var rowdata = window.userAccessGrid.table.row($(this).parents('tr')).data();

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_user_access';
        myAjax.async = false;
        myAjax.data = {
            id: rowdata.id,
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

}

$('#saveUserAccess').on('click', function () {

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-useraccess').each(function (index, element) {

        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {

            stopProcessing = true;

        }

    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = (formId == false) ? 'create_user_access' : 'update_user_access';

        _actionInsert($(this).parents('form'), 'Administration/User_access/ajax/' + action_url, '.insert-useraccess');

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

            window.userAccessGrid.table.draw();
            $('#userAccessForm')[0].reset();

        } else if (data.status == 500) {

            alert(data.message);

        } else {

            alert(data.message);

            window.userAccessGrid.table.draw();

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

