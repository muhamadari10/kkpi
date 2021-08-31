
$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    var projectImgList = {
        id: 'projectImgList',
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
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "project_img_name",
                "orderable": false
            },
            {
                "data": "pjp_name",
                "orderable": false
            },
            {
                "data": "sector_name",
                "orderable": false,
                "className": "text-left"
            },
            {
                "data": "operation_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
        ],
        function: _gridAction,
        order: [[1, 'desc']],
        length: [10, 20, 30]
    }

    window.projectImgGrid = new grid(projectImgList);
    window.projectImgGrid.url = current_url + "/grid/project_img_list";
    window.projectImgGrid.type = 'GET';
    window.projectImgGrid.init();

    var table = projectImgGrid.getTablesID();

});


var _gridAction = function () {

    // $(".update-row").on("click", function () {

    //     var rowdata = window.projectImgGrid.table.row($(this).parents('tr')).data();

    // });

    // $(".delete-row").on("click", function () {

    //     var rowdata = window.projectImgGrid.table.row($(this).parents('tr')).data();

    // });

}

