app.controller('driverController',
    [
        '$scope',
        'driverDataFactory',
        function ($scope, driverDataFactory) {

            //Objects
            $scope.vm = {
                'drivers': [],
                'sum': {
                    'totalContracts': 0,
                    'totalRevenue': 0,
                    'totalRent': 0
                }
            };
            $scope.filters = {
                'search': ''
            };

            //Public methods
            $scope.getDrivers = function () {
                get_drivers();
            };

            $scope.formatDate = function (date) {
                var dt = new Date(date);
                return dt.toLocaleDateString();
            };

            //Private methods
            var get_drivers = function () {
                driverDataFactory.getDrivers()
                    .success(function (data) {
                        $scope.vm.drivers = data;
                        get_sums();
                    });
            };
            var get_sums = function () {
                $scope.vm.sum.totalContracts = _.sumBy($scope.vm.drivers, function (e) {
                    return e.totalContracts
                });
                $scope.vm.sum.totalPaid = _.sumBy($scope.vm.drivers, function (e) {
                    return e.totalPaid
                });
                $scope.vm.sum.totalRevenue = _.sumBy($scope.vm.drivers, function (e) {
                    return e.totalRevenue
                });
            };


            var init = function () {
                get_drivers();
            };

            init();
        }]);