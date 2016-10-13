app.factory('carDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/car';
    var carDataFactory = {};

    carDataFactory.getCars = function () {
        return $http.get(URL_BASE + '/all');
    };


    return carDataFactory;
}]);
