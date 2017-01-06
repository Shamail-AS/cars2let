<link href="{{asset('css/admin/assets/car/overview.css')}}" rel="stylesheet">

<div id="wrapper" ng-controller="partsController">
    <h1><a href="{{url('/admin/car/all')}}"><i class="fa fa-chevron-circle-left"></i> All Cars
        </a> / Tracker + Camera</h1>
    <hr>

    <div id="tracker">
        <h2>Tracker</h2>
        <hr>
        <div>
            <div class="item">
                <label>IMEI : @{{ vm.tracker.imei }}</label>
                <label>Model : @{{ vm.tracker.model }}</label>
                <label>Supplier : @{{ vm.tracker.supplier.name }}</label>
                <label>Installed On : @{{ vm.tracker.installed_at }}</label>
                <label>Status : @{{ vm.tracker.status }}</label>
                <label>Comments : @{{ vm.tracker.comments }}</label>
                <button class="btn btn-primary">New</button>
                <button class="btn btn-info">Edit</button>
                <button class="btn btn-default">Place order</button>
            </div>
            <div class="order">
                <label></label>
            </div>
        </div>
        <div id="sim">
            <h4>SIM</h4>

            <div class="item">
                <label>Number : @{{ tracker.sim.number }}</label>
                <label>PUK : @{{ tracker.sim.puk }}</label>
                <label>PASSCODE : @{{ tracker.sim.passcode }}</label>
                <label>Supplier : @{{ tracker.sim.supplier.name }}</label>
                <button class="btn btn-primary">New</button>
                <button class="btn btn-info">Edit</button>
                <button class="btn btn-default">Place order</button>
            </div>
            <div class="order">

            </div>
        </div>
    </div>

    <div id="Camera">
        <h2>Camera</h2>
        <hr>
        <div>
            <label>Model : @{{ vm.tracker.model }}</label>
            <label>Supplier : @{{ vm.tracker.supplier.name }}</label>
            <label>Installed On : @{{ vm.tracker.installed_at }}</label>
            <label>Status : @{{ vm.tracker.status }}</label>
            <label>Comments : @{{ vm.tracker.comments }}</label>
        </div>
    </div>


</div>