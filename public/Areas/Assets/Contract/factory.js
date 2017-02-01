app.factory('contractDataFactory',['$http',function($http)
{
    var URL_BASE = '/api/contract';
    var contractDataFactory = {};

    contractDataFactory.getContracts = function()
    {
        return $http.get(URL_BASE+'/all');
    };
    contractDataFactory.getContract = function(id)
    {
        return $http.get(URL_BASE+'/'+id);
    };
    contractDataFactory.getContractRevenueSummary = function(id)
    {
        return $http.get(URL_BASE+'/'+id+'/revenue/summary');
    };
    contractDataFactory.getContractRevenueDetail = function(id)
    {
        return $http.get(URL_BASE+'/'+id+'/revenue/detail');
    };
    contractDataFactory.filterContractsByCarDriver = function(search)
    {
      return $http.get(URL_BASE+'/filter/'+search);
    };
    contractDataFactory.filterContractsByCarAndDriver = function(search)
    {
        return $http.get(URL_BASE+'/andfilter/'+search);
    };
    contractDataFactory.filterContractsByCarOrDriver = function(search)
    {
        return $http.get(URL_BASE+'/orfilter/'+search);
    };

    return contractDataFactory;
}]);

app.factory('contractDataModelFactory', function () {

    var contractDataModelFactory = {};

    contractDataModelFactory.objectCollectionToArray = function(data){

        var array = $.map(data,function(value,index){
           return [value];
        });

        return array;
    };

    contractDataModelFactory.withExtras = function (contractCollection) {
        return _.each(contractCollection, function (contract) {
            if (contract.status == 1) {
                contract.x_status = {"key": "Ongoing", "value": 1}
            }
            else if (contract.status == 2) {
                contract.x_status = {"key": "Suspended", "value": 2}
            }
            else if (contract.status == 3) {
                contract.x_status = {"key": "Terminated", "value": 3}
            }
            else if (contract.status == 4) {
                contract.x_status = {"key": "Complete", "value": 4}
            }
        });
    };
    return contractDataModelFactory;
});