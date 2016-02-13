var app = angular.module('cars2let', ['ngRoute']);

app.config(['$routeProvider',function($routeProvider)
{
    $routeProvider.
        when('/home',{
            templateUrl: '/angular/Areas/Investor/views/home.html',
            controller: 'investorController'
        }).
        otherwise({
            redirectTo: '/angular/Areas/Investor/views/blank.html'
        });
}]);