<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Dashboard
        <small>Komite Percepatan Penyediaan Infrastruktur Prioritas</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-xs-4">
                <div class="form-group">
                    <select id="pjpOpt" name="pjpOpt" class="form-control" style="width: 100%" required></select>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group">
                    <select id="sectorOpt" name="sectorOpt" class="form-control" style="width: 100%" required></select>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group">
                    <button type="button" class="btn bg-blue btn-flat" id="dashboardSubmit">Cari</button>
                </div>
            </div>
            
        </div>

        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Status Proyek</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="activityChart" style="height: 300px; position: relative;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Pendanaan</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="fundIndicationChart" style="height: 300px; position: relative;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Jenis Isu</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="issueChart" style="height: 300px; position: relative;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Keterangan Status Proyek</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10px">#</th>
                                <td>Deskripsi</td>
                                <td style="width: 100px">Total Proyek</td>
                            </tr>
                            <tr>
                                <td><span class="badge statdesign-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-statdesign">
                                            <span data-statdesign="0" class="statdesign-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge statdesign-bg statdesign-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge statpreparation-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-statpreparation">
                                            <span data-statpreparation="0" class="statpreparation-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge statpreparation-bg statpreparation-value"></span></td>
                            </tr>

                            <tr>
                                <td><span class="badge stattransaction-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-stattransaction">
                                            <span data-stattransaction="0" class="stattransaction-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge stattransaction-bg stattransaction-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge constructionAfter2019-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-constructionAfter2019">
                                            <span data-constructionAfter2019="0" class="constructionAfter2019-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge constructionAfter2019-bg constructionAfter2019-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge constructionOperation2019-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-constructionOperation2019">
                                            <span data-constructionOperation2019="0" class="constructionOperation2019-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge constructionOperation2019-bg constructionOperation2019-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge constructionAndOperation-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-constructionAndOperation">
                                            <span data-constructionAndOperation="0" class="constructionAndOperation-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge constructionAndOperation-bg constructionAndOperation-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge constructionOperation2018-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-constructionOperation2018">
                                            <span data-constructionOperation2018="0" class="constructionOperation2018-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge constructionOperation2018-bg constructionOperation2018-value"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Keterangan Pendanaan</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10px">#</th>
                                <td>Deskripsi</td>
                                <td style="width: 100px">Jumlah Dana</td>
                            </tr>
                            <tr>
                                <td><span class="badge statapbnd-bg">#</span></td>
                                <td><strong><span class="statapbnd-description"></span></strong></td>
                                <td><span class="badge statapbnd-bg statapbnd-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge statbumnd-bg">#</span></td>
                                <td><strong><span class="statbumnd-description"></span></strong></td>
                                <td><span class="badge statbumnd-bg statbumnd-value"></span></td>
                            </tr>

                            <tr>
                                <td><span class="badge statswasta-bg">#</span></td>
                                <td><strong><span class="statswasta-description"></span></strong></td>
                                <td><span class="badge statswasta-bg statswasta-value"></span></td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Keterangan Jenis Isu</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10px">#</th>
                                <td>Deskripsi</td>
                                <td style="width: 100px">Total Proyek</td>
                            </tr>
                            <tr>
                                <td><span class="badge issstatconstruction-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-issstatconstruction">
                                            <span data-issstatconstruction="0" class="issstatconstruction-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge bg-light-blue issstatconstruction-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge statlicensing-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-statlicensing">
                                            <span data-statlicensing="0" class="statlicensing-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge statlicensing-bg statlicensing-value"></span></td>
                            </tr>

                            <tr>
                                <td><span class="badge statfund-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-statfund">
                                            <span data-statfund="0" class="statfund-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge statfund-bg statfund-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge statlandacquisition-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-statlandacquisition">
                                            <span data-statlandacquisition="0" class="statlandacquisition-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge statlandacquisition-bg statlandacquisition-value"></span></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge statplanning-bg">#</span></td>
                                <td>
                                    <strong>
                                        <a href="javascript:void(0)" class="btn-statplanning">
                                            <span data-statplanning="0" class="statplanning-description"></span>
                                        </a>
                                    </strong>
                                </td>
                                <td><span class="badge statplanning-bg statplanning-value"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<div class="modal fade" id="openModalProject">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" id="createCloseTopModalProjectInfo" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title box-project-info">Project Info</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">

                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Project Information</h3>
                                    <i class="btn-status fa fa-spin fa-refresh"></i>
                                    <!-- <div class="box-tools pull-right">
                                    </div> -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table no-margin" style="overflow-y: scroll; height: 200px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>No. PSN</th>
                                                    <th>Project</th>
                                                    <th>Sektor</th>
                                                    <th>PJP</th>
                                                    <th>Indikasi Dana</th>
                                                    <!-- <th>Dana APBN/APBD</th>
                                                    <th>Dana BUMN/BUMD</th>
                                                    <th>Dana Swasta</th> -->
                                                    <th>Jumlah Dana</th>
                                                </tr>
                                            </thead>
                                            <tbody id="projectInfoList">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.box-body -->
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="createCloseBottomModalProjectInfo">Close</button>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="openModalResume">
    <div class="modal-dialog modal-980">
        <div class="modal-content">
            <form id="resumeForm">
            
                <div class="modal-header">
                    <button type="button" class="close" id="createCloseTopModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Resume Project <i class="btn-status-resume fa fa-spin fa-refresh"></i></h4>
                </div>
                
                <div class="modal-body">
                    

                    <div class="row">
                        <div class="col-md-3">

                            <div class="box box-success">
                                <div class="box-body">

                                    <strong>Nama Proyek</strong>

                                    <p class="text-muted" id="project-name">
                                        -
                                    </p>

                                    <hr>

                                    <strong>Penanggung Jawab</strong>

                                    <p class="text-muted" id="pjp">
                                        -
                                    </p>

                                    <hr>
                                    
                                    <strong>No. PSN</strong>

                                    <p class="text-muted" id="external-code">
                                        -
                                    </p>

                                    <hr>

                                    <strong>Kontak Person</strong>

                                    <p class="text-muted" id="contact-person">
                                        -
                                    </p>

                                    <hr>

                                    <strong>Output</strong>

                                    <p class="text-muted" id="output">
                                        -
                                    </p>

                                    <hr>

                                    <strong>Mata Uang</strong>

                                    <p class="text-muted" id="currency">
                                        -
                                    </p>

                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-4">

                            <div class="box box-success">
                                <!-- /.box-header -->
                                <div class="box-body">


                                    <strong><i class="fa fa-map-marker margin-r-5"></i> Sektor</strong>

                                    <p class="text-muted" id="sector">
                                        -
                                    </p>

                                    <hr>

                                    <strong><i class="fa fa-map-marker margin-r-5"></i> Lokasi</strong>

                                    <p class="text-muted" id="province-island">
                                        -
                                    </p>

                                    <hr>

                                    <strong><i class="fa fa-money margin-r-5"></i> Indikasi Dana</strong>

                                    <p id="fund-indication">
                                        -
                                    </p>

                                    <hr>

                                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Deskripsi</strong>

                                    <p class="text-muted" id="description">
                                        -
                                    </p>

                                    <hr>

                                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Status</strong>

                                    <p class="text-muted" id="status">
                                        -
                                    </p>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-5">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="box box-success">
                                        <div class="box-header" style="text-align: center !important;">
                                            <h3 class="box-title"><i class="fa fa-money"></i> Pendanaan</h3>
                                        </div>
                                        <div class="box-body no-padding">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Deskripsi</th>
                                                    <th style="width: 100px">Dana</th>
                                                </tr>
                                                <tr>
                                                    <td><span>APBN/APBD</span></td>
                                                    <td><span class="badge bg-light-blue" id="apbnd">0</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td><span>BUMN/BUMD</span></td>
                                                    <td><span class="badge bg-light-blue" id="bumnd">0</span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Swasta</span></td>
                                                    <td><span class="badge bg-light-blue" id="swasta">0</span></td>
                                                </tr>

                                                <tr>
                                                    <td><span>Total</span></td>
                                                    <td><span class="badge bg-red" id="total">0</span></td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                
                                    <div class="box box-success">
                                        <div class="box-header" style="text-align: center !important;">
                                            <h3 class="box-title"> <i class="fa fa-calendar"></i> Tanggal</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body box-profile">
                                            
                                            <ul class="list-group list-group-unbordered">
                                                <li class="list-group-item">
                                                    <b>Mulai Penyiapaan</b> <a class="pull-right text-muted" id="start-date">-</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Mulai Transaksi</b> <a class="pull-right text-muted" id="transaction-date">-</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Mulai Konstruksi</b> <a class="pull-right text-muted" id="construction-date">-</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Mulai Operasi</b> <a class="pull-right text-muted" id="operation-date">-</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Selesai</b> <p class="pull-right text-muted" id="end-date">-</p>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                
                                </div>
                            
                            </div>

                        </div>
                        
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="createCloseBottomModal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>