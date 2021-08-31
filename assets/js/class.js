
// $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
//   if ( options.dataType == 'script' || originalOptions.dataType == 'script' ) {
//       options.cache = true;
//   }
// });

// AJAX FUNCTION
var ajax = function(){
  return {
    url           : false,
    method        : "POST",
    data          : {},
    async         : true,
    callback      : false,
    error_callback: false,
    timeout       : false,
    init          : function(){
      var t = this;
      if(t.url){
         $.ajax({
           url    : t.url,
           method : t.method,
           async  : true,
           cache  : false,
           timeout: t.timeout,
           data   : t.data,
           success: function(d,s,x){
             if(t.callback){
               if(typeof t.callback === 'function'){
                 t.callback(d,s,x);
               }
             } else
               t.callback = d;
           },
           error  : function(x,s){
             if(t.error_callback){
               if(typeof t.error_callback === 'function')
               t.error_callback(x,s);
               else
               console.log(x);
             } else
              console.log(x);
           }
         });
      }
    }
  }
}

var getUrlParameters = function(parameter, staticURL, decode) {

  var currLocation = (staticURL.length) ? staticURL : window.location.search,
    parArr = currLocation.split("?")[1].split("&"),
    returnBool = true;

  for (var i = 0; i < parArr.length; i++) {
    parr = parArr[i].split("=");
    if (parr[0] == parameter) {
      return (decode) ? decodeURIComponent(parr[1]) : parr[1];
      returnBool = true;
    } else {
      returnBool = false;
    }
  }

  if (!returnBool) return false;
}

String.prototype.ucfirst = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

var serialize = function(obj, prefix) {
  var str = [];
  for(var p in obj) {
    if (obj.hasOwnProperty(p)) {
      var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
      str.push(typeof v == "object" ?
        serialize(v, k) :
        encodeURIComponent(k) + "=" + encodeURIComponent(v));
    }
  }
  return str.join("&");
}

var upCase = function(t){
  if(t !== null)
    return t.charAt(0).toUpperCase() + t.slice(1);
}

var count = function(t){
  var c = 0;
  for( var k in t){
    if(t.hasOwnProperty(k))
      c++;
  }
  return c;
}



