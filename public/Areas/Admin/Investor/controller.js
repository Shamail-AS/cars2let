app.controller('investorController',
    [
        '$scope',
        'investorDataFactory',
        'revenueDataFactory',
        'moment',
        function ($scope, investorDataFactory, revenueDataFactory, moment) {

            //Objects
            $scope.vm = {
                'investor': {},
                'edit_mode': false,
                'create': {
                    'revenue': false,
                    'car': false,
                    'contract': false,
                    'driver': false
                },
                'statuses': [],
                'paying': -1
            };
            $scope.selected = {
                "car": {},
                "driver": {},
                "status": {}
            };
            $scope.search = {
                'revenues': '',
                'cars': '',
                'contracts': '',
                'drivers': ''
            };
            $scope.active = {
                'revenues': true,
                'cars': false,
                'contracts': false,
                'drivers': false
            };
            $scope.dirty = {
                'payment': 0,
                'revenue': {
                    'amount': null,
                    'contract': null
                },
                'car': {},
                'contract': {},
                'driver': {}

            };

            //Public methods

            $scope.editInvestor = function () {
                $scope.vm.edit_mode = true;
            };
            $scope.cancelEdit = function () {
                $scope.vm.edit_mode = false;

            };
            $scope.updateInvestor = function () {
                $scope.vm.edit_mode = false;
                var id = $scope.vm.investor.id;
                var data = $scope.vm.investor;
                update_investor(id, data);
            };

            $scope.deleteInvestor = function () {
                alert("OMG!!");
            };

            $scope.showRevenues = function () {
                $scope.active.revenues = true;
                $scope.active.contracts =
                    $scope.active.cars =
                        $scope.active.drivers = false;
                cancel_add();
                load_revenues();
            };
            $scope.showCars = function () {
                $scope.active.cars = true;
                $scope.active.revenues =
                    $scope.active.contracts =
                        $scope.active.drivers = false;
                cancel_add();
                load_cars();
            };
            $scope.showContracts = function () {
                $scope.active.contracts = true;
                $scope.active.revenues =
                    $scope.active.cars =
                        $scope.active.drivers = false;
                cancel_add();
                load_contracts();
            };
            $scope.showDrivers = function () {
                $scope.active.revenues =
                    $scope.active.cars =
                        $scope.active.contracts = false;
                $scope.active.drivers = true;
                cancel_add();
                load_drivers();
            };

            $scope.add = function (item) {
                $scope.vm.create.revenue = item == 'revenue';
                $scope.vm.create.car = item == 'car';
                $scope.vm.create.contract = item == 'contract';
                $scope.vm.create.driver = item == 'driver';
            };
            $scope.cancelAdd = function () {
                cancel_add();
            };
            $scope.showPay = function (contract_id) {
                $scope.vm.paying = contract_id;
            };
            $scope.cancelPay = function () {
                $scope.vm.paying = -1;
                $scope.dirty.payment = 0;
            };
            $scope.pay = function (contract_id) {
                var payment = parseFloat($scope.dirty.payment);
                pay_investor_contract(contract_id, payment);

            };

            $scope.newRevenue = function () {
                pay_investor_contract($scope.dirty.revenue.contract.id, parseFloat($scope.dirty.revenue.amount));

            };

            $scope.getAge = function (date) {
                return moment().subtract(date).year;
            };

            $scope.formatDate = function (date) {
                var dt = new Date(date);
                return dt.toLocaleDateString();
            };

            //Private methods
            var get_investor = function (id) {

                investorDataFactory.getInvestor(id)
                    .success(function (data) {
                        $scope.vm.investor = data;
                    });
            };
            var update_investor = function (id, data) {
                investorDataFactory.updateInvestor(id, data)
                    .success(function () {
                        get_investor(id);
                    });
            };

            var cancel_add = function () {
                $scope.vm.create.revenue =
                    $scope.vm.create.car =
                        $scope.vm.create.contract =
                            $scope.vm.create.driver = false;
            };

            var load_contract_statuses = function () {
                $scope.vm.statuses.push({"key": "Ongoing", "value": 1});
                $scope.vm.statuses.push({"key": "Suspended", "value": 2});
                $scope.vm.statuses.push({"key": "Terminated", "value": 3});
                $scope.vm.statuses.push({"key": "Complete", "value": 4});
                $scope.selected.status = $scope.vm.statuses[0];
            };
            var load_revenues = function () {
                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getRevenues(investor_id)
                    .success(function (data) {
                        $scope.vm.investor.revenues = data;
                    });
            };
            var load_contracts = function () {
                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getContracts(investor_id)
                    .success(function (data) {
                        $scope.vm.investor.contracts = data;
                    });
            };
            var load_cars = function () {
                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getCars(investor_id)
                    .success(function (data) {
                        $scope.vm.investor.cars = data;
                    });
            };
            var load_drivers = function () {
                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getDrivers(investor_id)
                    .success(function (data) {
                        $scope.vm.investor.drivers = data;
                    });
            };

            var pay_investor_contract = function (contract, amount) {
                var data = {
                    'amount_paid': amount,
                    'contract_id': contract,
                    'paid_on': moment().format("YYYY-MM-DD")
                };

                revenueDataFactory.newRevenue(data)
                    .success(function (data) {
                        alert('revenue submitted!');
                        $scope.vm.paying = false;
                        $scope.vm.investor.revenues.push(data);
                    });
            };

            var init = function () {
                var url = (window.location.pathname);
                console.log(url);
                var id = _.takeRight(_.split(url, '/'))[0];
                console.log(id);
                if (id)
                    get_investor(id);

                load_contract_statuses();
            };

            init();
        }]);