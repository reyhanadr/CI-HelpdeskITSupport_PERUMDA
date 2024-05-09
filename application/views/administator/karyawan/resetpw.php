<div class="content-wrapper">
            <!-- START PAGE CONTENT-->

            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Reset Password</div>
                    </div>
                    <?php
                    if ($this->session->flashdata('succes')) { ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                        <h6>
                        <i class="icon fa fa-check"></i>
                        Password Berhasil
                        <strong>
                            <?= $this->session->flashdata('succes');   ?>
                        </strong>
                        </h6>
                    </div>
                    <?php } ?>
                    <div class="ibox-body">
                        <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-4">
                                        <input class="form-control" id="password" type="password" name="password" placeholder="password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-4">
                                        <input class="form-control" type="password" name="password_confirmation" placeholder="confirm password">
                                        </div>
                                    </div>
                            <div class="form-group row">
                                <div class="col-sm-10 ml-sm-auto">
                                    <button class="btn btn-info" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->