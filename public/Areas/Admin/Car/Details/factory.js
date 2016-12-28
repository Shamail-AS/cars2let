app.factory('detailsDataFactory', ['$http', function ($http) {

    var URL_BASE = '/api/admin/cars';
    var detailsDataFactory = {};

    detailsDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    detailsDataFactory.updateCar = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    detailsDataFactory.getInvestors = function () {
        return $http.get('/api/admin/investors/all');
    };
    detailsDataFactory.getSuppliers = function () {
        return $http.get('/api/admin/suppliers/all');
    };
    return detailsDataFactory;

}]);
app.factory('detailsDataModelFactory', ['moment', function (moment) {
    var detailsDataModelFactory = {};

    detailsDataModelFactory.withExtras = function (car) {
        car.x_available_since = moment(car.available_since).toDate();
        car.x_first_reg_date = moment(car.first_reg_date).toDate();
        car.x_pco_expires_at = moment(car.pco_expires_at).toDate();
        car.x_warranty_exp_at = moment(car.warranty_exp_at).toDate();
        car.x_roadside_exp_at = moment(car.road_side_exp_at).toDate();
        car.x_road_tax_exp_at = moment(car.road_tax_exp_at).toDate();
        return car;
    };
    detailsDataModelFactory.removeExtras = function (car) {
        car.available_since = moment(car.x_available_since).format('YYYY-MM-DD');
        car.first_reg_date = moment(car.x_first_reg_date).format('YYYY-MM-DD');
        car.pco_expires_at = moment(car.x_pco_expires_at).format('YYYY-MM-DD');
        car.warranty_exp_at = moment(car.x_warranty_exp_at).format('YYYY-MM-DD');
        car.road_side_exp_at = moment(car.x_roadside_exp_at).format('YYYY-MM-DD');
        car.road_tax_exp_at = moment(car.x_road_tax_exp_at).format('YYYY-MM-DD');

        delete(car.x_available_since);
        delete(car.x_first_reg_date);
        delete(car.x_pco_expires_at);
        delete(car.x_warranty_exp_at);
        delete(car.x_roadside_exp_at);
        delete(car.x_road_tax_exp_at);

        return car;
    };
    return detailsDataModelFactory;

}]);
app.factory('overviewDataFactory', ['$http', function ($http) {

    var URL_BASE = '/api/admin/cars';
    var overviewDataFactory = {};

    overviewDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    overviewDataFactory.getOverview = function (id) {
        return $http.get(URL_BASE + '/' + id + '/overview');
    };
    overviewDataFactory.updateSelective = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/update/selective', data);
    };

    return overviewDataFactory;

}]);

app.factory('overviewDataModelFactory', ['moment', function (moment) {
    var overviewDataModelFactory = {};

    overviewDataModelFactory.checkAlerts = function (alerts) {

    }
}]);