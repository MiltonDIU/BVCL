<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users-cog c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                        @can('audit_log_access')
                            <li class="c-sidebar-nav-item">
                                <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                    <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                    </i>
                                    {{ trans('cruds.auditLog.title') }}
                                </a>
                            </li>
                        @endcan
                </ul>
            </li>
        @endcan


        @if(Gate::check('business_category_access') || Gate::check('business_access'))
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">
                    </i>
                    {{ trans('cruds.business.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">


        @can('business_category_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.business-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/business-categories") || request()->is("admin/business-categories/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-list-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.businessCategory.title') }}
                </a>
            </li>
        @endcan
        @can('business_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.businesses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/businesses") || request()->is("admin/businesses/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-business-time c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.business.title') }}
                </a>
            </li>
        @endcan
                </ul>
            </li>
        @endif




        @if(Gate::check('setting_access') || Gate::check('country_access'))
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.settings.edit") }}" class="c-sidebar-nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-wrench c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.setting.title') }}
                            </a>
                        </li>
                    @endcan
                        @can('country_access')
                            <li class="c-sidebar-nav-item">
                                <a href="{{ route("admin.countries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "c-active" : "" }}">
                                    <i class="fa-fw fas fa-globe c-sidebar-nav-icon">
                                    </i>
                                    {{ trans('cruds.country.title') }}
                                </a>
                            </li>
                        @endcan
                </ul>
            </li>
        @endif





        @if(Gate::check('service_status_access') || Gate::check('service_access') || Gate::check('service_history_access'))
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-servicestack c-sidebar-nav-icon">
                    </i>
                    {{ trans('cruds.service.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('service_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.service-statuses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/service-statuses") || request()->is("admin/service-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-list-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.serviceStatus.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('service_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.services.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/services") || request()->is("admin/services/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-calendar-check c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.service.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('service_history_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.service-histories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/service-histories") || request()->is("admin/service-histories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fa fa-history c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.serviceHistory.title') }}
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endif




    @can('profile_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.profiles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin.profiles") || request()->is("admin.profiles/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.profile.title') }}
                </a>
            </li>
        @endcan

        @can('profile_edit')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("profile.my-profile.edit") }}" class="c-sidebar-nav-link {{ request()->is("profile/my-profile") || request()->is("profile/my-profile/*") ? "c-active" : "" }}">
                    <i class="far fa-id-card c-sidebar-nav-icon">

                    </i>
                    {{ trans('global.my_profile') }}
                </a>
            </li>
        @endcan

        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif


        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>

        @if(Gate::check('question_access') || Gate::check('answer_access')|| Gate::check('assessment_access'))
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-servicestack c-sidebar-nav-icon">
                    </i>
                    {{ trans('cruds.assessment.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('question_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.questions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/questions") || request()->is("admin/questions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-question c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.question.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('answer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.answers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/answers") || request()->is("admin/answers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-diagnoses c-sidebar-nav-icon">
                                </i>
                                {{ trans('cruds.answer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('assessment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.assessments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/assessments") || request()->is("admin/assessments/*") ? "c-active" : "" }}">
                                <i class="fas fa-diagnoses c-sidebar-nav-icon"></i>
                                {{ trans('cruds.assessment.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

        @endif
    </ul>

</div>
