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

    $scope.formatDate = function (date) {
        var dt = moment(date);
        return dt.format("DD, MMM YYYY");
    };

    $scope.updateCar = function (car) {
        save_car(car);
    };
    $scope.saveSelective = function (car, prop) {
        if (prop == 'comments')
            update_comments(car);
    };


    var load_extras = function () {
        detailsDataFactory.getSuppliers().success(function (data) {
            $scope.vm.suppliers = data;
        });
        detailsDataFactory.getInvestors().success(function (data) {
            $scope.vm.investors = data;
        });

        $scope.vm.transmissions = _.concat($scope.vm.transmissions, ['automatic', 'semi-automatic', 'manual']);
        $scope.vm.fuels = _.concat($scope.vm.fuels, ['petrol', 'diesel', 'lpg', 'bio']);
        $scope.vm.statuses = _.concat($scope.vm.statuses, ['on-road', 'off-road']);

    };
    var load_car = function (id) {
        detailsDataFactory.getCar(id)
            .success(function (data) {
                $scope.vm.car = detailsDataModelFactory.withExtras(data);
                $scope.vm.loading = false;
            });
    };

    var save_car = function (car) {
        var data = detailsDataModelFactory.removeExtras(car);
        $scope.vm.loading = true;
        detailsDataFactory.updateCar(car.id, data)
            .success(function (data) {
                $scope.vm.loading = false;
            });
    };
    var update_comments = function (car) {
        var data = {
            id: car.id,
            prop: 'comments',
            value: car.comments
        };
        detailsDataFactory.updateSelective(car.id, data)
            .success(function (response) {
                console.log(response);
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
        var id = _.split(url, '/')[3]; // that's where the car id is stored
        return id;
    };

    init();
}]);

app.controller('overviewController', ['$scope', 'overviewDataFactory', 'overviewDataModelFactory', 'detailsDataModelFactory', function ($scope, overviewDataFactory, overviewDataModelFactory, detailsDataModelFactory) {

    $scope.vm = {
        loading: true,
        car: {},
        notifications: [],
        histories: []
    };

    var get_overview = function (id) {
        overviewDataFactory.getOverview(id)
            .success(function (response) {
                //$scope.vm.notifications = overviewDataModelFactory.getNotifications(response.alerts);
                $scope.vm.histories = overviewDataModelFactory.getHistories(response.histories);
            });
    };


    var get_car = function (id) {
        $scope.vm.loading = true;
        overviewDataFactory.getCar(id)
            .success(function (data) {
                $scope.vm.car = detailsDataModelFactory.withExtras(data);
                $scope.vm.notifications = overviewDataModelFactory.getNotifications(data.notis);
                $scope.vm.loading = false;
            });
    };

    var init = function () {
        var id = get_id_from_url();
        if (id) {
            get_car(id);
            //get_overview(id);
        }
    };
    var get_id_from_url = function () {
        var url = (window.location.pathname);
        var id = _.split(url, '/')[3]; // that's where the car id is stored
        return id;
    };

    init();
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