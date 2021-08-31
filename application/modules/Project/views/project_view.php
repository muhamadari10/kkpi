
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
        <li class="active">Proyek</li>
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
                                <h3 class="box-title">Data Proyek</h3>
                            </div>
                            <div class="col-xs-8">
                                <button type="button" data-toggle="tooltip" title="Create Project" class="btn bg-olive btn-flat margin" style="float: right;" id="createProject">Tambah</button>
                            </div>

                        </div>
                        <hr>

                        <div class="row">

                            <div class="col-xs-3">
                                <div class="form-group">
                                    <select id="projectFilter" name="projectFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <select id="sectorFilter" name="sectorFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <select id="statusCodeFilter" name="statusCodeFilter" class="form-control" style="width: 100%" required></select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <button type="button" class="btn bg-blue btn-flat" id="projectSearch">Cari</button>
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
                                    <th style="text-align:center;">Rinci</th>
                                    <th style="text-align:center;min-width: 110px !important;">Config</th>
                                    <th style="text-align:center;">No. PSN</th>
                                    <th style="text-align:center;">Project</th>
                                    <th style="text-align:center;">Sektor</th>
                                    <th style="text-align:center;min-width: 100px !important;">Indikasi Dana</th>
                                    <!-- <th style="text-align:center;">Mata Uang</th> -->
                                    <!-- <th style="text-align:center;">Status</th> -->
                                    <th style="text-align:center;">Jumlah Dana</th>
                                    <!-- <th style="text-align:center;">Dana APBN/APBD</th>
                                    <th style="text-align:center;">Dana BUMN/BUMD</th>
                                    <th style="text-align:center;">Dana Swasta</th> -->
                                    <th style="text-align:center;min-width: 80px !important;">Kode Status</th>
                                    <th style="text-align:center;">Pjp</th>
                                    <!-- <th style="text-align:center;">Contact Person</th> -->
                                    <th style="text-align:center;">Tgl. Mulai</th>
                                    <th style="text-align:center;">Tgl. Berakhir</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">ID</th>
                                    <th style="text-align:center;">Rinci</th>
                                    <th style="text-align:center;min-width: 110px !important;">Config</th>
                                    <th style="text-align:center;">No. PSN</th>
                                    <th style="text-align:center;">Project</th>
                                    <th style="text-align:center;">Sektor</th>
                                    <th style="text-align:center;min-width: 120px !important;">Indikasi Dana</th>
                                    <!-- <th style="text-align:center;">Mata Uang</th> -->
                                    <!-- <th style="text-align:center;">Status</th>  -->
                                    <th style="text-align:center;">Jumlah Dana</th>
                                    <!-- <th style="text-align:center;">Dana APBN/APBD</th>
                                    <th style="text-align:center;">Dana BUMN/BUMD</th> -->
                                    <th style="text-align:center;min-width: 80px !important;">Kode Status</th>
                                    <th style="text-align:center;">Pjp</th>
                                    <!-- <th style="text-align:center;">Contact Person</th> -->
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
</div>

