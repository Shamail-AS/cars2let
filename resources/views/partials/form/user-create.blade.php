<div class="card">
    <div class="card-body">
        <form class="form" method="POST"
              action="{{url('/super/user/store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="hidden" name="email" value="@{{ dirty.user.email }}">
                <input class="form-control" type="text" name="email" ng-model="dirty.user.email">

            </div>
            <input class="form-control" type="hidden" name="status" value="new">

            <div class="form-group">
                <label>Type</label>
                <input class="form-control" type="hidden" name="type" value="@{{ dirty.user.type }}">
                <ui-select ng-model="dirty.user.type">
                    <ui-select-match allow-clear="true">
                        <span ng-bind="dirty.user.type"></span>
                    </ui-select-match>
                    <ui-select-choices
                            repeat="type in (vm.types | filter: $select.search)">
                        <span ng-bind="type"></span>
                    </ui-select-choices>
                </ui-select>
            </div>

            <div class="form-group">
                <label>Access Level</label>
                <input class="form-control" type="hidden" name="access_level" value="@{{ dirty.user.access_level }}">
                <ui-select ng-model="dirty.user.access_level">
                    <ui-select-match allow-clear="true">
                        <span ng-bind="dirty.user.access_level"></span>
                    </ui-select-match>
                    <ui-select-choices
                            repeat="access_level in (vm.access_levels | filter: $select.search)">
                        <span ng-bind="access_level"></span>
                    </ui-select-choices>
                </ui-select>
            </div>
            <div class="form-group">
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>Register
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>