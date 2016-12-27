app.controller('detailsController', ['$scope', 'detailsDataFactory', 'detailsDataModelFactory', function ($scope, detailsDataFactory, detailsDataModelFactory) {

    //Objects
    $scope.vm = {
        'car': {},
        'loading': true,
        'transmissions': [],
        'fuels': [],
        'statuses': [],
        'suppliers': [],
        'investors': []
    };

    var load_extras = function () {
        detailsDataFactory.getSuppliers().success(function (data) {
            $scope.vm.suppliers = data;
        });
        detailsDataFactory.getInvestors().success(function (data) {
            $scope.vm.investors = data;
        });
        _.concat($scope.vm.fuels, ['petrol', 'diesel', 'lpg', 'bio']);

    };
    var load_car = function (id) {
        detailsDataFactory.getCar(id)
            .success(function (data) {
                $scope.vm.car = detailsDataModelFactory.withExtras(data);
                $scope.vm.loading = false;
            });
    };
    var init = function () {
        $scope.vm.car.loading = false;
        var id = get_id_from_url();
        if (id) {
            load_car(id);
            load_extras();
        }
    };
    var get_id_from_url = function () {
        var url = (window.location.pathname);
        console.log(url);
        var id = _.split(url, '/')[3]; // that's where the car id is stored
        console.log(id);
        return id;
    };

    init();
}]);

app.controller('overviewController', ['$scope', function ($scope) {

    $scope.vm = {
        car: {},
        alerts: [],
        histories: []
    };


    var get_car_alerts = function (id) {

    };

    var get_car = function (id) {

    };

    var init = function () {

    };

}]);

app.controller('contractsController', ['$scope', function ($scope) {

}]);

app.controller('ticketsController', ['$scope', function ($scope) {

}]);

app.controller('alertsController', ['$scope', function ($scope) {

}]);

app.controller('servicesController', ['$scope', function ($scope) {

}]);

app.controller('deliveriesController', ['$scope', function ($scope) {

}]);

app.controller('revenueController', ['$scope', function ($scope) {

}]);