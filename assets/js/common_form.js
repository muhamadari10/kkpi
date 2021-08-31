var validator = null;
var opts = {
	"closeButton"		: true,
	"debug"				: false,
	"positionClass"		: "toast-top-full-width",
	"onclick"			: null,
	"showDuration"		: "300",
	"hideDuration"		: "1000",
	"timeOut"			: "5000",
	"extendedTimeOut"	: "1000",
	"showEasing"		: "swing",
	"hideEasing"		: "linear",
	"showMethod"		: "fadeIn",
	"hideMethod"		: "fadeOut"
};
var CommonForm = {
	form_id 	: "grid",
	primary_id	: "grid",
	btn_id 		: "grid",
	val_rules 	: "grid",
	insert_id 	: false,
	formReset	: true,
	detail_id	: "grid",
	back 		: false,
	init 		: function(params){
		var that 		= this;
		this.btn_id 	= params.btn_id;
		this.form_id 	= params.form_id;
		this.primary_id = params.primary_id;
		this.val_rules 	= params.rules;
		this.val_messages = params.messages;
		this.formReset 	= params.reset;
		this.insert_id 	= params.insert_id;
		this.detail_id 	= params.detail_id;
		this.back 		= params.back;
		this.fileSelect_id = params.fileSelect_id;
		this.action(true);

		/** trigger when key press **/
		jQuery(document).keydown(function(e){
			var keyPress = that.onKeyPresEvent(e);
			return keyPress;
		});
	},
	action 		: function (){
		var that 	= this;
		var btn 	= jQuery("#" + this.btn_id);

		validator = jQuery("#" + this.form_id).validate({
			rules:this.val_rules,
			messages:this.val_messages,
			highlight 	: function(label){
				jQuery(label).closest('.form-group').removeClass('has-success');
				jQuery(label).closest('.form-group').addClass('has-error');
			},
			success 	: function(label){
				jQuery(label).closest('.form-group').removeClass('has-error');
				jQuery(label).closest('.form-group').addClass('has-success');
			},
			submitHandler:function(e){
				var that_form = e;
				btn.button('loading');
				if(typeof jQuery(that_form).attr('insert_id') === 'undefined'){
					var data = new FormData(jQuery(that_form)[0]);
					var opts = {
					    url			: jQuery(that_form).attr('action'),
					    data 		: data,
					    timeout 	: 3000,
					    cache 		: false,
					    contentType : false,
					    processData : false,
					    type 		: 'POST',
					    dataType	: "text",
					    success 	: function(response, textStatus, jqXHR){
							var data 		= jQuery.parseJSON(response);
							var is_status 	= toastr.success;

							if(data.msg.status === false)
							{
								is_status = toastr.error;
							}else{
								if(jQuery("#" + that.primary_id).length == 0)
								{
									if(that.formReset)
									{
										jQuery(that_form).trigger('reset');
									}
								}
							}

							if(that.insert_id)
							{
								jQuery(that_form).attr('insert_id', data.insert_id);
							}

							if((that.detail_id != "grid") && that.formReset)
							{
								jQuery("#" + that.detail_id).html("");
							}

							is_status(data.msg.custom_error, opts);
							btn.button('reset');

							// check data.data result
							if(typeof data.data === 'undefined')
								data['data'] = '';
							// hide modal
							if(typeof jQuery('#allModal').hasClass('modal') !== 'undefined'){
								if(typeof data.data.last_id === 'undefined')
									jQuery('#allModal').modal('hide');
								try {
									refresh();
								}
								catch(err) {
								    console.log(err);
								}
							}
							if(typeof jQuery('#modal').hasClass('modal') !== 'undefined'){
								jQuery('#modal').modal('hide');
							}

							// if(that.form_id == 'frmBank')
							// 	new_trans();

							if(that.back && data.msg.status)
							{
								window.history.back();
							}

							if(typeof data.data.last_id !== 'undefined'){
								// $('.btn_new').removeClass('hide');
								$.post(current_url+'reprint', function(res){
									// $('#allModal .modal-content').html(res)
									$('#allModal').modal('hide');
									$('#printArea').html(res);
									new_trans();
									window.print();
								});
							}
						},
						error: function(o){
							if(o.status == 500)
							{
								toastr.error("Saving error, error system", opts);
							}

							btn.button('reset');
						}
					};
					if(data.fake && that.fileSelect_id) {
					    // Make sure no text encoding stuff is done by xhr
					    opts.xhr = function() { var xhr = jQuery.ajaxSettings.xhr(); xhr.send = xhr.sendAsBinary; return xhr; }
					    opts.contentType = "multipart/form-data; boundary="+data.boundary;
					    opts.data = data.toString();
					}
					jQuery.ajax(opts);
				} else {
					toastr.success("Your data was save with id : " + jQuery(that_form).attr('insert_id'), opts);
					btn.button('reset');
				}
				return false;
			},
			invalidHandler: function(form, validator) {
				btn.button('reset');
				toastr.error("Has error. Please check again.", opts);
			}
		});
	},
	onClickEvent: function (obj){
		var status = jQuery(obj).attr("id");
		switch(status) {
			case 'back':
				window.open(jQuery(obj).attr("url"), "_self");
				break;
		}
	},
	onKeyPresEvent: function (event){
		var tables 	= this.aTable;
		var obj 	= event.keyCode
		var actions = false;

		if(event.ctrlKey)
		{
			/** back event **/
			if(event.which === 66){
				jQuery("#back").trigger("click");
			}
			/** save event **/
			if(event.which === 83){
				jQuery("#" + this.form_id).trigger('submit');
			}
			/** reset event **/
			if(event.which === 82){
				validator.resetForm();
				jQuery("#" + this.form_id).trigger('reset');
			}
			if (event.preventDefault)
			{
				event.preventDefault();
				event.stopPropagation();
			}
		}else actions = true;
		return actions;
	},
	readSelectFile: function (input,txt) {
	    if (input.files && input.files[0] && input.files.length != 0) {
	        var reader 	= new FileReader();
	        reader.onload = function (e) {
	        	e.preventDefault();
	            $('#file-img').attr('src', e.target.result);
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	    else if(input.id == 'remove-select' || input.files.length == 0){
	    	$('#file-img').attr('src', 'http://placehold.it/200x150&text='+txt+'+Logo');
	    }
	}
}
