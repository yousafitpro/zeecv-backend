<div class="sidebar">

    <div class="sidebar-background"></div>
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{auth()->user()->avatar()}}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info"  >
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span >
									<span style="margin-top:10px">{{substr(auth()->user()->name,0,20)}}</span>
{{--									<span class="user-level">Administrator</span>--}}
									<span class="caret"></span>
								</span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="{{url('profile')}}">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('profile')}}">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
{{--                            <li>--}}
{{--                                <a href="#settings">--}}
{{--                                    <span class="link-collapse">Settings</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item {{request()->is('dashboard')?'active':''}}">
                    <a href="{{url('/dashboard')}}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(is_has_permission('roles.roles.sidebar_menu'))
                <li class="nav-item {{ request()->routeIs('companies.*') ? 'active' : '' }} {{ request()->routeIs('companies.*') ? 'submenu' : '' }}" >
                    <a data-toggle="collapse" href="#roles" class="collapsed" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                        <p>Roles</p>
                        <span class="caret" style="zoom: 1.6"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('roles.*') ? 'show' : '' }}" id="roles" style="">

                        <ul class="nav nav-collapse">
                            @if(is_has_permission('roles.roles.view'))
                            <li class="{{ request()->routeIs('roles.roles') ? 'active' : '' }}">
                                <a href="{{route('roles.roles')}}">
                                    <span class="sub-item">Roles</span>
                                </a>
                            </li>
                            @endif
                            @if(is_has_permission('roles.permissions.view'))
                            <li class="{{ request()->routeIs('roles.permissions') ? 'active' : '' }}">
                                <a href="{{route('roles.permissions')}}">
                                    <span class="sub-item">Permissions</span>
                                </a>
                            </li>
                            @endif
                            @if(is_has_permission('roles.users.view'))
                            <li class="{{ request()->routeIs('roles.users') ? 'active' : '' }}">
                                <a href="{{route('roles.users')}}">
                                    <span class="sub-item">Users</span>
                                </a>
                            </li>
                            @endif




                        </ul>
                    </div>
                </li>
                @endif
                @if(is_has_permission('jobs.sidebar_menu'))
                <li class="nav-item {{ request()->routeIs('jobs.*') ? 'active' : '' }} {{ request()->routeIs('jobs.*') ? 'submenu' : '' }}" >
                    <a data-toggle="collapse" href="#jobs" class="collapsed" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                        <p>Jobs</p>
                        <span class="caret" style="zoom: 1.6"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('jobs.*') ? 'show' : '' }}" id="jobs" style="">

                        <ul class="nav nav-collapse">
                            @if(is_has_permission('jobs.my'))
                            <li class="{{ request()->routeIs('jobs.my') ? 'active' : '' }}">
                                <a href="{{route('jobs.my')}}">
                                    <span class="sub-item">Posted Jobs</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
            @if(is_has_permission('pmm.merchants.view'))
               <li class="nav-item {{ request()->routeIs('pmm.merchants.*') ? 'active' : '' }}">
                    <a href="{{route('pmm.merchants.view')}}">
                       <i class="fas fa-store"></i>
                        <p>Merchants</p>
                    </a>
                </li>
            @endif
            @if(is_has_permission('pmm.ledger.balance.view'))
               <li class="nav-item {{ request()->routeIs('pmm.ledger.balance.*') ? 'active' : '' }}">
                    <a href="{{route('pmm.ledger.balance.view')}}">
                       <i class="fas fa-coins"></i>
                        <p>Manage Balances</p>
                    </a>
                </li>
            @endif
               @if(is_has_permission('blog.posts.view'))
               <li class="nav-item {{ request()->routeIs('blog.posts.*') ? 'active' : '' }}">
                    <a href="{{route('blog.posts.view')}}">
                       <i class="fas fa-bullhorn"></i>
                        <p>Tutorials</p>
                    </a>
                </li>
            @endif
                    @if(is_has_permission('pages.page.view'))
               <li class="nav-item {{ request()->routeIs('pages.page.*') ? 'active' : '' }}">
                    <a href="{{route('pages.page.view')}}">
                       <i class="fas fa-file-alt"></i>
                        <p>Pages</p>
                    </a>
                </li>
            @endif
                {{-- @if(is_has_permission('pmm.marketers.view'))
               <li class="nav-item {{ request()->routeIs('pmm.marketers.*') ? 'active' : '' }}">
                    <a href="{{route('pmm.marketers.view')}}">
                       <i class="fas fa-store"></i>
                        <p>Marketers</p>
                    </a>
                </li>
            @endif --}}
            @if(is_has_permission('pmm.products.view'))
               <li class="nav-item {{ request()->routeIs('pmm.products.*') ? 'active' : '' }}">
                <a href="{{route('pmm.products.view')}}"><i class="fas fa-box-open"></i>
                        <p>Campaigns</p>
                    </a>
                </li>
            @endif
            {{-- @if(is_has_permission('pmm.affiliates.view'))
               <li class="nav-item {{ request()->routeIs('pmm.affiliates.*') ? 'active' : '' }}">
                    <a href="{{route('pmm.affiliates.view')}}">
                       <i class="fas fa-users"></i>
                        <p>Affiliates</p>
                    </a>
                </li>
            @endif --}}
            {{-- @if(is_has_permission('pmm.affiliate_links.view'))
               <li class="nav-item {{ request()->routeIs('pmm.affiliate_links.*') ? 'active' : '' }}">
                    <a href="{{route('pmm.affiliate_links.view')}}">
                       <i class="fas fa-link"></i>
                        <p>Affiliate Links</p>
                    </a>
                </li>
            @endif --}}
              @if(is_has_permission('pmm.transactions.view'))
               <li class="nav-item {{ request()->routeIs('transactions.view.*') ? 'active' : '' }}">
                    <a href="{{route('pmm.transactions.view')}}">
                       <i class="fas fa-money-check-alt"></i>
                        <p>Transactions</p>
                    </a>
                </li>
            @endif
            @if(is_has_permission('pmm.withdrawal.view'))
               <li class="nav-item {{ request()->routeIs('pmm.withdrawal.*') ? 'active' : '' }}">
                    <a href="{{route('pmm.withdrawal.view')}}">
                       <i class="fas fa-money-bill-wave "></i>
                        <p>Payouts</p>
                    </a>
                </li>
            @endif

                            @if(is_has_permission('sp.view'))
               <li class="nav-item {{ request()->routeIs('sp.*') ? 'active' : '' }}">
                    <a href="{{route('sp.sp.view')}}">
                       <i class="fas fa-info-circle"></i>
                        <p>Support</p>
                    </a>
                </li>
            @endif

                @if(is_has_permission('system.connect.sidebar_bar_menu'))
                <li class="nav-item {{ request()->routeIs('system.connect.*') ? 'active' : '' }} {{ request()->routeIs('system.connect.*') ? 'submenu' : '' }}" >
                    <a data-toggle="collapse" href="#systemConnect" class="collapsed" aria-expanded="false">
                        <i class="fas fa-sync"></i>
                        <p>Connect</p>
                        <span class="caret" style="zoom: 1.6"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('system.connect.*') ? 'show' : '' }}" id="systemConnect" style="">

                        <ul class="nav nav-collapse">
                            @if(is_has_permission('system.connect.telegram.view'))
                            <li class="{{ request()->routeIs('system.connect.telegram.view') ? 'active' : '' }}">
                                <a href="{{route('system.connect.telegram.view')}}">
                                    <span class="sub-item">Telegram</span>
                                </a>
                            </li>
                            @endif
                            {{-- @if(is_has_permission('system.connect.customdomain.view'))
                            <li class="{{ request()->routeIs('system.connect.customdomain.view') ? 'active' : '' }}">
                                <a href="{{route('system.connect.customdomain.view')}}">
                                    <span class="sub-item">Custom Domain</span>
                                </a>
                            </li>
                            @endif --}}

                        </ul>
                    </div>
                </li>
                @endif
                @if(is_has_permission('system.setting.sidebar_bar_menu'))
                <li class="nav-item {{ request()->routeIs('system.setting.*') ? 'active' : '' }} {{ request()->routeIs('system.setting.*') ? 'submenu' : '' }}" >
                    <a data-toggle="collapse" href="#setting" class="collapsed" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                        <p>Setting</p>
                        <span class="caret" style="zoom: 1.6"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('system.setting.*') ? 'show' : '' }}" id="setting" style="">

                        <ul class="nav nav-collapse">
                            @if(is_has_permission('system.setting.app.view'))
                            <li class="{{ request()->routeIs('system.setting.app.view') ? 'active' : '' }}">
                                <a href="{{route('system.setting.app.view')}}">
                                    <span class="sub-item">App</span>
                                </a>
                            </li>
                            @endif

                        </ul>
                    </div>
                </li>
                @endif
                      <li class="nav-item {{ request()->routeIs('frontend.terms') ? 'active' : '' }}">
                    <a href="{{route('frontend.terms')}}" target="_blank">
                       <i class="fas fa-file-alt "></i>
                        <p>Terms of service</p>
                    </a>
                </li>
                     @if(is_has_permission('pmm.cc'))
                        <li class="nav-item {{ request()->routeIs('system.CallCenter.*') ? 'active submenu' : '' }}">
                                <a data-toggle="collapse" href="#callCenterMenu" class="collapsed" aria-expanded="{{ request()->routeIs('system.CallCenter.*') ? 'true' : 'false' }}">
                                    <i class="fas fa-headset"></i>
                                    <p>Call Center</p>
                                    <span class="caret" style="zoom: 1.6"></span>
                                    </a>

                                <div class="collapse {{ request()->routeIs('system.CallCenter.*') ? 'show' : '' }}" id="callCenterMenu">
                                    <ul class="nav nav-collapse">
                                       
                                        <li class="{{ request()->routeIs('system.CallCenter.orders') ? 'active' : '' }}">
                                            <a href="{{ route('system.CallCenter.orders') }}">
                                                <span class="sub-item">Orders</span>
                                            </a>
                                        </li>
                                        @if(is_has_permission('pmm.cc.dashboard'))
                                          <li class="{{ request()->routeIs('system.CallCenter.dashboard') ? 'active' : '' }}">
                                            <a href="{{ route('system.CallCenter.dashboard') }}">
                                                <span class="sub-item">Dashboard</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(is_has_permission('system.CallCenter.operator.view'))
                                          <li class="{{ request()->routeIs('system.CallCenter.operator.view') ? 'active' : '' }}">
                                            <a href="{{ route('system.CallCenter.operator.view') }}">
                                                <span class="sub-item">Operators</span>
                                            </a>
                                        </li>
                                        @endif
                                        
             
             
                                        </ul>
                                    </div>
                                </li>
                @endif
              @if(is_has_permission('pmm.lookup'))
                <li class="nav-item {{ request()->routeIs('system.Lookup.*') ? 'active submenu' : '' }}">
                    <a data-toggle="collapse" href="#lookupMenu" class="collapsed" aria-expanded="false">
                        <i class="fas fa-search"></i> {{-- 🔍 better icon for lookup --}}
                        <p>Look Up</p>
                        <span class="caret" style="zoom: 1.6"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('system.Lookup.*') ? 'show' : '' }}" id="lookupMenu">
                        <ul class="nav nav-collapse">
                            @if(is_has_permission('system.setting.app.view'))
                            <li class="{{ request()->routeIs('system.Lookup.Category') ? 'active' : '' }}">
                                <a href="{{ route('system.Lookup.Category') }}">
                                    <i class="fas fa-list"></i>
                                    <span class="sub-item">Category</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('system.Lookup.address') ? 'active' : '' }}">
                                <a href="{{ route('system.Lookup.address') }}">
                                    <i class="fas fa-list"></i>
                                    <span class="sub-item">Address</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('pmm.parcel.view') ? 'active' : '' }}">
                                <a href="{{ route('pmm.parcel.view') }}">
                                    <i class="fas fa-list"></i>
                                    <span class="sub-item">Parcels</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('pmm.profile.gls') ? 'active' : '' }}">
                                <a href="{{ route('pmm.profile.gls') }}">
                                    <i class="fas fa-list"></i>
                                    <span class="sub-item">GLS Profiles</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif



            </ul>

                    <br>
                    <br>
                    <br>



            </ul>
        </div>
    </div>
</div>
