
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proyek
        <!-- <small>Proyek</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li><a href="#">Proyek</a></li>
        <li class="active">Penjadwalan</li>
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
                                <h3 class="box-title">Data Penjadwalan</h3>
                            </div>
                            <div class="col-xs-8">
                                <button type="button" style="float:right;" class="btn bg-olive btn-flat" id="createSchedule">Tambah</button>
                            </div>

                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-xs-2">
                                <div class="form-group">
                                    <select id="projectFilter" name="projectFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <select id="pjpFilter" name="pjpFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <select id="sectorFilter" name="sectorFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <button type="button" class="btn bg-blue btn-flat" id="scheduleFilter">Cari</button>
                                </div>
                            </div>
                            
                        </div>
                        <hr>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:center;" id="scheduleList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center; min-width: 80px !important;">Config</th>
                                    <th style="text-align:center;">Aktivitas</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Rencana Mulai</th>
                                    <th style="text-align:center;">Aktual Mulai</th>
                                    <th style="text-align:center;">Deviasi</th>
                                    <th style="text-align:center;">Rencana Selesai</th>
                                    <th style="text-align:center;">Aktual Selesai</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">Config</th>
                                    <th style="text-align:center;">Aktivitas</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Rencana Mulai</th>
                                    <th style="text-align:center;">Aktual Mulai</th>
                                    <th style="text-align:center;">Deviasi</th>
                                    <th style="text-align:center;">Rencana Selesai</th>
                                    <th style="text-align:center;">Aktual Selesai</th>
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
            <form id="scheduleForm">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Form Penjadwalan</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">

                            <input type="hidden" id="scheduleId" name="scheduleId" class="form-control insert-schedule" />
                            
                            <div class="form-group">
                                <label>Proyek</label>
                                <select id="projectOpt" name="projectOpt" class="form-control insert-schedule validate" style="width: 100%" required>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>PJP</label>
                                <select id="pjpOpt" name="pjpOpt" class="form-control insert-schedule validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sektor</label>
                                <select id="sectorOpt" name="sectorOpt" class="form-control insert-schedule validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nama Aktivitas</label>
                                <textarea name="scheduleActivityName" id="scheduleActivityName" class="form-control insert-schedule validate" rows="3" placeholder="Nama Aktivitas"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Status Jadwal</label>
                                <textarea name="scheduleStatus" id="scheduleStatus" class="form-control insert-schedule validate" rows="3" placeholder="Status Jadwal"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Deviasi</label>
                                <textarea name="deviation" id="deviation" class="form-control insert-schedule validate" rows="3" placeholder="Deviasi"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Rencana Mulai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="startPlanDate" name="startPlanDate" type="text" class="form-control pull-right insert-schedule validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Aktual Mulai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="startActualDate" name="startActualDate" type="text" class="form-control pull-right insert-schedule validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Rencana Selesai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="endPlanDate" name="endPlanDate" type="text" class="form-control pull-right insert-schedule validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Aktual Selesai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="endActualDate" name="endActualDate" type="text" class="form-control pull-right insert-schedule validate">
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="saveSchedule" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
