angular.module('cars2let').factory('investorDataFactory',['$http',function($http)
{
    var URL_BASE = '/api/investor';
    var investorDataFactory = {};

    investorDataFactory.getInvestors = function()
    {
        return $http.get(URL_BASE);
    };
    investorDataFactory.getInvestor = function(id)
    {
        return $http.get(URL_BASE+'/'+id);
    };
    investorDataFactory.getAssets = function(id)
    {
        return $http.get(URL_BASE+'/'+id+'/assets');
    };
    investorDataFactory.getRevenueSummary = function(id)
    {
        return $http.get(URL_BASE+'/'+id+'/revenue');
    };
    investorDataFactory.getRevenueDetailed = function(id)
    {
        $http.get(URL_BASE+'/'+id+'/revenue/detail')
    };

    return investorDataFactory;
}]);

angular.module('cars2let').factory('investorDataModelFactory',['$http',function($http)
{

}]);