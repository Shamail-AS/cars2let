angular.module('cars2let')
    .controller('investorController',
    ['$scope','investorDataFactory',
        function($scope,investorDataFactory)
        {
            //Objects
            $scope.dirty = {};
            $scope.vm ={
                'investor':{},
                'revenue_summary':{},
                'assets':{},
                'revenue_detail':{}
            };

            //Public methods
            $scope.getRevenueSummary = function(id)
            {
                get_revenue_summary(id);
            };
            $scope.getRevenueDetail = function(id)
            {
                get_revenue_detail(id);
            };
            $scope.getAssets = function(id)
            {
                get_assets(id);
            };
            $scope.getInvestor = function(id)
            {

            };



            //Private methods

            var get_revenue_summary = function(id)
            {

            };
            var get_revenue_detail = function(id)
            {

            };
            var get_assets = function(id)
            {

            };
            var get_investor = function(id)
            {

            };

        }
    ]
);