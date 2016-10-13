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
    investorDataFactory.getDrivers = function () {
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
app.factory('carDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/cars';
    var carDataFactory = {};

    carDataFactory.getCars = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    carDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    carDataFactory.putCar = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };

    return carDataFactory;
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
    contractDataFactory.putContract = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };

    return contractDataFactory;
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
    driverDataFactory.putDriver = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };

    return driverDataFactory;
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
    revenueDataFactory.putRevenue = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    revenueDataFactory.newRevenue = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };

    return revenueDataFactory;
}]);