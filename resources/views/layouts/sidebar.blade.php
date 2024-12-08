<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{route('product-listing-page')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo/logo.png') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo/logo.png') }}" alt="" height="30">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{route('product-listing-page')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo/logo.png') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo/logo.png') }}" alt="" height="30">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span>dashboards</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">analytics</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
				<li class="nav-item">
					 <a class="nav-link menu-link" href="#sidebarEcommerce" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEcommerce">
                        <i class="bx bx-cart "></i> <span>Store</span>
                    </a>                               
					<div class="collapse menu-dropdown" id="sidebarEcommerce">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{route('product-listing-page')}}" class="nav-link">Products</a>
							</li>  
							<li class="nav-item">
								<a href="{{route('category-listing-page')}}" class="nav-link">Categories</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">orders</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">order-details</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">customers</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">shopping-cart</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">checkout</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">sellers</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">sellers-details</a>
							</li>
						</ul>
					</div>
				</li>
				
               

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
