var opts = {
	"closeButton"		: true,
	"debug"				: false,
	"positionClass"		: "toast-top-right",
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
var CommonList = {
	grid_id		: "grid",
	dimensi		: {},
	url_grid	: null,
	url_detail	: null,
	searcable   : true, 
	lengthPage  : true,
	selected	: false,
	order		: [[1, 'asc']],
	aTable		: null,
	init		: function (aColumn) {
					var that = this;
					this.aTable = $('#' + this.grid_id).DataTable(
						{
							"searching"     : this.searcable,
							"lengthChange"  : this.lengthPage,
							"bServerSide"	: true,
							"bProcessing"	: true,
							"aoColumns"		: aColumn,
							"order"			: that.order,
							"sAjaxSource"	: this.url_grid,
							"fnServerParams": function ( aoData )
							{
								if($("#frmFilter"))
								{
									var postData = $("#frmFilter").serializeArray();
									$.each(postData, function(i, val) {
										aoData.push(val);
									});
								}
							},
							"fnDrawCallback": function(oSettings){
								$('.opr_click').click(
									function(obj){
										if($(this).closest('tr').find(".check").is(':checked'))
										{
											$(this).closest('tr').find(".check").prop('checked', false);
										}
										else
										{
											$(this).closest('tr').find(".check").prop('checked', true);
										}

										if($(this).attr('value') == "editRow")
										{
											var url = $(this).attr('href');
											that.edit(that.dimensi, "");
										}
										else if($(this).attr('value') == "editRow2")
										{
											editRewardSetup();
										}
										else if($(this).attr('value') == "viewRow")
										{
											that.view(that.dimensi, $(this).attr("href"));
										}
										else
										{
											that.remove(this);
										}

										return false;
									}
								);

								$('.pick_member').click(function(e){
									var id = $(this).attr('data_id');
									parent.memberPick(id);
									return false;
								});

								$('.pick_bill').click(function(e){
									var id = $(this).attr('data_id');
									parent.open_bill(id);
									return false;
								});

								$('.activeData').click(function(e){
									var val 	= $(this).prop('checked');
									var active 	= 1;

									if(val == true)
									{
										active = 2;
									}

									$.post(current_url + '/activeData/',{id : this.value, active : active}, function(response) {
										var data 		= $.parseJSON(response);
										var is_status 	= toastr.error;

										if(data.msg.status === true)
										{
											is_status = toastr.success;
										}

										tables.draw();
										is_status(data.msg.custom_error, opts);
									});
								});
								if(that.grid_id == 'table-receipt')
									sel_tr(that.selected,that.grid_id);
								
								$('.creditPayment').click(function(e){
									var val  = $(this).prop('checked');
									var payment = 0;

									if(val == true)
									{
										payment = 1;
									}

									$.post(current_url + '/setCreditPayment/',{id : this.value, payment : payment}, function(response) {
										var data   = $.parseJSON(response);
										var is_status  = toastr.error;

										if(data.msg.status === true)
										{
											is_status = toastr.success;
											tables.draw();
										}

										is_status(data.msg.custom_error, opts);
									});
								});

								$('.multiplePayment').click(function(e){
									var val  = $(this).prop('checked');
									var multiple = 1;

									if(val == true)
									{
										multiple = 2;
									}

									$.post(current_url + '/multiplePayment/',{id : this.value, multiple : multiple}, function(response) {
										var data   = $.parseJSON(response);
										var is_status  = toastr.error;

										if(data.msg.status === true)
										{
											is_status = toastr.success;
											tables.draw();
										}

										is_status(data.msg.custom_error, opts);
									});
								});
							}
						}
					);

					var tables 	= this.aTable;
					var sum 	= 0;
					$('#' + this.grid_id).on( 'click', 'tr', function(){
							if($(this).find(".check").is(':checked'))
							{
								$(this).find(".check").prop('checked', false);
								that.sumSelectedPoint();
							}
							else
							{
								$(this).find(".check").prop('checked', true);
								that.sumSelectedPoint();
							}
						}
					);

					function sel_tr(sel, id){
						if(sel){
							$('#'+id+' tbody tr').click(function(){
								if($('#'+id+' tbody tr').removeClass('active'))
									$(this).addClass('active');
								if(!$('.edif, .eden').hasClass('hide'))
									$('.edif, .eden').addClass('hide');
								// $.post(current_url+'/check_close', {'id': $(this).children('td:nth-child(2)').html()}, function(res){
								// 	if(res == 'true')
								// 		$('.edif, .eden').removeClass('hide');
								// });
							});
						}
					}

					function format ( dataSource, el ) {
						var data = new Object;
						console.log(el);
						data['id'] = dataSource[1];
						$.post(that.url_detail, data, function(th){
							$(el).parent('tr').next().children('td').html(th);
						});
						return "";  
					}

					$('#'+this.grid_id+' tbody').on('click', 'td.details-control', function () {
						var tr = $(this).closest('tr');
						var row = tables.row( tr );

						if ( row.child.isShown() ) {
							// This row is already open - close it
							row.child.hide();
							tr.removeClass('shown');
						}
						else {
							// Open this row
							row.child( format(row.data(), $(this)) ).show();
							tr.addClass('shown');
						}
					});
				},
	add			: function (params,type){
					var uri 	= current_url + "/add/";
					var tables 	= this.aTable;
					var that 	= this;

					$.get(current_url + "/add", function(response) {
						$('#modal .modal-content').html(response);
					}).done(function(){
						$('.modal-dialog').attr('style','width:'+params.width);
						$('#modal').modal('show', {backdrop: 'static'}).on('hidden.bs.modal', function () {
							that.aTable.draw();
							$(this).unbind();
						});
					});
				},
	edit		: function (params, type){
					var n 		= $("#" + this.grid_id + " > tbody").find("input:checked.check").length;
					var uri 	= $("#" + this.grid_id + " > tbody").find("input:checked.check").attr("uri");
					var tables 	= this.aTable;
					var that = this;

					if(n > 0)
					{
						if(n > 1)
						{
							alert("edit can't more than one");
						}
						else
						{
							$.get(uri, function(response) {
								$('#modal .modal-content').html(response);
							}).done(function(){
								$('.modal-dialog').attr('style','width:'+params.width);
								$('#modal').modal('show', {backdrop: 'static'}).on('hidden.bs.modal', function () {
									that.aTable.draw();
								});
							});
						}
					}
					else
					{
						alert("select the row to be changed");
					}
				},
	editLink	: function (params, type){
					var n 		= $("#" + this.grid_id + " > tbody").find("input:checked.check").length;
					var uri 	= $("#" + this.grid_id + " > tbody").find("input:checked.check").attr("uri");
					var tables 	= this.aTable;
					var that = this;

					if(n > 0)
					{
						if(n > 1)
						{
							alert("edit can't more than one");
						}
						else
						{
							window.location.href = uri;
						}
					}
					else
					{
						alert("select the row to be changed");
					}
				},
	view 		: function (params, uri){
					var tables 	= this.aTable;
					var that = this;
					$.get(uri, function(response) {
						$('#modal .modal-content').html(response);
					}).done(function(){
						$('#modal .modal-dialog').attr('style','width:'+params.width);
						$('#modal').modal('show', {backdrop: 'static'}).on('hidden.bs.modal', function () {
							that.aTable.draw();
							$(this).unbind();
						});
					});
	},
	remove		: function (type){
					var n 		= $("#" + this.grid_id + " > tbody").find("input:checked.check").length;
					var body	= this.grid_id;
					var uri 	= current_url + '/delete';
					var tables 	= this.aTable;
					var that = this;

					if(n > 0)
					{
						var data_post = [];

						$("#" + body + " > tbody").find("input:checked.check").each(function(){
								data_post.push({'id':$(this).attr('value')});
						});

						var conf = confirm('are you sure, to remove??');
						if(conf)
						{
							$.ajax({
								type	: "POST",
								url		: uri,
								data	: {data:data_post},
								dataType: "text",
								timeout	: 3000,
								success	: function(response){
											var data 		= $.parseJSON(response);
											var is_status 	= toastr.error;

											if(data.msg.status === true){
												is_status = toastr.success;
												tables.draw();
											}

											is_status(data.msg.custom_error, opts);
										},
								error	: function(){}
							});
						}
					}
					else
					{
						alert("select the row to be remove");
					}
				},
	onCheckAll	: function (obj){
					var tables 	= this.aTable;
					var point 	= 0;

					if($(obj).is(":checked"))
					{
						$("#" + this.grid_id + " > tbody").find(".check").prop('checked', true);
						this.sumSelectedPoint();
					}
					else
					{
						$("#" + this.grid_id + " > tbody").find(".check").prop('checked', false);
						this.sumSelectedPoint();
					}
				},
	sumSelectedPoint: function(){
		var sum = 0;

	    $("#" + this.grid_id + " > tbody").find("input:checked").each(function(){
		    sum += parseInt($(this).attr('point'));
	    });
		
		$('#redeemPoint').val(sum);
	},
	onClickEvent: function (obj){
		var status 	= $(obj).attr("id");
		
		switch(status) {
			case 'create':
				window.open(current_url + "/add", "_self");
				break;
			case 'edit':
				this.edit(this.dimensi,"");
				break;
			case 'editLink':
				this.editLink();
				break;
			case 'view':
				this.view(this.dimensi,uri);
				break;
			case 'remove':
				this.remove("");
				break;
		}
	},
	onKeyPresEvent: function (event){
		var tables 	= this.aTable;
		var obj 	= event.keyCode;
		var actions = false;

		var number_key = {
			48:0,
			49:1,
			50:2,
			51:3,
			52:4,
			53:5,
			54:6,
			55:7,
			56:8,
			57:9
		};

		if(event.ctrlKey)
		{
			if(event.which in number_key)
			{
				var idx = number_key[event.which];
				var index = null;
				
				if(idx < 10)
				{
					index = idx - 1;
				}
				else if (idx == 0)
				{
					index = 9;
				}

				var aData = tables.fnGetData(index);
				
				if(aData != null)
				{
					if($("#check_" + aData[1]).is(':checked'))
					{
						$("#check_" + aData[1]).prop('checked', false);
					}
					else
					{
						$("#check_" + aData[1]).prop('checked', true);
					}
				}
			}
			else
			{
				switch(event.which) {
					case 65:
						$("#menu_check").trigger('click');
						break;
					case 78:
						this.add(this.dimensi, "keyPress");
						break;
					case 77:
						this.edit(this.dimensi,"keyPress");
						break;
					case 88:
						this.remove("keyPress");
						break;
					case 70:
						$(".dataTables_filter").find('input').focus();
						break;
				}
			}
			
			if (event.preventDefault)
			{
				event.preventDefault();
				event.stopPropagation();
			}
		}
		else
		{
			switch(obj) {
				case 113:
					this.add(this.dimensi,"keyPress");
					break;
				case 114:
					this.edit(this.dimensi,"keyPress");
					break;
				case 115:
					this.remove("keyPress");
					break;
				default:
					actions = true;
			}
		}
		return actions;
	},
	getTablesID:function()
	{
		return this.aTable;
	}
}