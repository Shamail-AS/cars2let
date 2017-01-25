<div ng-if="vm.create.car" class="card">
    <div class="card-body">
        <div class="lola">
            <div class="admin-flex-container main-body">
                <div class="form-group">
                    <label>Reg#</label>
                    <input ng-model="dirty.car.reg_no" class="form-control" placeholder="ABC-123">
                </div>
                <div class="form-group">
                    <label>Make</label>
                    <input ng-model="dirty.car.make" class="form-control" placeholder="Toyota">
                </div>
                <div class="form-group">
                    <label>Available Since</label>

                    <input type="text" class="form-control" uib-datepicker-popup
                           ng-model="dirty.car.dt_available_since"
                           is-open="dirty.car.picker_open" datepicker-options="dateOptions"
                           ng-required="true"
                           close-text="Close"
                           ng-click="openPicker(dirty.car)"/>
                </div>
                <div class="form-group">
                    <label>Comments</label>
                    <input ng-model="dirty.car.comments" class="form-control" placeholder="Comments...">
                </div>


            </div>
            <div class="form-group footer">
                <div class="form-group button">

                    {{--<button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>--}}
                    <button type="button" class="btn  btn-primary" ng-click="newCar()">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>