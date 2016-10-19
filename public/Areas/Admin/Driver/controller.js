app.controller('driverController',
    [
        '$scope',
        'driverDataFactory',
        'driverDataModelFactory',
        function ($scope, driverDataFactory, driverDataModelFactory) {

            //Objects
            $scope.vm = {
                'drivers': []
            };
            $scope.filters = {
                'search': ''
            };
            $scope.dateOptions = {
                dateDisabled: false,
                formatYear: 'yyyy',
                startingDay: 1
            };
            $scope.openPicker = function (id) {
                open_picker_for_driver(id);
            };

            //Public methods
            $scope.getDrivers = function () {
                get_drivers();
            };

            $scope.formatDate = function (date) {
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };
            $scope.editDriver = function (id) {
                edit_driver(id);
            };
            $scope.cancelEdit = function (id) {
                cancel_edit_driver(id);
            };
            $scope.updateDriver = function (driver) {
                update_driver(driver);
            };

            //Private methods
            var get_drivers = function () {
                driverDataFactory.getDrivers()
                    .success(function (data) {
                        $scope.vm.drivers = driverDataModelFactory.withExtras(data);
                    });
            };
            var open_picker_for_driver = function (id) {
                var driver = _.find($scope.vm.drivers, function (e) {
                    return e.id == id;
                });
                driver.picker_open = true;
            };
            var edit_driver = function (id) {
                var driver = _.find($scope.vm.drivers, function (e) {
                    return e.id == id;
                });
                driver.edit_mode = true;
                //driver.dt_available_since = new Date();
                console.log(driver.dt_dob);
            };

            var cancel_edit_driver = function (id) {
                var driver = _.find($scope.vm.drivers, function (e) {
                    return e.id == id;
                });
                driver.edit_mode = false;
            };

            var update_driver = function (driver) {
                driver.dob = moment(driver.dt_dob).format("DD-MM-YYYY");
                driverDataFactory.putDriver(driver.id, driver)
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