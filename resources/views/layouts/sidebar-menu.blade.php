<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <i class="nav-icon fas fa-list red"></i>
          <p>
            Product
          </p>
        </router-link>
      </li>

      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon red"></i>
            <p>Users</p>
          </router-link>
        </li>
      @endcan



      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog blue"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link to="/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol red"></i>
              <p>
                Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/tag" class="nav-link">
              <i class="nav-icon fas fa-tags red"></i>
              <p>
                Tags
              </p>
            </router-link>
          </li>

            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs red"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>

      @endcan



      {{-- <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li> --}}
    </ul>
  </nav>