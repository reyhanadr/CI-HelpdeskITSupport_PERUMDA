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
<!-- CORE SCRIPTS-->
<script src="<?php echo base_url(); ?>assets/js/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/js/scripts/mailbox.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<!-- PLUGIN FONTAWESOME -->
<script src="https://kit.fontawesome.com/eccb17b8b4.js" crossorigin="anonymous"></script>
<!-- CUSTOM SCRIPTS-->

<script>
	$(document).ready(function() {
	
	    // Initialize tooltips
	
	    $('.combined-button').tooltip();
	
	
	
	    // Show modal when button is clicked
	
	    $('.combined-button').click(function() {
	
	        $('#myModal').modal('show');
	
	
	
	        var sesiPesan = $(this).data('sesi');
	
	        $('#sesi_pesan').text(sesiPesan);
	
	
	
	        var namaSender = $(this).data('nama');
	
	        $('#nama_sender').text(namaSender);
	
	
	
	        // Set the href of the Terima Pesan button
	
	        var terimaUrl = "<?= base_url('index.php/KelolaPesan/terimaPesanTeknisi/') ?>" + sesiPesan;
	
	        $('#terimaButton').attr('href', terimaUrl);
	
	    });
	
	
	
	    // Show modal 2 when button is clicked
	
	    $('.combined-button2').click(function() {
	
	        $('#myModal2').modal('show');
	
	
	
	        var sesiPesanEnd = $(this).data('sesi');
	
	        $('#sesi_pesanEnd').text(sesiPesanEnd);
	
	
	
	        var namaSender = $(this).data('nama');
	
	        $('#nama_chat').text(namaSender);
	
	
	
	        // Set the href of the End Pesan button
	
	        var terimaUrlEnd = "<?= base_url('index.php/KelolaPesan/akhiriChat/') ?>" + sesiPesanEnd;
	
	        $('#confirmEndChat').attr('href', terimaUrlEnd);
	
	
	
	    });
	
	
	
	    // Akhiri chat when modal confirm button is clicked
	
	    $('#confirmEndChat').click(function() {
	
	        var sesiPesanEnd = $('#sesi_pesanEnd').text();
	
	        var akhiriUrl = "<?= base_url('index.php/KelolaPesan/akhiriChat/') ?>" + sesiPesanEnd;
	
	        window.location.href = akhiriUrl; // Redirect to the akhiriChat URL
	
	    });
	
	
	
	});
	
	
	
	
	
	
	
</script>
<script>
	// Fungsi untuk pratinjau gambar
	
	function previewImage(event) {
	
	    var input = event.target;
	
	    var preview = document.getElementById('previewImage');
	
	
	
	    var reader = new FileReader();
	
	    reader.onload = function () {
	
	        preview.src = reader.result;
	
	    };
	
	
	
	    reader.readAsDataURL(input.files[0]);
	
	}
	
	
	
	// Tambahkan event listener saat halaman selesai dimuat
	
	document.addEventListener('DOMContentLoaded', function () {
	
	    var fotoInput = document.getElementById('inputImage');
	
	    fotoInput.addEventListener('change', previewImage);
	
	});
	
</script>
<!-- Tambahkan kode berikut di bagian bawah halaman Anda -->
<script>
	var historyIds = [];
	
	$(document).ready(function () {
	
	
	
	    // Fungsi yang akan dijalankan ketika checkbox "Select All" diubah
	
	    $('[data-select="all"]').change(function () {
	
	        // Mengambil status checkbox "Select All"
	
	        var isChecked = $(this).is(':checked');
	
	
	
	        // Mengubah status semua checkbox dengan class "mail-check"
	
	        $('.mail-check').prop('checked', isChecked);
	
	    });
	
	
	
	
	
	    $('#inbox-actions button[data-original-title="Akhiri Pesan Live"]').click(function () {
	
	        // Mengambil semua checkbox yang terpilih
	
	        var selectedCheckboxes = $('.mail-check:checked');
	
	
	
	        // Mengambil history_id dari setiap checkbox yang terpilih dan menambahkannya ke historyIds
	
	        historyIds = selectedCheckboxes.map(function () {
	
	            return $(this).closest('tr').data('id');
	
	        }).get();
	
	        $('#myModal3').modal('show');
	
	
	
	
	
	    });
	
	
	
	    // Fungsi yang akan dijalankan ketika tombol "Akhiri Semua Chat" di klik
	
	    $('#confirmEndAllChat').click(async function () {
	
	        // Menggunakan historyIds yang telah dikumpulkan sebelumnya
	
	        if (historyIds.length > 0) {
	
	            for (var i = 0; i < historyIds.length; i++) {
	
	                var akhiriUrl = "<?php echo base_url('index.php/KelolaPesan/akhiriChat/'); ?>" + historyIds[i];
	
	                
	
	                // Menggunakan async/await untuk menunggu respon dari setiap permintaan sebelum melanjutkan ke berikutnya
	
	                await fetch(akhiriUrl);
	
	            }
	
	            window.open(akhiriUrl);
	
	        }
	
	    });
	
	
	
	
	
	
	
	    // Fungsi yang akan dijalankan ketika tombol "Akhiri Semua Chat" di klik
	
	    // $('#confirmEndAllChat').click(function () {
	
	    //     // Menggunakan historyIds yang telah dikumpulkan sebelumnya
	
	    //     if (historyIds.length > 0) {
	
	    //         for (var i = 0; i < historyIds.length; i++) {
	
	    //             var akhiriUrl = "<?php echo base_url('index.php/KelolaPesan/akhiriChat/'); ?>" + historyIds[i];
	
	                
	
	    //             // Buat tautan untuk setiap historyId
	
	    //             var link = '<a href="' + akhiriUrl + '">Akhiri Chat ' + historyIds[i] + '</a>';
	
	                
	
	    //             // Tambahkan tautan ke elemen HTML yang sesuai
	
	    //             $('#akhiriChatLinks').append(link);
	
	    //         }
	
	    //     }
	
	    // });
	
	
	
	
	
	
	
	});
	
</script>
<script>
	$(document).ready(function () {
	
	    $('#summernote').summernote();
	
	});
	
	
	
</script>
<script>
	// Saat tombol ditekan, tampilkan gambar dalam modal
	
	$(document).on('click', '.show-image-modal', function () {
	
	    // Ambil URL gambar dari atribut data-modalimage
	
	    var mediaUrl = $(this).data('modalimage');
	
	    // Setel sumber gambar modal
	
	    $('#modalImage').attr('src', "/assets/img/media/" + mediaUrl);
	
	});
	
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
		
  	$(document).ready(function () {
		$('.showImage').click(function (e) {
			e.preventDefault(); // Mencegah aksi default link

			// Ambil URL gambar dari atribut data-image pada elemen yang diklik
			var imageUrl = $(this).data("image");

			// Setel atribut src modalImage dengan URL gambar
			$('#modalImage').find('.modal-body').html('<img src="' + imageUrl + '" style="width: 100%;">');
			$('#modalImage').modal('show'); // Menampilkan modal
		});
	});

</script>
</body>
</html>