app.factory('investorDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/investors';
    var investorDataFactory = {};

    investorDataFactory.getInvestors = function () {
        return $http.get(URL_BASE + '/all');
    };
    investorDataFactory.getInvestor = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    investorDataFactory.getCars = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'cars');
    };
    investorDataFactory.getDrivers = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'drivers');
    };
    investorDataFactory.getContracts = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'contracts');
    };
    investorDataFactory.getRevenues = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'revenues');
    };

    investorDataFactory.updateInvestor = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };

    return investorDataFactory;
}]);
app.factory('investorDataModelFactory', ['moment', 'contractDataModelFactory', 'carDataModelFactory', 'driverDataModelFactory', function (moment, contractDataModelFactory, carDataModelFactory, driverDataModelFactory) {

    var investorDataModelFactory = {};

    investorDataModelFactory.withExtras = function (investor) {
        investor.dt_dob = moment(investor.dob).toDate();
        investor.dt_acc_period_start = moment(investor.acc_period_start).toDate();
        investor.dt_acc_period_end = moment(investor.acc_period_end).toDate();
        return investor;
    };
    investorDataModelFactory.withDriverExtras = function (drivers) {
        _.each(drivers, function (driver) {
            driverDataModelFactory.withExtras(driver);
        });
        return drivers;
    };
    investorDataModelFactory.withContractExtras = function (contracts) {
        _.each(contracts, function (contract) {
            contractDataModelFactory.withExtras(contract);
        });
        return contracts;
    };
    investorDataModelFactory.withCarExtras = function (cars) {
        _.each(cars, function (car) {
            carDataModelFactory.withExtras(car);
        });
        return cars;
    };

    return investorDataModelFactory;
}]);

app.factory('carDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/cars';
    var carDataFactory = {};

    carDataFactory.getCars = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    carDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    carDataFactory.updateCar = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    carDataFactory.newCar = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    carDataFactory.deleteCar = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    return carDataFactory;
}]);
app.factory('carDataModelFactory', ['moment', function (moment) {
    var carDataModelFactory = {};
    carDataModelFactory.withExtras = function (car) {
        car.dt_available_since = moment(car.available_since).toDate();
        return car;
    };
    return carDataModelFactory;
}]);
app.factory('contractDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/contracts';
    var contractDataFactory = {};

    contractDataFactory.getContracts = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    contractDataFactory.getContract = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    contractDataFactory.getContractDetails = function (id) {
        return $http.get(URL_BASE + '/' + id + '/detail');
    };
    /* DEPRECATED - No updates allowed. Contracts are immutable*/
    contractDataFactory.updateContract = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    contractDataFactory.startContract = function (id) {
        return $http.get(URL_BASE + '/' + id + '/action/start');
    };
    contractDataFactory.endContract = function (id) {
        return $http.get(URL_BASE + '/' + id + '/action/end');
    };

    contractDataFactory.newContract = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    contractDataFactory.deleteContract = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };
    contractDataFactory.getContractRevenueDetail = function (id) {
        return $http.get(URL_BASE + '/' + id + '/revenue/detail');
    };
    contractDataFactory.getRevenues = function (id) {
        return $http.get(URL_BASE + '/' + id + '/revenues');
    };

    return contractDataFactory;
}]);
app.factory('contractDataModelFactory', ['moment', function (moment) {

    var contractDataModelFactory = {};
    contractDataModelFactory.withExtras = function (contract) {
        contract.dt_start_date = moment(contract.start_date).toDate();
        contract.dt_end_date = moment(contract.end_date).toDate();

        if (contract.status == 1) {
            contract.x_status = {"key": "Ongoing", "value": 1}
        }
        else if (contract.status == 2) {
            contract.x_status = {"key": "Suspended", "value": 2}
        }
        else if (contract.status == 3) {
            contract.x_status = {"key": "Terminated", "value": 3}
        }
        else if (contract.status == 4) {
            contract.x_status = {"key": "Complete", "value": 4}
        }
        contract.hasStarted = contract.act_start_dt != null;
        contract.hasTerminatedEarly = false;
        if (contract.act_end_dt != null) {
            var act_end = moment(contract.act_end_dt);
            contract.hasTerminatedEarly = act_end.isBefore(contract.end_date);
        }

        return contract;
    };
    return contractDataModelFactory;

}]);

app.factory('driverDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/drivers';
    var driverDataFactory = {};

    driverDataFactory.getDrivers = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    driverDataFactory.getDriver = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    driverDataFactory.updateDriver = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    driverDataFactory.newDriver = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    driverDataFactory.deleteDriver = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    return driverDataFactory;
}]);
app.factory('driverDataModelFactory', ['moment', function (moment) {
    var driverDataModelFactory = {};
    driverDataModelFactory.withExtras = function (driver) {
        driver.dt_dob = moment(driver.dob).toDate();
    };
    return driverDataModelFactory;
}]);
app.factory('revenueDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/revenues';
    var revenueDataFactory = {};

    revenueDataFactory.getRevenues = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    revenueDataFactory.getRevenue = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    revenueDataFactory.updateRevenue = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    revenueDataFactory.newRevenue = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    revenueDataFactory.deleteRvenue = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    revenueDataFactory.updateAllocations = function (allocations) {
        return $http.put(URL_BASE + '/update/allocations', allocations);
    };

    return revenueDataFactory;
}]);