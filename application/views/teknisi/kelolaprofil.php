<div class="content-wrapper">
<!-- START PAGE CONTENT-->
<div class="page-heading">
	<h1 class="page-title">My Profile</h1>
</div>
<div class="page-content fade-in-up">
	<div class="row">
		<div class="col-lg-3 col-md-4">
			<div class="ibox">
				<div class="ibox-body text-center">
					<div class="m-t-20">
						<div style="width: 230px; height: 230px; overflow: hidden; border-radius: 50%; ">
							<img src="<?php echo base_url(); ?>./assets/img/users/<?php echo $users->foto_user ?>"
								alt="User Foto" style="width: 100%; height: 100%; object-fit: cover; ">
						</div>
					</div>
					<h5 class="font-strong m-b-10 m-t-10">
						<?php echo $users->nama ?>
					</h5>
					<div class="m-b-20 text-muted">
						<?php echo $users->nama_kategori ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-md-8">
			<div class="ibox">
				<div class="ibox-body">
					<ul class="nav nav-tabs tabs-line">
						<li class="nav-item">
							<a class="nav-link active" href="#tab-1" data-toggle="tab"><i class="ti-settings"></i>
							Settings</a>
						</li>
					</ul>
					<div class="tab-content">
						<?php if ($this->session->flashdata('success')): ?>
						<div class="alert alert-success">
							<?php echo $this->session->flashdata('success'); ?>
						</div>
						<?php endif; ?>
						<?php if ($this->session->flashdata('error')): ?>
						<div class="alert alert-danger">
							<?php echo $this->session->flashdata('error'); ?>
						</div>
						<?php endif; ?>
						<div class="tab-pane fade show active" id="tab-1">
							<div class="row">
								<div class="col-md-12" style="border-right: 1px solid #eee;">
									<form method="post" action="<?php echo site_url('Teknisi/Profil/updateDataProfile/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data" id="form-sample-1">
										<div class="row">
											<div class="col-sm-6 form-group">
												<label>ID Teknisi</label>
												<input class="form-control" type="text" placeholder="ID Teknisi"
													value="<?php echo $users->karyawan_id ?>" disabled>
											</div>
											<div class="col-sm-6 form-group">
												<label>Nama Lengkap</label>
												<input class="form-control" type="text" name="nama" id="nama" oninput="validateInput(this)"
													placeholder="Nama Lengkap" value="<?php echo $users->nama ?>">
<p id="error-message" style="color: red;"></p>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 form-group">
												<label>Username</label>
												<input class="form-control" type="text" name="username"
													id="username" placeholder="Username"
													value="<?php echo $users->username ?>">
											</div>
											<div class="col-sm-6 form-group">
												<label>Unit Kerja</label>
												<input class="form-control" type="text" placeholder="Divisi"
													value="<?php echo $users->nama_departemen ?>" disabled>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 form-group">
												<label>Email</label>
												<input class="form-control" type="email" name="email" id="email"
													placeholder="Email address" value="<?php echo $users->email ?>">
											</div>
										</div>
										<div class="form-group">
											<label>Foto</label>
											<input class="form-control" type="file" name="foto" id="foto"
												placeholder="" accept="image/jpg, image/jpeg, image/png">
										</div>
										<div class="form-group">
											<button class="btn btn-primary" type="submit">Submit</button>
											<a class="btn" href="#" data-toggle="modal" data-target="#resetPasswordModal">Ganti Password?</a>
										</div>
									</form>
								</div>
							</div>
							<h4 class="text-info m-b-20 m-t-20"><i class="fa-solid fa-clock-rotate-left"></i>
								Riwayat Pengajuan Request
							</h4>
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Request ID</th>
										<th>Perangkat</th>
										<th>Deskripsi Masalah</th>
										<th width="91px">Tanggal Pengajuan</th>
										<th>Status</th>
										<th width="91px">Tanggal Penyelesaian</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tickets as $ticket): ?>
									<tr>
										<td>
											<?php echo $ticket->request_id; ?>
										</td>
										<td>
											<?php echo $ticket->nama_perangkat; ?>
										</td>
										<td>
											<?php echo $ticket->deskripsi_permasalahan; ?>
										</td>
										<td>
											<?php echo $ticket->tanggal_dibuat; ?>
										</td>
										<td>
											<?php if ($ticket->status == 'PENGAJUAN'): ?>
											<span class="badge badge-warning">
											<?php echo $ticket->status; ?>
											</span>
											<?php elseif ($ticket->status == 'SELESAI' || $ticket->status == 'BERJALAN' || $ticket->status == 'DIPAKAI'): ?>
											<span class="badge badge-success">
											<?php echo $ticket->status; ?>
											</span>
											<?php elseif ($ticket->status == 'PROSES'): ?>
											<span class="badge badge-default">
											<?php echo $ticket->status; ?>
											</span>
											<?php else: ?>
											<span class="badge badge-danger">
											<?php echo $ticket->status; ?>
											</span>
											<?php endif; ?>
										</td>
										<td>
											<?php echo !empty($ticket->tanggal_ditangani) ? $ticket->tanggal_ditangani : "Belum Selesai"; ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<!-- Modal Konfirmasi Ganti Password -->
						<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="confirmPasswordModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="confirmPasswordModalLabel">Ganti Password</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" action="<?php echo site_url('Teknisi/Profil/gantiPassword'); ?>">
											<div class="form-group">
												<label>Konfirmasi Password Lama</label>
												<input class="form-control" type="text" name="user_id" value="<?= $this->session->userdata('user_id')?>" hidden required>
												<input class="form-control" type="text" name="username" value="<?= $this->session->userdata('username')?>" hidden required>
												<input class="form-control" type="password" name="old_password" placeholder="Password Lama" required>
											</div>
											<div class="form-group">
												<label>Masukan Password Baru</label>
												<input class="form-control" type="password" name="new_password" placeholder="Password Baru" required>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
												<button class="btn btn-primary" type="submit">Konfirmasi</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		.profile-social a {
		font-size: 16px;
		margin: 0 10px;
		color: #999;
		}
		.profile-social a:hover {
		color: #485b6f;
		}
		.profile-stat-count {
		font-size: 22px
		}
	</style>
</div>