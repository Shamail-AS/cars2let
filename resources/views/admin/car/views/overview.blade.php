<link href="{{asset('css/admin/assets/car/overview.css')}}" rel="stylesheet">

<div ng-controller="overviewController">
    <h1>Overview</h1>

    <div id="comments">
        <div class="form-group">
            <label>Comments</label>
            <textarea name="message" rows="2" cols="50" class="form-control" placeholder="Comments"
                      ng-model="vm.car.comments"></textarea>
        </div>
        <button class="btn btn-primary pull-right" ng-click="saveSelective(vm.car,'comments')">Save Comments</button>
    </div>

    <div id="alerts">

        <h2>Alerts</h2>

        <div class="alert-box info">
            <div class="alert-icon">
                <i class="fa fa-5x fa-exclamation-triangle"></i>
            </div>
            <div class="alert-main">
                <p class="alert-title">Warranty Expires in 1 month</p>

                <p class="alert-body">No action required. This will go away after the warranty expires.</p>
            </div>
            <div class="alert-extra"></div>
        </div>
        <div class="alert-box error">
            <div class="alert-icon">
                <i class="fa fa-5x fa-times-circle"></i>
            </div>
            <div class="alert-main">
                <p class="alert-title">PCO Expires in 15 days</p>

                <p class="alert-body">Please call DVLA to renew the licence. You will need your car details.</p>
            </div>
            <div class="alert-extra"></div>
        </div>

    </div>


</div>