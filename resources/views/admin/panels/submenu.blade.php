{{-- For submenu --}}
<ul class="menu-content">
  @if(isset($menu))
  @foreach($menu as $submenu)
  <li @if(property_exists($submenu, 'route') && $submenu->route === Route::currentRouteName()) class="active" @endif>
    <a href="{{ (isset($submenu->route) && !empty($submenu->route))? route($submenu->route):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
      @if(isset($submenu->icon))
      <i data-feather="{{$submenu->icon}}"></i>
      @endif
      <span class="menu-item text-truncate" title="{{ __('locale.'.$submenu->name) }}">{{ __('locale.'.$submenu->name) }}</span>
    </a>
    @if (isset($submenu->submenu))
    @include('admin.panels.submenu', ['menu' => $submenu->submenu])
    @endif
  </li>
  @endforeach
  @endif
</ul>
