
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rule Access
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Administrasi</a></li>
        <li class="active">Rule Access</li>
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
                                <h3 class="box-title">Rule Access</h3>
                            </div>

                        </div>
                        <hr>

                        <div class="row">

                            <form id="rulePermissionForm">

                                <input type="hidden" id="id" name="id" class="insert-ruleaccess" />

                                <div class="col-xs-2">
                                    <div class="form-group">
                                        <select id="userOpt" name="userOpt" class="form-control insert-ruleaccess validate" style="width: 100%" required></select>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <select id="permissionMenuOpt" name="permissionMenuOpt" class="form-control insert-ruleaccess validate" style="width: 100%" required></select>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group">
                                        <button type="button" class="btn bg-blue btn-flat" id="resetRuleAccess">Reset</button>
                                        <button type="button" class="btn bg-blue btn-flat" id="saveRuleAccess">Save</button>
                                    </div>
                                </div>

                            </form>                            
                            
                        </div>
                        <hr>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table style="text-align:center;" id="ruleAccessList" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center; min-width: 80px !important;">Config</th>
                                    <th style="text-align:center;">Menu</th>
                                    <th style="text-align:center;">Create</th>
                                    <th style="text-align:center;">Read</th>
                                    <th style="text-align:center;">Update</th>
                                    <th style="text-align:center;">Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center;">Config</th>
                                    <th style="text-align:center;">Menu</th>
                                    <th style="text-align:center;">Create</th>
                                    <th style="text-align:center;">Read</th>
                                    <th style="text-align:center;">Update</th>
                                    <th style="text-align:center;">Delete</th>
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