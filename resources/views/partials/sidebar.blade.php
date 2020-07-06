<!-- Sidebar -->
<div class="wrap-sidebar bg-gradient-primary">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion navbar-nav-custom" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon rotate-n-15">
            </div>
            <div class="sidebar-brand-text "><img src="{{ asset('/img/hybrid-logo-white.png') }}" alt="logo" width="260px"></div>
        </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <!-- Nav Item - Pages Collapse Menu -->
        @hasrole('admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="user-management.html" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user"></i>
                <span>Quản lý thành viên</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="collapseTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('users.index')}}">Danh sánh thành viên</a>
                    <a class="collapse-item" href="{{route('permission.index')}}">Quản lý permissions</a>
                    <a class="collapse-item" href="{{route('role.index')}}">Quản lý roles</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCourse"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span>Quản lý khóa học</span>
            </a>
            <div id="collapseCourse" class="collapse" aria-labelledby="collapseCourse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('courses.index') }}">Danh sách khóa học</a>
                    <a class="collapse-item" href="{{ route('teams.index') }}">Team</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFormEvaluation"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Quản lý Forms</span>
            </a>
            <div id="collapseFormEvaluation" class="collapse" aria-labelledby="collapseFormEvaluation"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('forms.index') }}">Danh sách form</a>
                    <a class="collapse-item" href="{{route('teamForm.index')}}">Phân quyền đánh giá Form</a>
                    <a class="collapse-item" href="{{route('formPermit.index')}}">Phân quyền đánh giá chéo </a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
        @endhasrole
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvaluation"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-list"></i>
                <span>Quản lý đánh giá</span>
            </a>
            <div id="collapseEvaluation" class="collapse" aria-labelledby="collapseEvaluation"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('evaluations.index')}}">Danh sách đánh giá</a>
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Nav Item - Utilities Collapse Menu -->
        @hasrole('admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCriteria"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Quản lý tiêu chí</span>
            </a>
            <div id="collapseCriteria" class="collapse" aria-labelledby="collapseCriteria"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('mainpoints.index')}}">Main Point</a>
                    <a class="collapse-item" href="{{route('categories.index')}}">Danh mục</a>
                    <a class="collapse-item" href="{{route('criterias.index')}}">Tiêu chí</a>
                </div>
            </div>
        </li>

        <!-- Heading -->
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        @endhasrole
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
</div>
<!-- End of Sidebar -->
