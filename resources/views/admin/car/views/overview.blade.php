<link href="{{asset('css/admin/assets/car/overview.css')}}" rel="stylesheet">

<div id="wrapper" ng-controller="overviewController">
    {{--<h1> Overview</h1>--}}
    {{--<hr>--}}

    <div id="notifications">
        <h2>Notifications</h2>
        <hr>
        <div class="alert-box" ng-repeat="notification in vm.notifications | orderBy: 'days_left'"
             ng-class="notification.class">
            <div class="alert-icon">
                <i ng-if="notification.class == 'info'" class="fa fa-5x fa-info-circle"></i>
                <i ng-if="notification.class == 'warning'" class="fa fa-5x fa-exclamation-triangle"></i>
                <i ng-if="notification.class == 'danger'" class="fa fa-5x fa-times-circle"></i>
            </div>
            <div class="alert-main">
                <p class="alert-title">@{{ notification.title }}</p>

                <p class="alert-body">@{{ notification.message }}</p>
            </div>
            <div class="alert-extra"></div>
        </div>
    </div>

    <div id="contract">
        <h2>Current Contract</h2>
        <hr>
        <div ng-if="vm.contract" class="alert alert-info">
            <strong>Driver</strong>

            <p>@{{ vm.contract.driver.name }}</p>

            <p>@{{ vm.contract.driver.email }}</p>
            <strong>Actual Start Date</strong>

            <p>@{{ formatDate(vm.contract.act_start_dt) }}</p>
            <strong>Status</strong>

            <p>@{{ vm.contract.x_status.key }}</p>

        </div>


    </div>
</div>