// DATAGRID WITH DETAIL
function grid(r) {
  var v     = typeof r == 'object'?r:false;
  var grid  = {
    id      : v?(typeof v.id !== 'undefined'?v.id:'grid'):'grid',
    server  : v?(typeof v.server !== 'undefined'? v.server:true):true,
    search  : v?(typeof v.search !== 'undefined'? v.search:true):true,
    url     : v?(typeof v.url === 'function'?v.url:false):false,
    type    : v?(typeof v.type === 'function'?v.type:'POST'):'POST',
    detail  : v?(typeof v.detail === 'function'?v.detail:false):false,
    column  : v?(typeof v.column === 'object'?v.column:false):false,
    data    : v?(typeof v.data === 'object'?v.data:{}):{},
    pagination  : v?(typeof v.pagination === 'object'?v.pagination:true):true,
    info  : v?(typeof v.info !== 'undefined'?v.info:true):true,
    length  : v?(typeof v.length !== 'undefined'?v.length:false):false,
    scrollY  : v?(typeof v.scrollY !== 'undefined'?v.scrollY:false):false,
    scrollX  : v?(typeof v.scrollX !== 'undefined'?v.scrollX:false):false,
    filter  : v?(typeof v.filter === 'object'?v.filter:false):false,
    ordering   : v?(typeof v.ordering !== 'undefined'?v.ordering:true):true,
    order   : v?(typeof v.order === 'object'?v.order:false):false,
    button  : v?(typeof v.button === 'object'?v.button:[]):[],
    function: v?(typeof v.function === 'function'?v.function:false):false,
    cache   : false,
    table   : false,
    init    : function(){
      var t = this;
      if(t.url){
        t.table = $('#'+t.id).DataTable({
            "serverSide"  : t.server,
            "processing"  : true,
            "responsive"  : true,
            "searching"   : t.search,
            "stateSave"   : true,
            "cache"       : t.cache,
            "columns"     : t.column,
            "buttons"     : t.button,
            'dom': 'lBfrtip',
            // buttons: [
            //   { extend: 'copyHtml5', className: 'btn bg-default btn-xs' },
            //   { 
            //     extend: 'excelHtml5', 
            //     className: 'btn bg-success btn-xs'
            //   },
            //   { extend: 'csvHtml5', className: 'btn bg-red btn-xs' },
            //   // { extend: 'pdfHtml5', className: 'btn bg-blue btn-xs' },
            //   // 'copyHtml5',
            //   // 'excelHtml5',
            //   // 'csvHtml5',
            //   // 'pdfHtml5'
            // ],
            "autoWidth": true,
            "lengthMenu": t.length,
            "ajax"        : {
              'url'   : t.url,
              'type'  : t.type,
              'data'  : function ( d ) {
                  d.extra_search = t.data;
            },
            'async' : true
            },
            "deferRender": true,
            "fnPreDrawCallback":function(){
              $('#'+t.id+'_processing').attr('style', 'display: block; z-index: 10000 !important');
            },
            "fnServerParams" : function(ds){
            var tmp = {};
            if(t.filter){
              $('.'+t.filter).each(function(k,v){
                if($(this).attr('name') !== 'undefined' && $(this).val() !== '')
                  tmp[$(this).attr('name')] = $(this).val();
              });
            }
            ds.filter = tmp;
            },
            "info"          : t.info,
            "ordering"      : t.ordering,
            "order"         : t.order?t.order:[[0,'asc']],
            "paging"        : t.pagination,
            "fnDrawCallback": function(){
            if(t.detail){
              var detailRows = [];
              $('#'+t.id+' tbody tr td.details-control').click(function(){

                var tr  = $(this).closest('tr');
                var td  = $(this).closest('td');
                var icon = $(td[0]).closest('i');
                var row = t.table.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                  row.child.hide();
                  tr.removeClass( 'shown' );
                  td.find('i').removeClass( 'glyphicon glyphicon-minus' );
                  td.find('i').addClass( 'glyphicon glyphicon-plus' );
                  
                  // Remove from the 'open' array
                  detailRows.splice( idx, 1 );
                } else {
                  row.child( t.detail(row.data()) ).show();
                  tr.addClass( 'shown' );
                  td.find('i').removeClass( 'glyphicon glyphicon-plus' );
                  td.find('i').addClass( 'glyphicon glyphicon-minus' );

                  // Add to the 'open' array
                  if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                  }
                }
              });
              $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
              } );
            }

            if(t.function){
              t.function();
            }
            },
            // "footerCallback": function ( row, data, start, end, display ) {
            // if(typeof row !== 'undefined'){
            //   var api   = this.api(), data;
            //   var info  = api.page.info();

            //    // Remove the formatting to get integer data for summation
            //    var intVal = function ( i ) {
            //    return typeof i === 'string' ?
            //    i.replace(/[\$,]/g, '')*1 :
            //    typeof i === 'number' ?
            //    i : 0;
            //    };

            //   //  if(info.page+1 === info.pages){
            //   //  total = api
            //   //  .column( 5 )
            //   //  .data()
            //   //  .reduce( function (a, b) {
            //   //  return intVal(a) + intVal(b);
            //   //  }, 0 );

            //   //  var sum = api.data();

            //   //  $('.datagrid-footer').attr('style','');
            //   //  $( api.column( 0 ).footer() ).html('Total Members');
            //   //  $( api.column( 1 ).footer() ).html(sum.length);
            //   //  $( api.column( 4 ).footer() ).html('Total Credits');
            //   //  $( api.column( 5 ).footer() ).html(total);
            //   //  }else{
            //   //  $('.datagrid-footer').attr('style', 'display:none');
            //   //  }
            // }
            // }
        });
      }
    },
    getTablesID:function()
    {
      return this.table;
    }
  };
  return grid;
}
