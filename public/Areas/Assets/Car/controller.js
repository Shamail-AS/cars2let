app.controller('carController',
    [
        '$scope',
        'carDataFactory',
        function ($scope, carDataFactory) {

            //Objects
            $scope.vm = {
                'cars': [],
                'sum': {
                    'totalContracts': 0,
                    'totalRevenue': 0,
                    'totalRent': 0
                }
            };
            $scope.filters = {
                'car': ''
            };

            //Public methods
            $scope.getCars = function () {
                get_cars();
            };

            $scope.formatDate = function (date) {
                var dt = new Date(date);
                return dt.toLocaleDateString();
            };

            //Private methods
            var get_cars = function () {
                carDataFactory.getCars()
                    .success(function (data) {
                        $scope.vm.cars = data;
                        get_sums();
                    });
            };
            var get_sums = function () {
                $scope.vm.sum.totalContracts = _.sumBy($scope.vm.cars, function (e) {
                    return e.totalContracts
                });
                $scope.vm.sum.totalRent = _.sumBy($scope.vm.cars, function (e) {
                    return e.totalRent
                });
                $scope.vm.sum.totalRevenue = _.sumBy($scope.vm.cars, function (e) {
                    return e.totalRevenue
                });
            };


            var init = function () {
                get_cars();
            };

            init();
        }]);