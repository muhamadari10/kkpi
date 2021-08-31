
<!-- Login Container -->
<div id="login-container">
    <!-- Register Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
        <i class="fa fa-plus"></i> <strong>SATGANA</strong>
    </h1>
    <!-- END Register Header -->

    <!-- Register Form -->
    <div class="block animation-fadeInQuickInv">
        <!-- Register Title -->
        <div class="block-title">
            <h2>Daftarkan diri Anda</h2>
        </div>
        <!-- END Register Title -->

        <!-- Register Form -->
        <form id="form-register" class="form-horizontal">
            <div class="form-group text-input">
                <div class="col-xs-12">
                    <input type="text" id="nim" name="nim" class="form-control text-input-control insert-register" placeholder="NIM">
                </div>
            </div>
            <div class="form-group text-input">
                <div class="col-xs-12">
                    <input type="text" id="full_name" name="full_name" class="form-control text-input-control insert-register" placeholder="Nama Lengkap">
                </div>
            </div>
            <div class="form-group text-input">
                <div class="col-xs-12">
                    <input type="text" id="email" name="email" class="form-control text-input-control insert-register" placeholder="E-mail">
                </div>
            </div>
            <div class="form-group text-input">
                <div class="col-xs-12">
                    <input type="text" id="hp" name="hp" class="form-control text-input-control insert-register" placeholder="No. HP">
                </div>
            </div>
            <div class="form-group select-input">
                <div class="col-xs-12">
                    <select id="faculty_id" name="faculty_id" class="select-select2 select-input-control insert-register" style="width: 100%">
                        <?php 
                            foreach ($faculty as $key => $value) {
                                echo '<option value="' . $value->id . '">' . $value->faculty_name . '</option>';
                            }
                        ?>
                    </select>
                </select>
                </div>
            </div>
            <div class="form-group select-input">
                <div class="col-xs-12">
                    <select id="major_id" name="major_id" class="select-select2 select-input-control insert-register" style="width: 100%">
                        <?php 
                            foreach ($major as $key => $value) {
                                echo '<option value="' . $value->id . '">' . $value->major_name . '</option>';
                            }
                        ?>
                    </select>
                </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="text" id="age" name="age" class="form-control text-input-control insert-register" placeholder="Umur">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                <input type="text" id="birth_date" name="birth_date" class="form-control input-datepicker select-input-control insert-register" data-date-format="yyyy-mm-dd" placeholder="Tanggal lahir">
                </div>
            </div>
            <div class="form-group select-input">
                <div class="col-xs-12">
                    <select id="genre" name="genre" class="select-select2 select-input-control insert-register" style="width: 100%">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="text" id="parent_name" name="parent_name" class="form-control text-input-control insert-register" placeholder="Nama Ortu">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <textarea type="text" rows="7" cols="7" id="reason" name="reason" class="form-control text-input-control insert-register" placeholder="Alasan masuk satgana"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <textarea type="text" rows="7" cols="7" id="vision" name="vision" class="form-control text-input-control insert-register" placeholder="Visi misi untuk Satgana"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <textarea type="text" rows="7" cols="7" id="address" name="address" class="form-control text-input-control insert-register" placeholder="Alamat"></textarea>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-6">
                </div>
                <div class="col-xs-6 text-right">
                    <button type="button" class="btn btn-effect-ripple btn-success" onclick="return register()"><i class="fa fa-plus"></i>Daftar</button>
                </div>
            </div>
        </form>
        <!-- END Register Form -->
    </div>
    <!-- END Register Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
        <small>2018 &copy; <a href="#" target="_blank">Navij</a></small>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Login Container -->

<script type="text/javascript">

    // $(document).ready(function() {

        
        function register () {

            if( 
                ($('#nim').val() == '') ||
                ($('#full_name').val() == '') || 
                ($('#email').val() == '') || 
                ($('#hp').val() == '') ||  
                ($('select[name="faculty_id"]').val() == undefined) || 
                ($('select[name="major_id"]').val() == undefined) || 
                ($('#birth_date').val() == '') || 
                ($('#parent_name').val() == '') || 
                ($('select[name="genre"]').val() == undefined) || 
                ($('#vision').val() == '') || 
                ($('#reason').val() == '') || 
                ($('#address').val() == '')
            ) {

                alert('Field masih kosong. Perhatikan data anda!');

            } else {

                var dataset = {};
                var i = 0;

                $('.form-group').find('.insert-register').each(function(index, element){

                    i++;
                    var value = [];
                    if ($(this).attr('name') !== undefined) {
                        var key = $(this).attr('name');
                        var ids = $(this).attr('ids');
                        if ($(this).attr('ids') !== undefined) {
                            if($(this).attr("type")=="hidden") {
                                dataset[key] = $(this).val();
                            } else {
                                dataset[key] = $(this).val();
                            }
                        } else {
                            dataset[key] = $(this).val();
                        }
                    }

                });

                $.ajax({
                    url    : base_url + '/auth/'+ 'save_register',
                    method : 'POST',
                    async  : true,
                    cache  : false,
                    data   : dataset,
                    success: function(d,s,x){
                        console.log(d);
                        
                        var data = JSON.parse(d);
                        if (x.status == 200) {
                            if (data.status) {
                                alert(data.message);
                                window.location.href = "http://localhost/satgana_website/front/index";
                                // location =  "localhost/satgana_website/front/index";
                            } else {
                                alert(data.message);
                            }
                        } else
                        alert((data.message == "" ? "Check your input" : data.message));
                    },
                    error  : function(x,s){
                        // alert(x.message);
                    }
                });

            }
            
        };
        
    // });

</script>