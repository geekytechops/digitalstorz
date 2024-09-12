<div aria-live="polite" aria-atomic="true" class="toast-success">
<div class="toast fade show align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
<div class="d-flex">
    <div class="toast-body">
        Hello, world! This is a toast message.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
</div>
</div>


<div id="otherStaffModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="otherStaffModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otherStaffModelLabel">Modal Heading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="other_staff_create_model">
            <div class="form-group">
            <label for="other_staff_name">Staff Name</label>
            <input type="text" class="form-control" id="other_staff_name" required>
            </div>
            <div class="form-group">
            <label for="Mobile">Mobile Number</label>
            <input type="tel" class="form-control" id="other_staff_contact" required>
            </div>
            <button type="button" class="btn btn-success mt-2" onclick="createOtherStaff($('#other_staff_name').val() , $('#other_staff_contact').val())">Create Staff</button>
        </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="patternModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="patternModelLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="patternModelLabel">Mobile Lock</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="other_staff_create_model">
        <div>
								<h5 class="text-center">Add Screen Lock</h5>
								<h6 class="text-center">Screen Lock Type</h6>
							</div>
							<div class="row flex-column align-items-center">
							<div class="col-md-6 pattern_lock" id="pattern_lock">
								<svg class="patternlock" id="lock" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
									<g class="lock-actives"></g>
									<g class="lock-lines"></g>
									<g class="lock-dots">
										<circle cx="20" cy="20" r="1"/>
										<circle cx="50" cy="20" r="1"/>
										<circle cx="80" cy="20" r="1"/>

										<circle cx="20" cy="50" r="1"/>
										<circle cx="50" cy="50" r="1"/>
										<circle cx="80" cy="50" r="1"/>

										<circle cx="20" cy="80" r="1"/>
										<circle cx="50" cy="80" r="1"/>
										<circle cx="80" cy="80" r="1"/>
									</g>
								<svg>
							</div>
							<div class="col-md-6 text-center mt-4 mb-4" id="pin_lock" style="display:none">
								<input type="text" name="pin-lock" id="pin-lock" class="form-control mt-4" >
								<input type="hidden" name="patternlock_data1" id="patternlock_data1">
							</div>							
						</div>
        <button type="button" class="btn btn-success mt-2" onclick="addLockData()">Add Lock</button>
    </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box text-center">
                            <a href="index.html" class="logo logo-dark"> <?=$session_store_name?></a>

                            <a href="index.html" class="logo logo-light"><?=$session_store_name?></a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>

                    </div>

                    <div class="d-flex">                                                              

                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="img/admin.png"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1"><?php echo $_SESSION['session_staff_name'];?></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="change-password-ui"><i class="ri-user-line align-middle me-1"></i> Change Password</a>
                                <a class="dropdown-item" href="user-plan-details-ui"><i class="ri-wallet-2-line align-middle me-1"></i> Plan Details</a>
                                <a class="dropdown-item d-block" href="settings"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                                <a class="dropdown-item" href="manage-users-ui"><i class="ri-lock-unlock-line align-middle me-1"></i> Manage Users</a>
                                <a class="dropdown-item" href="manage-store-ui"><i class="ri-lock-unlock-line align-middle me-1"></i> Manage Store</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="logout"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>