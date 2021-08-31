
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Aktivitas
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Administrasi</a></li>
        <li class="active">Aktivitas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                        
                            <div class="col-xs-4">
                                <h3 class="box-title">Data Aktivitas</h3>
                            </div>
                            <div class="col-xs-8">
                                <button type="button" style="float:right;" class="btn bg-olive btn-flat" id="createActivity">Tambah</button>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:center;" id="activityList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center; min-width: 80px !important;">Config</th>
                                    <th style="text-align:center;">Nama Aktivitas</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">Config</th>
                                    <th style="text-align:center;">Nama Aktivitas</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>

<div class="modal fade" id="openModalCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="activityForm">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Form Aktivitas</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">

                            <input type="hidden" id="activityId" name="activityId" class="form-control insert-activity" />
                            
                            <div class="form-group">
                                <label>Nama Aktivitas</label>
                                <textarea name="activityName" id="activityName" class="form-control insert-activity validate" rows="3" placeholder="Nama Aktivitas"></textarea>
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="saveActivity" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
