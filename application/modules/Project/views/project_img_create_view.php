
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
        <li class="active">Gallery</li>
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
                                <h3 class="box-title">Gallery Proyek</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    
                    <form id="uploadProjectImg" action="<?= current_url() . '/ajax/upload_project_img'; ?>" enctype="multipart/form-data" class="dropzone" method="post">
                        <div class="fallback">
                            <input name="file" type="file" multiple />
                        </div>
                    </form>

                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>


<style>

    .data-dz-thumbnail { width: 100% !important; height: 100% !important;}

</style>