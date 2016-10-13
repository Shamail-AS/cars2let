app.controller('driverController',
    [
        '$scope',
        'driverDataFactory',
        function ($scope, driverDataFactory) {

            //Objects
            $scope.vm = {
                'drivers': []
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
                    });
            };


            var init = function () {
                get_drivers();
            };

            init();
        }]);