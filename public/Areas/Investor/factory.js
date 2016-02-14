app.factory('investorDataFactory',['$http',function($http)
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
        return $http.get(URL_BASE+'/'+id+'/revenue/detail');
    };

    return investorDataFactory;
}]);

app.factory('investorDataModelFactory',function()
{
    var investorDataModelFactory = {};

    investorDataModelFactory.groupDetailsByCar = function(jsonData)
    {
        return jsonData;
    };

    investorDataModelFactory.groupDetailsByDriver = function(jsonData)
    {
      return jsonData;
    };

    return investorDataModelFactory;
});