app.factory('driverDataFactory',['$http',function($http)
{
    var URL_BASE = '/api/driver';
    var driverDataFactory = {};

    driverDataFactory.getDrivers = function()
    {
        return $http.get(URL_BASE+'/all');
    };


    return driverDataFactory;
}]);