<div class="modal fade" id="openModalCreate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="projectForm">
            
                <div class="modal-header">
                    <button type="button" class="close" id="createCloseTopModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Form Proyek

                    <button type="button" class="btn btn-sm bg-yellow btn-flat" id="actionSubmit">Edit</button></h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-6">

                            <input type="hidden" name="id" id="id" class="insert-project"/>

                            <!-- <input type="hidden" name="projectMstId" id="projectMstId" class="insert-project"/> -->

                            <div class="form-group">
                                <label>Status Proyek</label>
                                <select id="statusOpt" name="statusOpt" class="form-control insert-project" style="width: 100%">
                                    <!-- <option value="">Status Proyek</option> -->
                                    <option value="parent" selected>Proyek Induk</option>
                                    <option value="child">Sub Proyek</option>
                                </select>
                            </div>

                            <div class="form-group" id="form-project">
                                <label>Proyek</label>
                                <select id="projectOpt" name="projectOpt" class="form-control insert-project" style="width: 100%"></select>
                            </div>

                            <div class="form-group">
                                <label>No. PSN</label>
                                <textarea name="externalCode" id="externalCode" class="form-control insert-project validate" rows="3" placeholder="No. PSN"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <textarea name="projectName" id="projectName" class="form-control insert-project validate" rows="3" placeholder="Nama Proyek"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Sektor Proyek</label>
                                <select id="sectorOpt" name="sectorOpt" class="form-control insert-project validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kode Status</label>
                                <select id="statusCodeOpt" name="statusCodeOpt" class="form-control insert-project validate" style="width: 100%" required>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Indikasi Pendanaan</label>
                                <select id="fundIndicationOpt" name="fundIndicationOpt" class="form-control insert-project validate" multiple="multiple" style="width: 100%" required>
                                </select>
                                
                            </div>

                            <div class="form-group">
                                <label>Mata Uang</label>
                                <textarea name="currency" id="currency" class="form-control insert-project validate" rows="3" placeholder="Mata Uang"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Pendanaan - APBN/APBD</label>
                                <input type="number" name="totalFundApbnd" id="totalFundApbnd" class="form-control insert-project validate" placeholder="Jumlah Pendanaan"></input>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Pendanaan - BUMN/BUMD</label>
                                <input type="number" name="totalFundBumnd" id="totalFundBumnd" class="form-control insert-project validate" placeholder="Jumlah Pendanaan"></input>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Pendanaan - Swasta</label>
                                <input type="number" name="totalFundSwasta" id="totalFundSwasta" class="form-control insert-project validate" placeholder="Jumlah Pendanaan"></input>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Pendanaan</label>
                                <input type="number" name="totalFund" id="totalFund" class="form-control insert-project validate" placeholder="Jumlah Pendanaan"></input>
                            </div>

                            <div class="form-group">
                                <!-- <label>Jumlah Pendanaan</label> -->
                                <h4><span id="totalThreeFund"></span></h4>
                            </div>                            

                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>PJP</label>
                                <select id="pjpOpt" name="pjpOpt" class="form-control insert-project validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kontak Person</label>
                                <textarea name="contactPerson" id="contactPerson" class="form-control insert-project validate" rows="3" placeholder="Contact Person"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Output</label>
                            
                                <div class="row">
                                    
                                    <div class="col-md-8">
                                        
                                        <input type="text" name="output" id="output" class="form-control insert-project validate" placeholder="Output"></input>

                                    </div>
                                    <div class="col-md-4">
                                        
                                        <select id="unitOpt" name="unitOpt" class="form-control insert-project validate" style="width: 100%" required>
                                        </select>

                                    </div>

                                </div>

                            </div>
                            
                            <div class="form-group">
                                <label>Status</label>
                                <textarea name="status" id="status" class="form-control insert-project validate" rows="3" placeholder="Status"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" id="description" class="form-control insert-project validate" rows="3" placeholder="Deskripsi"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Tanggal Mulai Penyiapaan</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="startDate" name="startDate" type="text" class="form-control pull-right insert-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Transaksi</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="transactionDate" name="transactionDate" type="text" class="form-control pull-right insert-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Konstruksi</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="constructionDate" name="constructionDate" type="text" class="form-control pull-right insert-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Operasi</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="operationDate" name="operationDate" type="text" class="form-control pull-right insert-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="endDate" name="endDate" type="text" class="form-control pull-right insert-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Provinsi</label>
                                <select id="provinceOpt" name="provinceOpt" class="form-control insert-project validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pulau</label>
                                <select id="islandOpt" name="islandOpt" class="form-control insert-project validate" style="width: 100%" required>
                                </select>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="createCloseBottomModal">Close</button>
                    <button type="button" id="saveProject" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="openModalCreateMulti">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="multiProjectForm">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Form Multi Proyek</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-6">

                            <!-- <div class="form-group"> -->
                            <input type="hidden" id="detId" name="detId" class="form-control insert-multi-project"></input>
                            <input type="hidden" id="projectMstId" name="projectMstId" class="form-control insert-multi-project validate"></input>
                            <!-- </div> -->

                            <div class="form-group">
                                <label>No. PSN</label>
                                <textarea name="externalCodeMul" id="externalCodeMul" class="form-control insert-multi-project validate" rows="3" placeholder="No. PSN"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <textarea name="projectNameMul" id="projectNameMul" class="form-control insert-multi-project validate" rows="3" placeholder="Nama Proyek"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Sektor Proyek</label>
                                <select id="sectorOptMul" name="sectorOptMul" class="form-control insert-multi-project validate" style="width: 100%" required>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Indikasi Pendanaan</label>
                                <select id="fundIndicationOptMul" name="fundIndicationOptMul" class="form-control insert-multi-project validate" multiple="multiple" style="width: 100%" required>
                                </select>
                                
                            </div>

                            <div class="form-group">
                                <label>Mata Uang</label>
                                <textarea name="currencyMul" id="currencyMul" class="form-control insert-multi-project validate" rows="3" placeholder="Mata Uang"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Pendanaan</label>
                                <input type="number" name="totalFundMul" id="totalFundMul" class="form-control insert-multi-project validate" placeholder="Jumlah Pendanaan"></input>
                            </div>

                            <div class="form-group">
                                <label>Pemberi Dana</label>
                                <textarea name="funderMul" id="funderMul" class="form-control insert-multi-project validate" rows="3" placeholder="Pemberi Dana"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="totalMul" id="totalMul" class="form-control insert-multi-project validate" placeholder="Jumlah"></input>
                            </div>

                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>PJP</label>
                                <select id="pjpOptMul" name="pjpOptMul" class="form-control insert-multi-project validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kontak Person</label>
                                <textarea name="contactPersonMul" id="contactPersonMul" class="form-control insert-multi-project validate" rows="3" placeholder="Contact Person"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Output</label>
                            
                                <div class="row">
                                    
                                    <div class="col-md-8">
                                        
                                        <input type="text" name="outputMul" id="outputMul" class="form-control insert-multi-project validate" placeholder="Output"></input>

                                    </div>
                                    <div class="col-md-4">
                                        
                                        <select id="unitOptMul" name="unitOptMul" class="form-control insert-multi-project validate" style="width: 100%" required>
                                        </select>

                                    </div>

                                </div>

                            </div>
                            
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="descriptionMul" id="descriptionMul" class="form-control insert-multi-project validate" rows="3" placeholder="Deskripsi"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Penyiapaan</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="startDateMul" name="startDateMul" type="text" class="form-control pull-right insert-multi-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Transaksi</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="transactionDateMul" name="transactionDateMul" type="text" class="form-control pull-right insert-multi-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Konstruksi</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="constructionDateMul" name="constructionDateMul" type="text" class="form-control pull-right insert-multi-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Operasi</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="operationDateMul" name="operationDateMul" type="text" class="form-control pull-right insert-multi-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="endDateMul" name="endDateMul" type="text" class="form-control pull-right insert-multi-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Tanda Tangan</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="signatureDateMul" name="signatureDateMul" type="text" class="form-control pull-right insert-multi-project validate">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Efektif</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="effectiveDateMul" name="effectiveDateMul" type="text" class="form-control pull-right insert-multi-project validate">
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.col -->

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="saveMultiProject" class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->