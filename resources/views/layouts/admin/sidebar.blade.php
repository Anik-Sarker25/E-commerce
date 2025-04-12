@php
    // $queryString = request()->getQueryString();
    $queryString = $_SERVER['QUERY_STRING'];
@endphp
        <!-- BEGIN #sidebar -->
		<div id="sidebar" class="app-sidebar">
			<!-- BEGIN scrollbar -->
			<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
				<!-- BEGIN menu -->
				<div class="menu">
					<div class="menu-header">Navigation</div>
					<div class="menu-item {{ (Request::is('admin/dashboard')) ? 'active' : '' }}">
						<a href="{{ route('admin.dashboard') }}" class="menu-link">
							<span class="menu-icon"><i class="bi bi-cpu"></i></span>
							<span class="menu-text">Dashboard</span>
						</a>
					</div>
					<div class="menu-item {{ (Request::is('/')) ? 'active' : '' }}">
						<a target="_blank" href="{{ route('home') }}" class="menu-link">
							<span class="menu-icon"><i class="bi bi-globe2"></i></span>
							<span class="menu-text">Visite Site</span>
						</a>
					</div>
					<div class="menu-item has-sub {{ (Request::is('admin/users*')) ? 'expand' : '' }}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="bi bi-people"></i>
							</span>
							<span class="menu-text">Users</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
                            <div class="menu-item {{ Request::is('admin/users/create') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.create') }}" class="menu-link">
                                    <span class="menu-text">Add User</span>
                                </a>
                            </div>
                            <div class="menu-item {{ Request::is('admin/users') && !request()->has('blocked') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.index') }}" class="menu-link">
                                    <span class="menu-text">All Users</span>
                                </a>
                            </div>
                            <div class="menu-item {{ Request::is('admin/users') && request()->has('blocked') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.index') }}?blocked" class="menu-link">
                                    <span class="menu-text">Blocked Users</span>
                                </a>
                            </div>
                        </div>
					</div>

					<div class="menu-item has-sub">
						<a href="javascript:;" class="menu-link">
							<div class="menu-icon">
								<i class="bi bi-bag-check"></i>
								<span class="w-5px h-5px rounded-3 bg-theme position-absolute top-0 end-0 mt-3px me-3px"></span>
							</div>
							<div class="menu-text d-flex align-items-center">POS System</div>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="pos_customer_order.html" target="_blank" class="menu-link">
									<div class="menu-text">Customer Order</div>
								</a>
							</div>
							<div class="menu-item">
								<a href="pos_kitchen_order.html" target="_blank" class="menu-link">
									<div class="menu-text">Kitchen Order</div>
								</a>
							</div>
							<div class="menu-item">
								<a href="pos_counter_checkout.html" target="_blank" class="menu-link">
									<div class="menu-text">Counter Checkout</div>
								</a>
							</div>
							<div class="menu-item">
								<a href="pos_table_booking.html" target="_blank" class="menu-link">
									<div class="menu-text">Table Booking</div>
								</a>
							</div>
							<div class="menu-item">
								<a href="pos_menu_stock.html" target="_blank" class="menu-link">
									<div class="menu-text">Menu Stock</div>
								</a>
							</div>
						</div>
					</div>

					<div class="menu-header">Manage Orders & Products</div>

					<div class="menu-item has-sub {{ (Request::is('admin/orders*')) ? 'expand' : '' }}">
						<a href="#" class="menu-link">
							<span class="menu-icon"><i class="bi bi-cart-plus"></i></span>
							<span class="menu-text">Orders</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>


                        <div class="menu-submenu">
                            <!-- Requested Orders: Active if no query parameters match the ones for the other statuses -->
                            <div class="menu-item {{ (($queryString != 'confirmed_orders') && ($queryString != 'processing_orders') && ($queryString != 'shipped_orders') && ($queryString != 'delivered_orders') && ($queryString != 'canceled_orders') && ($queryString != 'refunded_orders') && ($queryString != 'returned_orders')) ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}" class="menu-link">
                                    <span class="menu-text">Requested Orders</span>
                                </a>
                            </div>

                            <!-- Confirmed Orders -->
                            <div class="menu-item {{ ($queryString == 'confirmed_orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}?confirmed_orders" class="menu-link">
                                    <span class="menu-text">Confirmed Orders</span>
                                </a>
                            </div>

                            <!-- Processing Orders -->
                            <div class="menu-item {{ ($queryString == 'processing_orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}?processing_orders" class="menu-link">
                                    <span class="menu-text">Processing Orders</span>
                                </a>
                            </div>

                            <!-- Shipped Orders -->
                            <div class="menu-item {{ ($queryString == 'shipped_orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}?shipped_orders" class="menu-link">
                                    <span class="menu-text">Shipped Orders</span>
                                </a>
                            </div>

                            <!-- Delivered Orders -->
                            <div class="menu-item {{ ($queryString == 'delivered_orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}?delivered_orders" class="menu-link">
                                    <span class="menu-text">Delivered Orders</span>
                                </a>
                            </div>

                            <!-- Canceled Orders -->
                            <div class="menu-item {{ ($queryString == 'canceled_orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}?canceled_orders" class="menu-link">
                                    <span class="menu-text">Canceled Orders</span>
                                </a>
                            </div>

                            <!-- Refunded Orders -->
                            <div class="menu-item {{ ($queryString == 'refunded_orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}?refunded_orders" class="menu-link">
                                    <span class="menu-text">Refunded Orders</span>
                                </a>
                            </div>

                            <!-- Returned Orders -->
                            <div class="menu-item {{ ($queryString == 'returned_orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders.index') }}?returned_orders" class="menu-link">
                                    <span class="menu-text">Returned Orders</span>
                                </a>
                            </div>
                        </div>


					</div>
					<div class="menu-item has-sub {{ (Request::is('admin/products*')) ? 'expand' : '' }}">
						<a href="#" class="menu-link">
							<span class="menu-icon"><i class="bi bi-box"></i></span>
							<span class="menu-text">Products</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{ Request::is('admin/products/create') ? 'active' : '' }}">
								<a href="{{ route('admin.products.create') }}" class="menu-link">
									<span class="menu-text">Add Product</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/products') ? 'active' : '' }}">
								<a href="{{ route('admin.products.index') }}" class="menu-link">
									<span class="menu-text">Products</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/products/variants') ? 'active' : '' }}">
								<a href="{{ route('admin.products.variants.index') }}" class="menu-link">
									<span class="menu-text">Variants & Stocks</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/products/stock') ? 'active' : '' }}">
								<a href="{{ route('admin.products.stock') }}" class="menu-link">
									<span class="menu-text">Stocks</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/products/brands') ? 'active' : '' }}">
								<a href="{{ route('admin.products.brands.index') }}" class="menu-link">
									<span class="menu-text">Brands</span>
								</a>
							</div>
						</div>
					</div>
					<div class="menu-item has-sub {{ (Request::is('admin/categories*')) || (Request::is('admin/subcategories*')) || (Request::is('admin/childcategories*')) ? 'expand' : '' }}">
						<a href="#" class="menu-link">
							<span class="menu-icon"><i class="bi bi-grid"></i></span>
							<span class="menu-text">Categories</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{ (Request::is('admin/categories')) ? 'active' : '' }}">
								<a href="{{ route('admin.categories.index') }}" class="menu-link">
									<span class="menu-text">Categories</span>
								</a>
							</div>
							<div class="menu-item {{ (Request::is('admin/subcategories')) ? 'active' : '' }}">
								<a href="{{ route('admin.subcategories.index') }}" class="menu-link">
									<span class="menu-text">Sub Categories</span>
								</a>
							</div>
							<div class="menu-item {{ (Request::is('admin/childcategories')) ? 'active' : '' }}">
								<a href="{{ route('admin.childcategories.index') }}" class="menu-link">
									<span class="menu-text">Child Categories</span>
								</a>
							</div>
						</div>
					</div>
					<div class="menu-item {{ (Request::is('admin/dashboard')) ? 'active' : '' }}">
						<a href="{{ route('admin.dashboard') }}" class="menu-link">
							<span class="menu-icon"><i class="bi bi-credit-card"></i></span>
							<span class="menu-text">Transection</span>
						</a>
					</div>

					<div class="menu-divider"></div>

					<div class="menu-header">Manage</div>

					<div class="menu-item has-sub {{ Request::is('admin/settings*') ? 'expand' : '' }}">
						<a href="#" class="menu-link">
							<span class="menu-icon"><i class="bi bi-gear"></i></span>
							<span class="menu-text">Settings</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{ Request::is('admin/settings') ? 'active' : '' }}">
								<a href="{{route('admin.settings.index')}}" class="menu-link">
									<span class="menu-text">General Settings</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/settings/pages') ? 'active' : '' }}">
								<a href="{{ route('admin.settings.pages.index') }}" class="menu-link">
									<span class="menu-text">Page Settings</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/settings/partnerships') ? 'active' : '' }}">
								<a href="{{ route('admin.settings.partnerships.index') }}" class="menu-link">
									<span class="menu-text">Partnerships</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/settings/paymentMethods') ? 'active' : '' }}">
								<a href="{{ route('admin.settings.paymentMethods.index') }}" class="menu-link">
									<span class="menu-text">Payment Method</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/settings/delivery') ? 'active' : '' }}">
								<a href="{{ route('admin.settings.delivery.index') }}" class="menu-link">
									<span class="menu-text">Delivery Settings</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/settings/notices') ? 'active' : '' }}">
								<a href="{{ route('admin.settings.notices.index') }}" class="menu-link">
									<span class="menu-text">Notice</span>
								</a>
							</div>
							<div class="menu-item {{ Request::is('admin/settings/countries') ? 'active' : '' }}">
								<a href="{{ route('admin.settings.countries.index') }}" class="menu-link">
									<span class="menu-text">Country</span>
								</a>
							</div>
						</div>
					</div>
					<div class="menu-item {{ (Request::is('admin/services')) ? 'active' : '' }}">
						<a href="{{ route('admin.services.index') }}" class="menu-link">
							<span class="menu-icon"><i class="bi bi-sliders"></i></span>
							<span class="menu-text">Services</span>
						</a>
					</div>
					<div class="menu-item">
						<a href="javascript:;" onclick="event.preventDefault(); document.getElementById('adminLogoutForm').submit();" class="menu-link">
							<span class="menu-icon"><i class="bi bi-box-arrow-in-right"></i></span>
							<span class="menu-text">Log Out</span>
						</a>
						<form id="adminLogoutForm" action="{{ route('admin.logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</div>
				</div>
				<!-- END menu -->
				<!-- <div class="p-3 px-4 mt-auto">
					<a href="https://seantheme.com/hud/documentation/index.html" target="_blank" class="btn d-block btn-outline-theme">
						<i class="fa fa-code-branch me-2 ms-n2 opacity-5"></i> Documentation
					</a>
				</div> -->
			</div>
			<!-- END scrollbar -->
		</div>
		<!-- END #sidebar -->

