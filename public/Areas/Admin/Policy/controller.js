app.controller('policyController',
    [
        '$scope',
        'policyDataFactory',
        'policyDataModelFactory',
        function ($scope, policyDataFactory, policyDataModelFactory) {

            //Objects
            $scope.vm = {
                'policies': [],
                'loading': true
            };
            $scope.filters = {
                'search': ''
            };
            $scope.dateOptions = {
                dateDisabled: false,
                formatYear: 'yyyy',
                startingDay: 1
            };
            $scope.openPicker = function (policy) {
                policy.picker_open = true;
            };

            //Public methods
            $scope.getPolicies = function () {
                get_policies();
            };

            $scope.formatDate = function (date) {
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };
            $scope.editPolicy = function (policy) {
                console.log(policy);
                policy.edit_mode = true
            };
            $scope.cancelEdit = function (policy) {
                policy.edit_mode = false;
            };
            $scope.updatePolicy = function (policy) {
                update_policy(policy);
            };

            //Private methods
            var get_policies = function () {
                $scope.vm.loading = true;
                policyDataFactory.getPolicies()
                    .success(function (data) {
                        $scope.vm.policies = policyDataModelFactory.withExtras(data);
                        console.log($scope.vm.policies);
                        $scope.vm.loading = false;
                    });
            };

            var update_policy = function (policy) {
                policy.start_date = moment(policy.start_date).format("YYYY-MM-DD");
                policy.end_date = moment(policy.end_date).format("YYYY-MM-DD");
                console.log(policy);
                policyDataFactory.updatePolicy(policy.id, policy)
                    .success(function (result) {
                        console.log(result);
                        policy.start_date = moment(policy.start_date).format("YYYY-MM-DD");
                        policy.supplier.name = result.name;
                        policy.end_date = moment(policy.end_date).format("YYYY-MM-DD");
                        policy.edit_mode = false;
                    });
            };


            var init = function () {
                get_policies();
            };

            init();
        }]);
