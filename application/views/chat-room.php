<div class="content-wrapper">
	<!-- START PAGE CONTENT-->
	<div class="page-heading">
		<h1 class="page-title">Live Chat Room</h1>
	</div>
	<div class="page-content fade-in-up">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-head">
						<div class="ibox-title">
							Chat dengan
							<?php if ($users->nama_role === "Teknisi"): ?>
							Karyawan
							<?php else: ?>
							Teknisi
							<?php endif; ?>
						</div>
					</div>
					<div class="ibox-body">
						<div class="message" id="chat-messages">
							<!-- Menampilkan Pesan Pengirim/Sender (karyawan) -->
							<div class="message">
								<?php
									$combinedChats = array_merge($chats, $chats_teknisi);      
									
									usort($combinedChats, function($a, $b) {
									
									    return strtotime($a->timestamp) - strtotime($b->timestamp);
									
									});
													
									$uniqueMessages = []; // Array untuk menyimpan pesan unik
									foreach ($combinedChats as $message) {
									
									    if (!in_array($message->id, $uniqueMessages)) {
									        $uniqueMessages[] = $message->id; // Tambahkan id pesan ke array unik
									?>
								<li class="media <?=($message->sender_id == $this->session->userdata('user_id')) ? 'media-right' : '' ?>" id="<?=$message->id ?>">
									<?php if ($message->sender_id != $this->session->userdata('user_id')): ?>
                                    <!-- Foto User -->
									<a class="" href="javascript:;" style="width: 45px; height: 45px; overflow: hidden; border-radius: 50%; <?=($message->sender_id == $this->session->userdata('user_id')) ? 'margin-left' : 'margin-right' ?>: 8px">
									    <img src="<?php echo base_url(); ?>/assets/img/users/<?=$message->foto_user ?>" style="width: 100%; height: 100%; object-fit: cover; ">
									</a>
									<?php endif; ?>
									<div class="media-body <?=($message->sender_id == $this->session->userdata('user_id')) ? 'text-right' : '' ?> message-item">
										<h6 class="media-heading"><?=$message->nama ?></h6>
										<?php if ($message->message != '' || $message->image != ''): ?>
										<div class="message-content">
											<?php if ($message->message != ''): ?>
											<!-- Tampilkan teks pesan -->
											<span><?=$message->message ?></span> <br>
											<?php endif; ?>

											<?php if ($message->image != ''): ?>

											<!-- Tampilkan gambar pesan dengan modal pop-up -->
                                            <a class="showImage" 
												data-toggle="modal" 
												data-target="#modalImage" 
												data-image="<?= base_url();?>assets/img/media/<?= $message->image?>" 
												style="width: 45px; height: 45px; overflow: hidden; border-radius: 50%; 
												<?= ($message->sender_id == $this->session->userdata('user_id')) ? 'margin-left' : 'margin-right' ?>"
											>
                                                <img src="<?php echo base_url(); ?>assets/img/media/<?= $message->image ?>" style="width: 200px; max-height: 300px; object-fit: contain; float: center;">
                                            </a>

											<?php endif; ?>
										</div>
										<?php endif; ?>
										<span class="badge badge-default m-b-5" style="font-size: 10px; padding: 3px 5px; display: inline-block; clear: both;"><?=$message->timestamp ?></span>
										<br><br>
									</div>

                                    <!-- Modal untuk pop-up gambar -->
                                    <div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!-- Tombol Close (X) di sudut kanan atas modal -->
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Kontainer gambar -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->




									<?php if ($message->sender_id == $this->session->userdata('user_id')): ?>
									<a class="" href="javascript:;" style="width: 45px; height: 45px; overflow: hidden; border-radius: 50%; margin-left: 10px">
									<img src="<?php echo base_url(); ?>/assets/img/users/<?=$message->foto_user ?>" style="width: 100%; height: 100%; object-fit: cover; ">
									</a>
									<?php endif; ?>
								</li>
								<?php
									}
									
									}
									
									?>
							</div>
						</div>
						<?php if ($get_receiver_status->status == 'taken' || $get_receiver_status->status == 'open'){?>
						<form action="<?php echo site_url('KelolaPesan/kirimPesan'); ?>" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<input class="form-control" type="text" name="sesi_pesan" value="<?= isset($sesi_pesan) ? $sesi_pesan : '' ?>" hidden>
								<input class="form-control" type="text" name="kategori_id" value="<?= isset($kategori_id) ? $kategori_id : '' ?>" hidden>
								<input class="form-control" type="text" name="status" value="<?= isset($get_receiver_status->status) ? $get_receiver_status->status : '' ?>" hidden>
								<input class="form-control" type="text" name="sender_id" hidden value="<?php echo $this->session->userdata('user_id'); ?>">
								<input class="form-control" type="text" name="receiver_id" hidden value="
									<?php if ($get_receiver_status->receiver_id === NULL): ?>
									NULL
									<?php else: ?>
									<?php if ($get_receiver_status->receiver_id == $this->session->userdata('user_id')): ?>
									<?= $get_receiver_status->sender_id ?>
									<?php else: ?>
									<?= $get_receiver_status->receiver_id ?>
									<?php endif; ?>
									<?php endif; ?>
									">
								<input type="file" class="form-control" name="media" id="image" accept="image/jpg, image/jpeg, image/png">
								<textarea class="form-control" type="text" placeholder="Type message" name="message"> </textarea>
							</div>
							<div class="form-group">
								<?php if ($get_receiver_status->status === 'taken'): ?>
								<button class="btn btn-primary" type="submit">Kirim Pesan</button>
									<!-- <?php if ($users->nama_role === "Teknisi"): ?>
									<a href="#" class="btn btn-danger"> Akhiri Pesan</a>
								<?php endif; ?> -->

								<?php endif; ?>
							</div>
						</form>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- JavaScript -->






<script>
	function refreshPage() {
	
	    location.reload();
	
	}
	
	// Atur penundaan untuk reload halaman setiap 15 detik (15000 milidetik)
	setInterval(refreshPage, 60000);
	
</script>