
var formId = false;

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    $("#userOpt").select2({
        ajax: {
            url: current_url + "/ajax/user_option",
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
        placeholder: 'User',
    });

    $("#permissionMenuOpt").select2({
        ajax: {
            url: current_url + "/ajax/permission_menu_option",
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
        placeholder: 'Menu',
    });

    var ruleAccessList = {
        id: 'ruleAccessList',
        column: [
            {
                "data": "action",
                "orderable": false
            },
            {
                "data": "menu_name",
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "create",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "read",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "update",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "delete",
                "orderable": false,
                "className": "text-left"
            },
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [30, 20, 10]
    }

    window.ruleAccessGrid = new grid(ruleAccessList);
    window.ruleAccessGrid.url = current_url + "/grid/rule_access_list";
    window.ruleAccessGrid.type = 'GET';
    window.ruleAccessGrid.data = { userId: $("#userOpt").val() };
    window.ruleAccessGrid.init();

    var table = ruleAccessGrid.getTablesID();

});

$("#userOpt").on('change', function(){

    window.ruleAccessGrid.data = { userId: $("#userOpt").val() };
    window.ruleAccessGrid.table.draw();

});

$('#resetRuleAccess').on('click', function () {

    _resetForm();

});

var _resetForm = function () {
    formId = false;

    $('#id').val('');
    $('#userOpt').empty().trigger('change');
    $('#permissionMenuOpt').empty().trigger('change');
}

var _gridAction = function () {

    $(".create").on('click', function() {

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'create_permission';
        myAjax.async = false;
        myAjax.data = {
            id: $(this).val(),
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

    $(".read").on('click', function() {

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'read_permission';
        myAjax.async = false;
        myAjax.data = {
            id: $(this).val(),
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

    $(".update").on('click', function() {

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'update_permission';
        myAjax.async = false;
        myAjax.data = {
            id: $(this).val(),
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

    $(".delete").on('click', function() {

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_permission';
        myAjax.async = false;
        myAjax.data = {
            id: $(this).val(),
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

    $(".update-row").on("click", function () {

        formId = true;

        var rowdata = window.ruleAccessGrid.table.row($(this).parents('tr')).data();

        $('#id').val(rowdata.id);

        var selectedUserOption = new Option(rowdata.user_group_name, rowdata.user_group_id, true, true);
        $('[name="userOpt"]').append(selectedUserOption).trigger('change');

        var selectedPermissionOption = new Option(rowdata.menu_name, rowdata.menu_id, true, true);
        $('[name="permissionMenuOpt"]').append(selectedPermissionOption).trigger('change');

    });

    $(".delete-row").on("click", function () {

        formId = false;

        var rowdata = window.ruleAccessGrid.table.row($(this).parents('tr')).data();

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_rule_access';
        myAjax.async = false;
        myAjax.data = {
            id: rowdata.id,
        };
        myAjax.callback = _actionCallback;
        myAjax.init();

    });

}

$('#saveRuleAccess').on('click', function () {

    var stopProcessing = false;

    $($(this).parents('form')).find('.insert-ruleaccess').each(function (index, element) {

        if ((($(this).val() == '') || ($(this).val() == null)) && ($(this).hasClass("validate"))) {

            stopProcessing = true;

        }

    });

    if (stopProcessing) {

        alert('Field masih kosong. Perhatikan data anda!');
        return false;

    } else {

        var action_url = (formId == false) ? 'create_rule_access' : 'update_rule_access';

        if ( formId == true ) {
            
            if (confirm('Apakah Anda yakin ingin meng-update menu? Jika tidak, silahkan klik tombol reset dan buat menu baru.')) {
    
                _actionInsert($(this).parents('form'), 'Administration/Rule_access/ajax/' + action_url, '.insert-ruleaccess');
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            _actionInsert($(this).parents('form'), 'Administration/Rule_access/ajax/' + action_url, '.insert-ruleaccess');
        
        }
        


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

            // alert(data.message);

            // _resetForm();

            window.ruleAccessGrid.table.draw();

        } else if (data.status == 500) {

            alert(data.message);

        } else {

            alert(data.message);

            window.ruleAccessGrid.table.draw();

        }
    } else {
        alert((data.message == "" ? "Check your input" : data.message));
    }
};

