app.controller('carController',
    [
        '$scope',
        'carDataFactory',
        function ($scope, carDataFactory) {

            //Objects
            $scope.vm = {
                'cars': []
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
                    });
            };


            var init = function () {
                get_cars();
            };

            init();
        }]);