app.factory('userDataFactory', ['$http', function ($http) {
    var URL_BASE = '/super/api';
    var userDataFactory = {};

    userDataFactory.getUsers = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    userDataFactory.getUser = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    userDataFactory.resetPassword = function (id) {
        return $http.get(URL_BASE + '/' + id + '/reset');
    };
    userDataFactory.putUser = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/update', data);
    };
    userDataFactory.newUser = function (data) {
        return $http.put(URL_BASE + '/post', data);
    };

    return userDataFactory;
}]);

app.factory('userDataModelFactory', ['moment', function (moment) {

    var userDataModelFactory = {};
    userDataModelFactory.withEditMode = function (users) {
        _.each(users, function (user) {
            user.edit_mode = false;
            user.isLinked = user.investor != undefined;
            user.picker_open = false;
            user.dt_available_since = moment(user.available_since).toDate();
        });
        return users;
    };
    return userDataModelFactory;
}]);