<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu flip-animation"><i class='bx bx-menu'></i>
            </div>
            <div class="search-bar flex-grow-1">
                {{-- <div class="position-relative search-bar-box">
                    <input type="text" class="form-control search-control" placeholder="Type to search..."> <span
                        class="position-absolute top-50 search-show translate-middle-y"><i
                            class='bx bx-search'></i></span>
                    <span class="position-absolute top-50 search-close translate-middle-y"><i
                            class='bx bx-x'></i></span>
                </div> --}}
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none flip-animation" data-bs-toggle="modal"
                        data-bs-target="#SearchModal">
                        <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>
                    <div class="header-message-list app-container header-notifications-list">
                    </div>
                </ul>
            </div>
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::user()->foto && file_exists(storage_path('app/public/' . Auth::user()->foto)))
                        <img class="user-img" src="/storage/{{ Auth::user()->foto }}" alt="user avatar">
                    @else
                        <img class="user-img" src="{{ asset('img/profilDefault.jpg') }}" alt="user avatar">
                    @endif
                    <div class="user-info">
                        <p class="user-name mb-0">{{ ucwords(Auth::user()->name) }}</p>
                        {{-- <p class="designattion mb-0">{{ Auth::user()->email }}</p> --}}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}"><i
                                class="bx bx-user fs-5"></i><span>Profile</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"><i
                                class="bx bx-log-out-circle"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
