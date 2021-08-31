
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Access
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Administrasi</a></li>
        <li class="active">User Access</li>
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
                                <h3 class="box-title">User Access</h3>
                            </div>
                            <div class="col-xs-8">
                                <button type="button" style="float:right;" class="btn bg-olive btn-flat" id="createUserAccess">Tambah</button>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:center;" id="userAccessList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center; min-width: 80px !important;">Config</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Nama</th>
                                    <th style="text-align:center;">Username</th>
                                    <!-- <th style="text-align:center;">Password</th> -->
                                    <th style="text-align:center;">Sebagai</th>
                                    <th style="text-align:center;">PJP</th>
                                    <th style="text-align:center;">No. HP</th>
                                    <th style="text-align:center;">E-mail</th>
                                    <th style="text-align:center;">Alamat</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">Config</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Nama</th>
                                    <th style="text-align:center;">Username</th>
                                    <!-- <th style="text-align:center;">Password</th> -->
                                    <th style="text-align:center;">Sebagai</th>
                                    <th style="text-align:center;">PJP</th>
                                    <th style="text-align:center;">No. HP</th>
                                    <th style="text-align:center;">E-mail</th>
                                    <th style="text-align:center;">Alamat</th>
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
            <form id="userAccessForm">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Form User Access</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">

                            <input type="hidden" id="id" name="id" class="form-control insert-useraccess" />
                            
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="name" name="name" class="form-control insert-useraccess validate" required />
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="username" name="username" class="form-control insert-useraccess validate" required />
                            </div>
                            
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" name="password" class="form-control insert-useraccess validate" required />
                            </div>
                            
                            <div class="form-group">
                                <label>Sebagai</label>
                                <select id="groupOpt" name="groupOpt" class="form-control insert-useraccess validate" style="width: 100%" required>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>PJP</label>
                                <select id="pjpOpt" name="pjpOpt" class="form-control insert-useraccess validate" style="width: 100%" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" id="email" name="email" class="form-control insert-useraccess validate" required />
                            </div>

                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="number" id="phoneNumber" name="phoneNumber" class="form-control insert-useraccess validate" required />
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="address" id="address" class="form-control insert-useraccess validate" rows="4" placeholder="Alamat"></textarea>
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="saveUserAccess" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
