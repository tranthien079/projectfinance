
<header>
    <!-- Humbager -->
    <div class="humbager">
        <i class="mdi mdi-menu"></i>
    </div>
    <!-- logo -->
    <div class="branding">
        <a href="{{ route('dashboard.index') }}">
            <img src="{{ asset('uploads/app/logo.png') }}" class="img-responsive" style=" filter:hue-rotate(200deg); max-width: 70%!important;">
        </a>
    </div>

    <!-- Navigation -->
    <nav class="navigation">
        <ul class="nav navbar-nav">
          <li class="nav-item @if(Route::currentRouteName() == 'dashboard.index') active @endif"><a class="nav-link" href="{{ route('dashboard.index') }}">{{__('pages.sections.overview')}}</a></li>
         
          {{-- <li class="nav-item"><a class="nav-link href="{{ route('dashboard.index') }}">{{__('pages.sections.overview')}}</a></li> --}}
          <li class="nav-item @if(Route::currentRouteName() == 'expense.index') active @endif"><a class="nav-link" href="{{ route('expense.index') }}">{{__('pages.sections.expenses')}}</a></li>
          <li class="nav-item @if(Route::currentRouteName() == 'income.index') active @endif"><a class="nav-link" href="{{ route('income.index') }}">{{__('pages.sections.income')}}</a></li>
          <li class="nav-item @if(Route::currentRouteName() == 'account.index') active @endif"><a class="nav-link " href="{{ route('account.index') }}">{{__('pages.sections.account')}}</a></li>
          <li class="nav-item @if(Route::currentRouteName() == 'budget.index') active @endif"><a class="nav-link " href="{{ route('budget.index') }}">{{__('pages.sections.budget')}}</a></li>
          <li class="nav-item @if(Route::currentRouteName() == 'bookbank.index') active @endif"><a class="nav-link " href="{{ route('bookbank.index') }}">{{__('pages.sections.bookbank')}}</a></li>
          <li class="close-menu"><a href=""><i class="mdi mdi-close-circle-outline"></i> {{__('pages.options.close')}}</a></li>
        </ul>
    </nav>

    <!-- Right content -->
    <div class="header-right">
        <a href="{{ route('app.setLocale', ['locale' => 'en']) }}" class="lang-link flex-c-m trans-04 p-lr-25">
            EN
        </a>
        
        <a href="{{ route('app.setLocale', ['locale' => 'vi']) }}" class="flex-c-m trans-04 p-lr-25">
            VI
        </a>
        
     
        {{-- <div class="dropdown hidden-sm hidden-xs">
          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span><i class="mdi mdi-plus-circle-outline"></i></span> {{__('pages.options.new-record')}}</button>
          <ul class="dropdown-menu">
              <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#addExpense"> <i class="mdi mdi-chevron-right"></i> {{__('pages.options.expense')}}</a></li>
              <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#addIncome"> <i class="mdi mdi-chevron-right"></i> {{__('pages.options.income')}}</a></li>
          </ul>
        </div>
         --}}
        <div class="dropdown">
            <span class="dropdown-toggle" data-toggle="dropdown">
                <span class="avatar">
                    {{-- @if(empty(user()->avatar))
                     <img src="{{ asset('assets/images/avatar.png') }}" class="img-circle">
                    @else 
                     <img src="{{ asset('uploads/avatar/'.$user->avatar) }}" class="img-circle">
                    @endif --}}
                </span>
                <span class="profile-name"> 
                    {{-- <span class="hidden-xs">{{ $user->fname}} {{ $user->lname}}</span>  --}}
                    <i class="mdi mdi-menu-down-outline"></i> 
                </span>
            </span>
            
            <ul class="dropdown-menu profile-menu" role="menu" aria-labelledby="menu1">
              {{-- @if($user->role == 'admin') Users@get--}}
              <li role="presentation"><a role="menuitem" href="{{ route('dashboard.index') }}"> <i class="mdi mdi-account-multiple"></i> {{__('pages.profile-menu.users')}}</a></li>
              {{-- @endif Settings@get--}}
              <li role="presentation"><a role="menuitem" href="{{ route('setting.index') }}"> <i class="mdi mdi-settings"></i> {{__('pages.profile-menu.settings')}}</a></li>
              <li role="presentation"><a role="menuitem" href="{{ route('auth.logout') }}"> <i class="mdi mdi-logout"></i> {{__('pages.profile-menu.logout')}}</a></li>
            </ul>
          </div>
    </div>
</header>
