
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan
        <!-- <small>Proyek</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url().'Dashboard';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Laporan</a></li>
        <li class="active">Laporan Pencapaian Proyek</li>
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
                                <h3 class="box-title">Pencapaian Proyek</h3>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">

                            <!-- <div class="col-xs-4">
                                <div class="form-group">
                                    <select id="pjpOpt" name="pjpOpt" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <select id="projectOpt" name="projectOpt" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div> -->
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <select id="sectorOpt" name="sectorOpt" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                             <!--data baru -->
                            <div class="col-xs-3">
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
                                    <select id="provinceOpt" name="provinceOpt" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <button type="button" class="btn bg-blue btn-flat" id="reportSubmit">Cari</button>
                                </div>
                            </div>

                        </div>
                        
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:left;" id="achievementList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">ID</th>
                                    <th style="text-align:center;">No. PSN</th>
                                    <th style="text-align:center;">Project</th>
                                    <th style="text-align:center;">Sektor</th>
                                    <th style="text-align:center;">Indikasi Dana</th>
                                    <th style="text-align:center;">Mata Uang</th>
                                    <th style="text-align:center;">Jumlah Dana</th>
                                    <th style="text-align:center;">Kode Status</th>
                                    <th style="text-align:center;">Pjp</th>
                                    <th style="text-align:center;">Output</th>
                                    <th style="text-align:center;">Deskripsi</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Contact Person</th>
                                    <th style="text-align:center;">Tgl. Penyiapan</th>
                                    <th style="text-align:center;">Tgl. Transaksi</th>
                                    <th style="text-align:center;">Tgl. Konstruksi</th>
                                    <th style="text-align:center;">Tgl. Operasi</th>
                                    <th style="text-align:center;">Tgl. Selesai</th>
                                    <th style="text-align:center;">Status Proyek</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">ID</th>
                                    <th style="text-align:center;">No. PSN</th>
                                    <th style="text-align:center;">Project</th>
                                    <th style="text-align:center;">Sektor</th>
                                    <th style="text-align:center;">Indikasi Dana</th>
                                    <th style="text-align:center;">Mata Uang</th>
                                    <th style="text-align:center;">Jumlah Dana</th>
                                    <th style="text-align:center;">Kode Status</th>
                                    <th style="text-align:center;">Pjp</th>
                                    <th style="text-align:center;">Output</th>
                                    <th style="text-align:center;">Deskripsi</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Contact Person</th>
                                    <th style="text-align:center;">Tgl. Penyiapan</th>
                                    <th style="text-align:center;">Tgl. Transaksi</th>
                                    <th style="text-align:center;">Tgl. Konstruksi</th>
                                    <th style="text-align:center;">Tgl. Operasi</th>
                                    <th style="text-align:center;">Tgl. Selesai</th>
                                    <th style="text-align:center;">Status Proyek</th>
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