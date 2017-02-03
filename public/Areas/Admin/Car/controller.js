app.controller('carController',
    [
        '$scope',
        'carDataFactory',
        'carDataModelFactory',
        'investorDataFactory',
        function ($scope, carDataFactory, carDataModelFactory, investorDataFactory) {

            //Objects
            $scope.vm = {
                'cars': [],
                'investors': [],
                'add_mode': false,
                'loading': true
            };
            $scope.filters = {
                'car': ''
            };
            $scope.dateOptions = {
                dateDisabled: false,
                formatYear: 'yyyy',
                startingDay: 1
            };
            $scope.openPicker = function (car) {
                car.picker_open = true;
            };

            //Public methods
            $scope.getCars = function () {
                get_cars();
            };
            $scope.editCar = function (car) {
                car.edit_mode = true;
            };
            $scope.cancelEdit = function (car) {
                car.edit_mode = false;
            };
            $scope.updateCar = function (car) {
                update_car(car);
            };
            $scope.deleteCar = function (car) {
                delete_car(car);
            };

            $scope.formatDate = function (date) {
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };

            //Private methods
            var get_cars = function () {
                $scope.vm.loading = true;
                carDataFactory.getCars()
                    .success(function (data) {
                        $scope.vm.cars = carDataModelFactory.withExtras(data);
                        $scope.vm.loading = false;
                    });
            };

            var update_car = function (car) {
                car.available_since = moment(car.dt_available_since).format("DD-MM-YYYY");
                carDataFactory.updateCar(car.id, car)
                    .success(function (result) {
                        alert(result);
                        car.edit_mode = false;
                    });
            };
            var delete_car = function (car) {
                carDataFactory.deleteCar(car.id)
                    .success(function (result) {
                        location.reload();
                    });
            };
            var get_investors = function () {
                investorDataFactory.getInvestors()
                    .success(function (data) {
                        $scope.vm.investors = data;
                    });
            };

            var init = function () {
                get_cars();
                get_investors();
            };

            init();
        }]);