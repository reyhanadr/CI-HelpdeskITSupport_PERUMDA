    <!-- END PAGE CONTENT-->

    <footer class="page-footer">

                <div class="font-13">2023 © <b>Perumda Air Minum Tirta Raharja</b> - All rights reserved.</div>

                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>

            </footer>

        </div>

    </div>

        <!-- BEGIN PAGA BACKDROPS-->

        <div class="sidenav-backdrop backdrop"></div>

    <div class="preloader-backdrop">

        <div class="page-preloader">Loading</div>

    </div>

    <!-- END PAGA BACKDROPS-->

    <!-- CORE PLUGINS-->

    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

    <!-- PAGE LEVEL PLUGINS-->

    <script src="<?php echo base_url(); ?>assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/jquery-knob/dist/jquery.knob.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/moment/min/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>

    <!-- CORE SCRIPTS-->

    <script src="<?php echo base_url(); ?>assets/js/app.min.js" type="text/javascript"></script>

    <!-- PAGE LEVEL SCRIPTS-->
	<script src="<?php echo base_url(); ?>assets/js/scripts/form-plugins.js" type="text/javascript"></script>
	<script src="https://kit.fontawesome.com/eccb17b8b4.js" crossorigin="anonymous"></script>

    <script type="text/javascript">

        $(function() {

            $('#example-table').DataTable({

                pageLength: 10,

                //"ajax": './assets/demo/data/table_data.json',

                /*"columns": [

                    { "data": "name" },

                    { "data": "office" },

                    { "data": "extn" },

                    { "data": "start_date" },

                    { "data": "salary" }

                ]*/

            });

        })

    </script>

        <script type="text/javascript">

        $(function() {

            $('#example-table2').DataTable({

                pageLength: 10,

                //"ajax": './assets/demo/data/table_data.json',

                /*"columns": [

                    { "data": "name" },

                    { "data": "office" },

                    { "data": "extn" },

                    { "data": "start_date" },

                    { "data": "salary" }

                ]*/

            });

        })

    </script>



<script type="text/javascript">

$("#form-sample-1").validate({

    rules: {

        nama: {

            required: true

        },

        email: {

            required: true,

            email: true

        },

        username: {

            required: true,

        },

        karyawan_id: {

            required: true,

        },

        departemen: {

            required: true,

        },

        kategori: {

            required: true,

        },

        password: {

            required: true,

        },

        bidang: {

            required: true,

        },

        id: {

            required: true,

        },

        password: {

            required: true,

        },

        password_confirmation: {

            required: true,

            equalTo: "#password"

        },
        perangkat_id: {

            required: true,

        },
        deskripsi_permasalahan: {

            required: true,

        },
        nomer_seri: {

            required: true,

        },
        foto: {

            required: true,

        },
        prioritas: {

            required: true,

        },
        deskripsi: {

            required: true,

        },
        nama_perangkat: {

            required: true,

        },
        kategori_id: {

            required: true,

        },
        tanggal_masuk: {

            required: true,

        },
        spesifikasi: {

            required: true,

        },

    },

    messages: {

        nama: {

            required: "Kolom ini harus diisi!"

        },

        email: {

            required: "Kolom ini harus diisi!",

            email: "Masukkan alamat email yang valid."

        },

        username: {

            required: "Kolom ini harus diisi!",

        },

        karyawan_id: {

            required: "Kolom ini harus diisi!"

        },

        departemen: {

            required: "Kolom ini harus diisi!"

        },

        kategori: {

            required: "Kolom ini harus diisi!"

        },

        password: {

            required: "Kolom ini harus diisi!"

        },

        bidang: {

            required: "Kolom ini harus diisi!"

        },

        id: {

            required: "Kolom ini harus diisi!"

        },

        password: {

            required: "Kolom ini harus diisi!"

        },

        password_confirmation: {

            required: "Kolom ini harus diisi!",

            equalTo: "Password Tidak Sama!"

        },
        perangkat_id: {

            required: "Kolom ini harus diisi!"

        },
        deskripsi_permasalahan: {

            required: "Kolom ini harus diisi!"

        },
        nomer_seri: {

            required: "Kolom ini harus diisi!"

        },
        foto: {

            required: "Foto harus diisi!"

        },
        prioritas: {

            required: "Kolom ini harus diisi!"

        },
        deskripsi: {

            required: "Kolom ini harus diisi!"

        },
        nama_perangkat: {

            required: "Kolom ini harus diisi!"

        },
        kategori_id: {

            required: "Kolom ini harus diisi!"

        },
        tanggal_masuk: {

            required: ""

        },
        spesifikasi: {

            required: "Kolom ini harus diisi!"

        },

        // Sisipkan pesan untuk setiap field lainnya sesuai kebutuhan Anda

    },

    

    errorClass: "help-block error",

    highlight: function(e) {

        $(e).closest(".form-group.row").addClass("has-error")

    },

    unhighlight: function(e) {

        $(e).closest(".form-group.row").removeClass("has-error")

    },

    

});

</script>
    <script>

        function validateInput(inputElement) {

            var inputValue = inputElement.value;

            var pattern = /^[A-Za-z\s]+$/; // Pola yang memungkinkan huruf A-Z, a-z, dan spasi



            if (!pattern.test(inputValue)) {

                document.getElementById("error-message").textContent = "Hanya huruf A-Z, a-z, atau spasi yang diperbolehkan.";

                inputElement.value = inputValue.replace(/[^A-Za-z\s]+/g, ''); // Menghapus karakter selain huruf dan spasi

            } else {

                document.getElementById("error-message").textContent = "";

            }

        }

    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('datepicker').setAttribute('max', new Date().toISOString().split("T")[0]);
            $('#datepicker').datetimepicker({
                minDate: new Date()
                    
                format: 'Y-m-d', // Format default yang akan digunakan oleh datetimepicker
                formatDate: 'Y-m-d', // Format yang akan digunakan dalam input (tahun, bulan, hari)
            });
        });
    </script>
    <script>
        // Fungsi untuk pratinjau gambar
        function previewImage(event) {
            var input = event.target;
            var preview = document.getElementById('previewImage');

            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
            };

            reader.readAsDataURL(input.files[0]);
        }

            // Tambahkan event listener saat halaman selesai dimuat
            document.addEventListener('DOMContentLoaded', function() {
            var fotoInput = document.getElementById('inputImage');
            fotoInput.addEventListener('change', previewImage);
        });
    </script>


</body>



</html>