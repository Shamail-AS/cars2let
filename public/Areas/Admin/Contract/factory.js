app.factory('contractDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/contract';
    var contractDataFactory = {};

    contractDataFactory.getContracts = function () {
        return $http.get(URL_BASE + '/all');
    };
    contractDataFactory.getContract = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    contractDataFactory.getContractRevenueSummary = function (id) {
        return $http.get(URL_BASE + '/' + id + '/revenue/summary');
    };
    contractDataFactory.getContractRevenueDetail = function (id) {
        return $http.get(URL_BASE + '/' + id + '/revenue/detail');
    };
    contractDataFactory.filterContractsByCarDriver = function (search) {
        return $http.get(URL_BASE + '/filter/' + search);
    };
    contractDataFactory.filterContractsByCarAndDriver = function (search) {
        return $http.get(URL_BASE + '/andfilter/' + search);
    };
    contractDataFactory.filterContractsByCarOrDriver = function (search) {
        return $http.get(URL_BASE + '/orfilter/' + search);
    };

    return contractDataFactory;
}]);

app.factory('contractDataModelFactory', function () {

    var contractDataModelFactory = {};

    contractDataModelFactory.objectCollectionToArray = function (data) {

        var array = $.map(data, function (value, index) {
            return [value];
        });

        return array;
    };
    return contractDataModelFactory;
});