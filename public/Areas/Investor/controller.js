
app.controller('investorController', function($scope,investorDataFactory ,investorDataModelFactory)
{
    //Objects
    $scope.dirty = {
        'testing':5
    };
    $scope.vm ={
        'investor':{},
        'revenue_summary':{},
        'assets':{},
        'revenue_detail':{},
        'revenue_detail_group_car':{},
        'revenue_detail_group_driver':{}
    };

    //Public methods
    $scope.getRevenueSummary = function(id)
    {
        $scope.vm.revenue_summary = get_revenue_summary(id);
    };
    $scope.getRevenueDetail = function(id)
    {
        $scope.vm.revenue_detail = get_revenue_detail(id);
    };
    $scope.getAssets = function(id)
    {
        $scope.vm.assets = get_assets(id);
    };
    $scope.getInvestor = function(id)
    {
        $scope.vm.investor = get_investor(id);
    };
    $scope.groupDataBy = function(type)
    {
        if(type == 'car')
            group_details_by_car();
        if(type == 'driver')
            group_details_by_driver();
    };


    //Private methods
    var get_revenue_summary = function(id)
    {
        investorDataFactory.getRevenueSummary(id)
            .success(function(data,status,headers,config)
            {
                $scope.vm.revenue_summary = data;
            });
    };
    var get_revenue_detail = function(id)
    {
        investorDataFactory.getRevenueDetailed(id)
            .success(function(data,status,headers,config)
            {
                $scope.vm.revenue_detail = data;
            });
    };
    var get_assets = function(id)
    {
        investorDataFactory.getAssets(id)
            .success(function(data,status,headers,config)
            {
                $scope.vm.assets = data;
            });
    };
    var get_investor = function(id)
    {
        investorDataFactory.getInvestor(id)
            .success(function(data,status,headers,config)
            {
                $scope.vm.investor = data;
            });
    };
    var group_details_by_car = function()
    {
        $scope.vm.revenue_detail_group_car = investorDataModelFactory.groupDetailsByCar($scope.vm.revenue_detail);
    };
    var group_details_by_driver = function()
    {
        $scope.vm.revenue_detail_group_driver = investorDataModelFactory.groupDetailsByDriver($scope.vm.revenue_detail);
    };

    var init = function()
    {

    };

    init();
});