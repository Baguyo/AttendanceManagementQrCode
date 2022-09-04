<div id="my-nav" class="side-nav">
                        <ul class="navbar-nav flex-column vertical-nav">

                            <div class="user-image-container">
                                <img src="<?= $user->display_user_photo() ?>" alt="" id="user_image">
                            </div>
                            

                            <!-- SIDEBAR MENUS -->
                                <li class="nav-item ">
                                    <a class="nav-link" href="profile.php"> <i class="fas fa-user-shield"></i> Profile</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="payroll.php" > <i class="fas fa-file-invoice-dollar"></i> Payroll list</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="allowance.php" > <i class="fas fa-money-bills"></i> Allowance List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="admin_deduction.php" > <i class="fas fa-minus"></i> Deduction List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="position_list.php" > <i class="fas fa-note-sticky"></i> Position List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="admin_department.php" > <i class="fas fa-building-user"></i> Department List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="admin_appeal.php" > <i class="fas fa-file-lines"></i> Check appeal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="check_attendance.php" > <i class="fas fa-calendar-check"></i> Check attendance</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link " href="users.php" > <i class="fas fa-users"></i> Users</a>
                                </li>
                            
                            
                            
                            <li class="nav-item">
                                <a class="nav-link " href="logout.php" > <i class="fas fa-arrow-alt-circle-left"></i> Log out</a>
                            </li>
                        </ul>
                </div>