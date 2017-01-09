<div>
    <div id="wrapper" ng-controller="accidentController">
        <h1>Accidents</h1>
        <hr>
        <div id="contracts">
            @include('partials.admin.car.new-accident')
            <button class="btn btn-primary btn-block" ng-click="newAccident()"> Record new Accident</button>
            <input type="hidden" id="csrf_token" ng-model="dirty.token" value="{{ csrf_token() }}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Car</th>
                    <th>Driver</th>
                    <th>Happened On</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Comments</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="accident in vm.accidents">
                    <td>@{{ accident.car.reg_no }}</td>
                    <td>@{{ accident.driver.name }}</td>
                    <td>@{{ formatDate(accident.incident_at) }}</td>
                    <td>@{{ accident.location }}</td>
                    <td>@{{ accident.status }}</td>
                    <td>@{{ accident.comments }}</td>
                    <td>
                        <div>
                            <a ng-href="@{{ accident.detailUrl }}" class="btn btn-xs btn-info">Details</a>
                            <button class="btn btn-xs btn-warning" ng-click="editAccident(accident)">Edit</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>