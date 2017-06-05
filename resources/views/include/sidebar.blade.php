<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                @if(($img = Auth::user()->img) == null)
                    <img src="{{asset('upload/img_profile/meo.jpg')}}" class="img-circle" alt="User Image">
                @else
                    <img src="{{asset("upload/img_profile/$img")}}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <!-- Trang chủ admin -->
            <li class="active treeview">

                <a href="{{route('admin.homepage')}}">

                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <!-- ./ trang chủ admin -->

            <!-- quản lý sản phẩm -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Quản lý sản phẩm</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">

                    <li><a href="{{route('admin.categories.list')}}"><i class="fa fa-circle-o"></i> Danh mục sản
                            phẩm</a></li>

                    <li><a href="{{route('products.index')}}"><i class="fa fa-circle-o"></i> Sản phẩm</a></li>
                </ul>
            </li>
            <!-- ./ quản lý sản phẩm -->

            <!-- Thống kê thương mại -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Thống kê thương mại</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.sale')}}"><i class="fa fa-circle-o"></i> Doanh Thu</a></li>
                </ul>
            </li>
            <!-- ./thống kê thương mại -->

            <!-- quản lý đơn hàng -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-paper-plane"></i>
                    <span>Quản lý đơn hàng</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('admin.orders.index')}}"><i class="fa fa-circle-o"></i> Đơn Hàng</a></li>
                    <li><a href="{{route('admin.productorder.index')}}"><i class="fa fa-circle-o"></i> Đơn hàng sản phẩm</a></li>
                </ul>
            </li>
            <!-- ./quản lý đơn hàng -->

            <!-- quản lý user -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Quản lý người dùng</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('users.index')}}"><i class="fa fa-circle-o"></i> Ban quản trị</a></li>

                    <li><a href="{{route('admin.users.customer')}}"><i class="fa fa-circle-o"></i> Khách hàng</a></li>
                </ul>
            </li>
            <!-- ./quản lý user -->

            <!-- quản lý tin tức -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> <span>Quản lý bài đăng</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('news.index')}}"><i class="fa fa-circle-o"></i> Tin tức</a></li>
                    <li><a href="{{route('admin.news.getslides')}}"><i class="fa fa-circle-o"></i> slides</a></li>
                    <li><a href="{{route('admin.news.feedbacks')}}"><i class="fa fa-circle-o"></i> Phản hồi</a></li>
                </ul>
            </li>
            <!-- ./quản lý tin tức -->
            <li>
                <a href="pages/mailbox/mailbox.html">
                    <i class="fa fa-envelope"></i> <span>Mailbox</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>