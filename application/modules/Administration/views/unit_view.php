
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Satuan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Administrasi</a></li>
        <li class="active">Satuan</li>
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
                                <h3 class="box-title">Data Satuan</h3>
                            </div>
                            <div class="col-xs-8">
                                <button type="button" style="float:right;" class="btn bg-olive btn-flat" id="createUnit">Tambah</button>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:center;" id="unitList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center; min-width: 80px !important;">Config</th>
                                    <th style="text-align:center;">Nama Satuan</th>
                                    <th style="text-align:center;">Simbol</th>
                                    <th style="text-align:center;">Deskripsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">Config</th>
                                    <th style="text-align:center;">Nama Satuan</th>
                                    <th style="text-align:center;">Simbol</th>
                                    <th style="text-align:center;">Deskripsi</th>
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
            <form id="unitForm">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Form Satuan</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">

                            <input type="hidden" id="unitId" name="unitId" class="form-control insert-unit" />
                            
                            <div class="form-group">
                                <label>Nama Satuan</label>
                                <textarea name="unitName" id="unitName" class="form-control insert-unit validate" rows="3" placeholder="Nama Satuan"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Simbol</label>
                                <textarea name="simbol" id="simbol" class="form-control insert-unit validate" rows="3" placeholder="Simbol"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" id="description" class="form-control insert-unit validate" rows="3" placeholder="Deskripsi"></textarea>
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="saveUnit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
