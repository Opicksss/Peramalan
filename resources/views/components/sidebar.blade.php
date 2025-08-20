<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="assets/images/logoo.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">ISTANA JAYA</h4>
				</div>
				<div class="toggle-icon ms-auto"><i id="toggleIcon" class="bx bxs-chevrons-left"></i>
				</div>
			 </div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
                <li>
					<a href="{{route('dashboard')}}">
						<div class="parent-icon flip-animation"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
                <li>
					<a href="{{route('penjualan.index')}}">
						<div class="parent-icon flip-animation"><i class='bx bx-cart-alt' ></i>
						</div>
						<div class="menu-title">Penjualan</div>
					</a>
				</li>
                <li>
                    <a href="{{route('peramalan.index')}}">
                        <div class="parent-icon flip-animation"><i class='bx bx-bar-chart-alt-2'></i>
                        </div>
                        <div class="menu-title">Peramalan</div>
                    </a>
                </li>
                @if(auth()->user() && auth()->user()->role == 'admin')
                <li>
                    <a href="{{route('acount.index')}}">
                        <div class="parent-icon flip-animation"><i class='bx bxs-user-account'></i>
                        </div>
                        <div class="menu-title">Akun</div>
                    </a>
                </li>
                @endif
			</ul>
			<!--end navigation-->
		</div>
