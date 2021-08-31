
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proyek
        <!-- <small>Proyek</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Proyek</a></li>
        <li class="active">Isu</li>
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
                                <h3 class="box-title">Data Isu</h3>
                            </div>
                            <div class="col-xs-8">
                                <button type="button" style="float:right;" class="btn bg-olive btn-flat" id="createIssue">Tambah</button>
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
                                    <select id="phaseFilter" name="phaseFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <select id="activityFilter" name="activityFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <?php 
                                if($_SESSION['pjp_name'] == 'ALL') // custom stakholder
                                    echo '<div class="col-xs-2"><div class="form-group"><select id="stakeholderFilter" name="stakeholderFilter" class="form-control" style="width: 100%" required></select></div></div>' 
                            ?>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <button type="button" class="btn bg-blue btn-flat" id="issueFilter">Cari</button>
                                </div>
                            </div>
                            
                        </div>
                        <hr>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:center;" id="issueList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center; min-width: 80px !important;">Config</th>
                                    <th style="text-align:center;">No. PSN</th>
                                    <th style="text-align:center;">Proyek</th>
                                    <th style="text-align:center;">Isu</th>
                                    <th style="text-align:center;">Dampak</th>
                                    <th style="text-align:center;">Tgl. Terjadi</th>
                                    <th style="text-align:center;">Tgl. Penyelesaian</th>
                                    <th style="text-align:center;">Tingkat Keparahan</th>
                                    <th style="text-align:center;">Tingkat Frekuensi</th>
                                    <th style="text-align:center;">Stakeholder</th>
                                    <th style="text-align:center;">Jenis Isu</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">Config</th>
                                    <th style="text-align:center;">No. PSN</th>
                                    <th style="text-align:center;">Proyek</th>
                                    <th style="text-align:center;">Isu</th>
                                    <th style="text-align:center;">Dampak</th>
                                    <th style="text-align:center;">Tgl. Terjadi</th>
                                    <th style="text-align:center;">Tgl. Penyelesaian</th>
                                    <th style="text-align:center;">Tingkat Keparahan</th>
                                    <th style="text-align:center;">Tingkat Frekuensi</th>
                                    <th style="text-align:center;">Stakeholder</th>
                                    <th style="text-align:center;">Jenis Isu</th>
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
            <form id="issueForm">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Form Isu</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">

                            <input type="hidden" id="issueId" name="issueId" class="form-control insert-issue" />
                            
                            <div class="form-group">
                                <label>Proyek</label>
                                <select id="projectOpt" name="projectOpt" class="form-control insert-issue validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Isu</label>
                                <textarea name="issueDescription" id="issueDescription" class="form-control insert-issue validate" rows="3" placeholder="Deskripsi Isu"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Jenis</label>
                                <select id="issueTypeOpt" name="issueTypeOpt" class="form-control insert-issue validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Terjadi Isu</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="caseIssueDate" name="caseIssueDate" type="text" class="form-control pull-right insert-issue validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Rencana Penyelesaian</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="planningSolveIssueDate" name="planningSolveIssueDate" type="text" class="form-control pull-right insert-issue validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Dampak</label>
                                <textarea name="impactDuration" id="impactDuration" class="form-control insert-issue validate" rows="3" placeholder="Dampak Terhadap Durasi Proyek"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Tingkat Frekuensi Terjadinya Isu</label>
                                <select id="frequencyLevelOpt" name="frequencyLevelOpt" class="form-control insert-issue validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tingkat Keparahan Terjadinya Isu</label>
                                <select id="severityLevelOpt" name="severityLevelOpt" class="form-control insert-issue validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Stakeholder</label>
                                <select multiple="multiple" id="stakeholderOpt" name="stakeholderOpt" class="form-control insert-issue validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fase</label>
                                <select id="phaseOpt" name="phaseOpt" class="form-control insert-issue validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Aktivitas</label>
                                <select id="activityOpt" name="activityOpt" class="form-control insert-issue validate" style="width: 100%" required>
                                </select>
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="saveIssue" class="btn btn-primary btn-status"><i class=""></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
