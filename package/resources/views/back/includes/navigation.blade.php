<li class="{{ isActiveRoute('back.classifiers.*', 'mm-active') }}">
    <a href="#" aria-expanded="false"><i class="fa fa-list-alt"></i> <span class="nav-label">Классификаторы</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        @include('admin.module.classifiers.groups::back.includes.package_navigation')
        @include('admin.module.classifiers.entries::back.includes.package_navigation')
    </ul>
</li>
