<div id="my-nav" class="side-nav">
                        <ul class="navbar-nav flex-column vertical-nav">

                            <div class="user-image-container">
                                <img src="<?= $user->display_user_photo() ?>" alt="" id="user_image">
                            </div>
                            

                            <!-- SIDEBAR MENUS -->
                            <li class="nav-item ">
                                <a class="nav-link" href="profile.php"> <i class="fas fa-user-shield"></i> Profile</a>
                            </li>

                            <?php if($user->user_role == "user"): ?>
                                <li class="nav-item">
                                    <a class="nav-link " href="index.php" > <i class="fas fa-calendar-check"></i> My attendance</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="payroll.php" > <i class="fas fa-file-invoice-dollar"></i> My payroll</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="user_appeal.php" > <i class="fas fa-exclamation"></i> Appeal</a>
                                </li>

                            

                            <?php endif; ?>
                            
                            
                            <li class="nav-item">
                                <a class="nav-link " href="logout.php" > <i class="fas fa-arrow-alt-circle-left"></i> Log out</a>
                            </li>
                        </ul>
                </div>