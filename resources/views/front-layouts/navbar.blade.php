<header id="main_header">
    <div class="container px-0">
        <!--Navbar-->
        <nav class="navbar navbar-expand-lg px-0 custom_menu">
            <!-- Navbar brand -->
            <a class="navbar-brand px-0 mr-0" href="{{url('')}}">
                <img class="img-fluid" src="{{URL::asset('public/front/images/My-Living-Choice-Logo.png')}}"  alt="My-Living-Choice-Logo">
            </a>           
            <!-- flyout menu icon -->
            <div class="fly_out_menu">
                <div class="flyout-search-toggle ">
                    <div class="toggle-search-icon-close d-none">
                        <div class="toggle_menu_icone"></div>
                        <div class="toggle_menu_icon"></div>
                        <div class="toggle_menu_icon"></div>
                    </div>
                    <a class="site-search-icon site-search_btn" aria-hidden="true" aria-label="Toggle Search" href="#"><i class="fas fa-search"></i></a>
                </div>
                <a class="flyout_menu_toggle pr-0" href="#">
                    <div class="toggle_menu_icon"></div>
                    <div class="toggle_menu_icon"></div>
                    <div class="toggle_menu_icon"></div>
                </a>
            </div>
            <!-- <div class="flyout-search">
                <form role="search" class="searchform search-form live-search" method="get" action="#">
                    <div class="search-form-content">
                        <div class="search-field">
                            <label><span class="screen-reader-text">Search for:</span>
                                <input type="search" value="" name="s" class="s" placeholder="Search ..." required="" aria-required="true" aria-label="Search ...">
                            </label>
                        </div>
                        <div class="search-button">
                            <input type="submit" class="search-submit searchsubmit" value="">
                        </div>
                     </div>
                </form>
            </div> -->
            <div class="flyout-menu-bg"></div>
            <!-- main navigation-->
            <div class="navbar" id="nav_menu">
                <!-- Links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active ">
                        <a class="nav-link pl-0" href="{{url('').'/best-senior-living'}}">Best Senior Living</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Find Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('').'/list-community'}}">List Your Community</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('').'/about'}}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('').'/contact-us'}}">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('').'/blog'}}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pr-0" href="{{url('').'/login'}}">Login</a>
                    </li>
                </ul>
                <!-- Links -->
            </div>
            <!-- main navigation -->
            <!-- mmobile navigation-->
            <div class="mobile_nav_holder">
                <!-- Links -->
                <ul class="_mobile_menu"  id="mobile_nav_menu">
                    <li class="nav-item item-active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Find Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">List Your Community</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <!-- Links -->
             </div>
            <!-- mobile navigation -->
            
        </nav>
        <!--/.Navbar-->
    </div>
</header>