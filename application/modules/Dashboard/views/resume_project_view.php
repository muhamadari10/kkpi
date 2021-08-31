<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Resume Proyek
        <small>Komite Percepatan Penyediaan Infrastruktur Prioritas</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Resume Proyek</li>
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
                                <div class="form-group">
                                    <select id="pjpOpt" name="pjpOpt" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <select id="projectOpt" name="projectOpt" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <select id="sectorOpt" name="sectorOpt" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <button type="button" class="btn bg-blue btn-flat" id="resumeSubmit">Cari</button>
                                </div>
                            </div>
                            
                        </div>
                        <hr>

                    </div>
                    
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:center;" id="projectList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">ID</th>
                                    <th style="text-align:center;min-width: 30px !important;">Config</th>
                                     <th style="text-align:center;">No. PSN</th>
                                    <th style="text-align:center;">Project</th>
                                    <th style="text-align:center;">Sektor</th>
                                    <th style="text-align:center;min-width: 100px !important;">Indikasi Dana</th>
                                    <th style="text-align:center;">Jumlah Dana</th>                                    <th style="text-align:center;">Pjp</th>
                                    <th style="text-align:center;">Tgl. Mulai</th>
                                    <th style="text-align:center;">Tgl. Berakhir</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">ID</th>
                                    <th style="text-align:center;min-width: 30px !important;">Config</th>
                                    <th style="text-align:center;">No.PSN</th>
                                    <th style="text-align:center;">Project</th>
                                    <th style="text-align:center;">Sektor</th>
                                    <th style="text-align:center;min-width: 120px !important;">Indikasi Dana</th>
                                    <th style="text-align:center;">Jumlah Dana</th>
                                    <th style="text-align:center;">Pjp</th>
                                    <th style="text-align:center;">Tgl. Mulai</th>
                                    <th style="text-align:center;">Tgl. Berakhir</th>
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
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="openModalCreate">
    <div class="modal-dialog modal-980">
        <div class="modal-content">
            <form id="resumeForm">
            
                <div class="modal-header">
                    <button type="button" class="close" id="createCloseTopModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Resume Project
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