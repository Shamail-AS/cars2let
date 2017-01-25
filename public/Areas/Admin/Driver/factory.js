app.factory('driverDataModelFactory', ['moment', function (moment) {

    var driverDataModelFactory = {};

    driverDataModelFactory.withExtras = function (drivers) {
        _.each(drivers, function (driver) {
            driver.edit_mode = false;
            driver.picker_open = false;
            driver.dt_dob = moment(driver.dob).toDate();
        });
        return drivers;
    };

    return driverDataModelFactory;
}]);
