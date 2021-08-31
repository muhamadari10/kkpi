// $("#uploadFishImg").dropzone(
//     { 
//         url: current_url + "/ajax/upload_fish_img", 
//     }
// );

$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {
    
    Dropzone.autoDiscover = false;
    Dropzone.options.myAwesomeDropzone = false;

    var myDropzone = new Dropzone("#uploadProjectImg", {
        url: current_url + "/ajax/upload_project_img" ,
        params: { projectId: getUrlParameters("projectId", document.location.href, true) },
        addRemoveLinks: true,
        dictDefaultMessage: "<img class='add_new' src=' " + base_url + "assets/images/upload.png'><img class='add_more' src=' " + base_url +"assets/images/upload.png'><br/><small>Click to upload your photos</small><h3>Drag and drop your photos here to upload</h3>",
        init: function () {
            
            var initThis = this;

            // console.log(initThis);

            var myAjax2 = new ajax();
            myAjax2.url = current_url + '/ajax/' + 'uploaded_project_list';
            myAjax2.data = { projectId: getUrlParameters("projectId", document.location.href, true) };
            myAjax2.async = false;
            myAjax2.callback = function (data, status, xhr) {
                var data = JSON.parse(data);

                console.log(data);

                if (xhr.status == 200) {
                    if (data.status) {

                        for (var i = 0; i < data.data.length; i++) {

                            var mockFile = {
                                name: data.data[i].caption,
                                url: data.data[i].url,
                                size: data.data[i].size
                            };

                            // initThis.files.push(mockFile);
                            // initThis.emit('addedfile', mockFile);
                            // initThis.createThumbnailFromUrl(mockFile, mockFile.url + data.data[i].img);
                            // console.log(mockFile.url + data.data[i].img);
                            // initThis.emit('complete', mockFile);

                            initThis.emit("addedfile", mockFile);
                            initThis.files.push(mockFile);
                            initThis.emit('thumbnail', mockFile, mockFile.url + data.data[i].img);
                            initThis.emit("complete", mockFile);



                            // console.log(initThis.emit('complete', mockFile));

                        }

                    } else {
                        // var $toastContent = $('<span>' + data.message + '</span>');
                        // Materialize.toast($toastContent, 4000);

                        // alert(data.message);

                        // alert(data.message);
                    }
                } else {
                    alert((data.message == "" ? "Check your input" : data.message));
                }
            };
            myAjax2.init();

        }
    });

    myDropzone.on("addedfile", function (file) {

        // var $toastContent = $('<span>' + file.name + ' attached</span>');
        // Materialize.toast($toastContent, 4000);

        // alert(file.name);

    });

    myDropzone.on("success", function (dt) {
        console.log(dt);

        try {

            var dtDet = JSON.parse(dt.xhr.response);

            // var $toastContent = $('<span>' + dtDet.message + '</span>');
            // Materialize.toast($toastContent, 4000);

            // alert(dtDet.message);

        } catch (error) {

            alert(error);

        }

    });

    myDropzone.on("removedfile", function (dt) {
        // console.log(dt);

        var myAjax = new ajax();
        myAjax.url = current_url + '/ajax/' + 'delete_uploaded_project';
        myAjax.async = false;
        myAjax.data = {
            projectId: getUrlParameters("projectId", document.location.href, true),
            id: dt.name,
        };
        myAjax.callback = function (data, status, xhr) {
            var data = JSON.parse(data);
            if (xhr.status == 200) {
                if (data.status) {

                    // var $toastContent = $('<span>' + data.message + '</span>');
                    // Materialize.toast($toastContent, 4000);

                    alert(data.message);

                } else {
                    // var $toastContent = $('<span>' + data.message + '! ' + 'Mohon refresh halaman Anda.' + '</span>');
                    // Materialize.toast($toastContent, 4000);
                    alert(data.message);

                    alert(data.message + '! ' + 'Mohon refresh halaman Anda.');
                }
            } else {
                alert((data.message == "" ? "Check your input" : data.message));
            }
        };
        myAjax.init();

    });

    myDropzone.on("error", function (dt) {
        // console.log(dt);

        try {

            var dtDet = JSON.parse(dt.xhr.response);

            // var $toastContent = $('<span>' + dtDet.message + '</span>');
            // Materialize.toast($toastContent, 4000);
            alert(dtDet.message);


        } catch (error) {

            alert(error);

        }

    });
    
})