app.controller('driverController',
    [
        '$scope',
        'driverDataFactory',
        'driverDataModelFactory',
        function ($scope, driverDataFactory, driverDataModelFactory) {

            //Objects
            $scope.vm = {
                'drivers': [],
                'loading': true
            };
            $scope.filters = {
                'search': ''
            };
            $scope.dateOptions = {
                dateDisabled: false,
                formatYear: 'yyyy',
                startingDay: 1
            };
            $scope.openPicker = function (driver) {
                driver.picker_open = true;
            };

            //Public methods
            $scope.getDrivers = function () {
                get_drivers();
            };

            $scope.formatDate = function (date) {
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };
            $scope.editDriver = function (driver) {
                driver.edit_mode = true
            };
            $scope.cancelEdit = function (driver) {
                driver.edit_mode = false;
            };
            $scope.updateDriver = function (driver) {
                update_driver(driver);
            };

            //Private methods
            var get_drivers = function () {
                $scope.vm.loading = true;
                driverDataFactory.getDrivers()
                    .success(function (data) {
                        $scope.vm.drivers = driverDataModelFactory.withExtras(data);
                        $scope.vm.loading = false;
                    });
            };

            var update_driver = function (driver) {
                driver.dob = moment(driver.dt_dob).format("DD-MM-YYYY");
                driverDataFactory.updateDriver(driver.id, driver)
                    .success(function (result) {
                        alert(result);
                        driver.dob = moment(driver.dt_dob);
                        driver.edit_mode = false;
                    });
            };


            var init = function () {
                get_drivers();
            };

            init();
        }]);