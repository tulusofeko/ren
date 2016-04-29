<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="{{ url('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>Alexander Pierce</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- search form -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
      <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
      </span>
    </div>
  </form>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul id="sidemenu" class="sidebar-menu">
    <!-- Menu will loaded by js -->
    <?php $generator =  function ($menus) use (&$generator) { ?>
      @foreach ($menus as $menu)
        
        @if (isset($menu->type) AND $menu->type === "header")
          <li class='header'>{{ $menu->title }} </li>
          @continue
        @endif

        <?php if(!isset($menu->url)) $menu->url = '#' ?>
        
        <li class="{{ isset($menu->childs) ? "treeview" : '' }}">
          <a href="{{ url($menu->url) }}" title="{{ $menu->title }}"
            @if (url($menu->url) == url()->current())
              active
            @endif
          > 
            <i class="fa {{ $menu->icon or "fa-circle-o"}}"></i>
            <span>{{ $menu->title }}</span>
            
            @if (isset($menu->label)) 
            <span class="label label-{{ $menu->label[1] or 'primary' }} pull-right">
                {{ $menu->label[0] or '' }}
            </span>
            @elseif (isset($menu->childs))
              <i class='fa fa-angle-left pull-right'></i>
            @endif

          </a>
          
          @if (isset($menu->childs))
            <ul class="treeview-menu"> <?php $generator($menu->childs) ?> </ul>
          @endif
        
        </li>
      @endforeach
    <?php }; $generator($menus); ?>
  </ul>
</section>
<!-- /.sidebar -->