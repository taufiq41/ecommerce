<ul class="d-flex align-items-center">
    @php
        $user = auth()->user();
        if($user){
            $countCarts = \App\Models\Cart::select('id')->where('user_id',$user->id)->count();
        }else{
            $countCarts = 0;
        }
    @endphp

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->
    @guest
        <li class="nav-item dropdown pe-3">
            <a href="{{ route('login') }}" class="nav-link d-block text-primary">Masuk</a>
        </li>
        <li class="nav-item dropdown pe-3">
            <a href="{{ route('register') }}" class="nav-link d-block text-primary">Registrasi</a>
        </li>
    @endif

    @if(auth()->check())
        @php
            $user = auth()->user();
        @endphp

        @if($user)
            @if($user->level_id == '2')
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="{{ route('user.cart.index') }}">
                        <i class="bi bi-cart"></i>
                        <span class="badge bg-primary badge-number">{{ $countCarts != 0 ? $countCarts : '' }}</span>
                    </a>
                </li>
            @endif
        @endif
        <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{ asset('template/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{ $user->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6>{{ $user->name }}</h6>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                @if($user->level_id == '2')
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('user.transaction.index') }}">
                            <i class="bi bi-bucket-fill"></i>
                            <span>Riwayat Pesanan</span>
                        </a>
                    </li>
                @endif

                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </li
    @endif

  </ul>
