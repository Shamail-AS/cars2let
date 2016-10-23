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
    carDataModelFactory.withEditMode = function (cars) {
        _.each(cars, function (car) {
            car.edit_mode = false;
            car.isLinked = car.investor != undefined;
            car.picker_open = false;
            car.dt_available_since = moment(car.available_since).toDate();
        });
        return cars;
    };
    return carDataModelFactory;
}]);