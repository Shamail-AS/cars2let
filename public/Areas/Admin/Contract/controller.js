app.controller('contractController',
    [
        '$scope',
        'contractDataFactory',
        'contractDataModelFactory',
        'moment',
        function ($scope, contractDataFactory, contractDataModelFactory, moment) {

            //Objects
            $scope.vm = {
                'contract_collection': [],
                'contract': {},
                'prev_contract': {},
                'contract_revenue_summary': [],
                'contract_revenue_detail': [],
                'contract_revenue_detail_week': 0,
                'contract_revenue_week_detail': [],
                'status_collection': []
            };
            $scope.filters = {
                'car': '',
                'driver': '',
                'selected_status': {},
                '_date_from': moment().subtract(3, 'months'),
                'date_from': moment().subtract(3, 'months').format("DD-MM-YYYY"),
                '_date_to': moment().add(3, 'months'),
                'date_to': moment().add(3, 'months').format("DD-MM-YYYY")

            };

            //Public methods
            $scope.getContracts = function () {
                get_contracts();
            };
            $scope.getContract = function (id) {

                //$scope.vm.prev_contract = $scope.vm.contract;
                get_contract(id, false);
                get_contract_revenue_summary(id);
                get_contract_revenue_detail(id);


            };

            $scope.getContractRevenueSummary = function (id) {
                get_contract_revenue_summary(id);
            };

            $scope.filterContracts = function () {
                filter_contracts($scope.filters.search);
            };

            $scope.formatDate = function (date) {
                var dt = new Date(date);
                return dt.toLocaleDateString();
            };
            $scope.setDetailWeek = function (weekNo) {

                $scope.vm.contract_revenue_detail_week = weekNo;

                show_week_detail();
            };
            //Private methods
            var get_contracts = function () {
                contractDataFactory.getContracts()
                    .success(function (data) {
                        $scope.vm.contract_collection = data;
                        if ($scope.vm.contract.id) {
                            select_contract($scope.vm.contract.id);
                        }
                    })
            };

            var get_contract = function (id, filter) {
                contractDataFactory.getContract(id)
                    .success(function (data) {
                        $scope.vm.contract = data;
                        select_contract($scope.vm.contract.id);
                        if (filter) {
                            //$scope.filters.driver = $scope.vm.contract.driver.name;
                            $scope.filters.car = $scope.vm.contract.car.reg_no;
                        }
                    });
            };
            var select_contract = function (id_new) {
                _.each($scope.vm.contract_collection, function (contract) {
                    contract.selected = contract.id == id_new;
                });

                //if (id_old >= 0)$scope.vm.contract_collection[id_old].selected = false;
                //if (id_new >= 0)$scope.vm.contract_collection[id_new].selected = true;

            };
            var get_contract_revenue_summary = function (id) {
                contractDataFactory.getContractRevenueSummary(id)
                    .success(function (data) {
                        $scope.vm.contract_revenue_summary = contractDataModelFactory.objectCollectionToArray(data);
                    });
            };

            var get_contract_revenue_detail = function (id) {
                contractDataFactory.getContractRevenueDetail(id)
                    .success(function (data) {
                        $scope.vm.contract_revenue_detail = (data);
                        show_week_detail();
                    });
            };

            var show_week_detail = function () {
                $scope.vm.contract_revenue_week_detail
                    = $scope.vm.contract_revenue_detail[$scope.vm.contract_revenue_detail_week];
            };
            var get_contracts_by_car_driver = function (search) {
                contractDataFactory.filterContractsByCarDriver(search)
                    .success(function (data) {
                        $scope.vm.contract_collection = data;
                    });
            };
            var get_contracts_by_car_and_driver = function (search) {
                contractDataFactory.filterContractsByCarAndDriver(search)
                    .success(function (data) {
                        $scope.vm.contract_collection = data;
                    })
            };

            var get_contracts_by_car_or_driver = function (search) {
                contractDataFactory.filterContractsByCarOrDriver(search)
                    .success(function (data) {
                        $scope.vm.contract_collection = data;
                    });
            };

            var filter_contracts = function (searchTerm) {
                if (searchTerm.includes('and')) {
                    get_contracts_by_car_and_driver(searchTerm);
                }
                else if (searchTerm.includes('or')) {
                    get_contracts_by_car_or_driver(searchTerm);
                }
                else {
                    get_contracts_by_car_driver(searchTerm);
                }
            };
            var get_contract_statuses = function () {

                $scope.vm.status_collection.push({"key": "Ongoing", "value": 1});
                $scope.vm.status_collection.push({"key": "Suspended", "value": 2});
                $scope.vm.status_collection.push({"key": "Terminated", "value": 3});
                $scope.vm.status_collection.push({"key": "Complete", "value": 4});
            };
            var check_url_contract_id = function () {
                var url = (window.location.pathname);
                var id = _.takeRight(_.split(url, '/'));
                if (id > -1) {
                    get_contract(id, true);
                    get_contract_revenue_summary(id);
                    get_contract_revenue_detail(id);
                }

            };
            var init = function () {
                get_contracts();
                get_contract_statuses();
                check_url_contract_id();
            };

            init();
        }]);