app.controller('contractController',
    [
        '$scope',
        'contractDataFactory',
        'contractDataModelFactory',
        'ModalService',
        'moment',
        function ($scope, contractDataFactory, contractDataModelFactory,ModalService, moment) {

            //Objects
            $scope.vm = {
                'contract_collection': [],
                'contract': {}, //selected contract
                'status_collection': [],
                'loading': {
                    'contracts': true,
                    'revenues': false
                }
            };
            $scope.popover = {
                revenueListUrl: 'revenue_list.html',
                title: 'Payments made',
                trigger: 'focus'
            };
            $scope.filters = {
                'car': '',
                'driver': '',
                'selected_status': {},
                'date_from': moment().subtract(5, 'year').format("YYYY-MM-DD"),
                'date_to': moment().add(5, 'year').format("YYYY-MM-DD"),
                'contract': {}

            };

            $scope.openFilters = function () {
                ModalService.showModal({
                    scope: $scope,
                    templateUrl: "contract-filters.html",
                    controller: "contractFilterModalController"
                }).then(function (modal) {
                    modal.element.modal();
                    modal.close.then(function (result) {
                        console.log(result);
                    });
                });
            };

            //Public methods
            $scope.getContracts = function () {
                get_contracts();
            };
            $scope.getContract = function (id) {
                get_contract(id,false);
            };

            $scope.getContractRevenueSummary = function (id) {
                get_contract_revenue_summary(id);
            };

            $scope.formatDate = function (date) {
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };

            //Private methods
            var get_contracts = function () {
                $scope.vm.loading.contracts = true;
                contractDataFactory.getContracts()
                    .success(function (data) {
                        $scope.vm.contract_collection = contractDataModelFactory.withExtras(data);
                        if($scope.vm.contract.id){
                            select_contract($scope.vm.contract.id);
                        }
                        $scope.vm.loading.contracts = false;
                    })
            };

            var get_contract = function (id, filter) {
                contractDataFactory.getContract(id)
                    .success(function (data) {
                        $scope.vm.contract = data;
                        select_contract($scope.vm.contract.id);
                        get_contract_revenue_summary(id);
                    });
            };
            var select_contract = function (id_new) {
                _.each($scope.vm.contract_collection,function(contract){
                    contract.selected = contract.id == id_new;
                });
            };
            var get_contract_revenue_summary = function (id) {
                $scope.vm.loading.revenues = true;
                contractDataFactory.getContractRevenueSummary(id)
                    .success(function (data) {
                        console.log(data);
                        $scope.vm.contract.revenue = contractDataModelFactory.objectCollectionToArray(data);
                        $scope.vm.loading.revenues = false;

                    });
            };

            var get_contract_statuses = function(){

              $scope.vm.status_collection.push({"key":"Ongoing","value":1});
              $scope.vm.status_collection.push({"key":"Suspended","value":2});
              $scope.vm.status_collection.push({"key":"Terminated","value":3});
              $scope.vm.status_collection.push({"key":"Complete","value":4});
            };

            var check_url_contract_id = function(){
                var url = (window.location.pathname);
                var id = _.takeRight(_.split(url,'/'));
                if(id > -1){
                    get_contract(id,true);
                    get_contract_revenue_summary(id);

                }

            };
            var init = function () {
                get_contracts();
                get_contract_statuses();
                check_url_contract_id();
            };

            init();
        }]);