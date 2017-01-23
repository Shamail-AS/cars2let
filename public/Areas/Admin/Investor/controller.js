app.controller('investorController',
    [
        '$scope',
        'moment',
        'ModalService',
        'investorDataFactory',
        'investorDataModelFactory',
        'revenueDataFactory',
        'driverDataFactory',
        'carDataFactory',
        'contractDataFactory',
        'contractDataModelFactory',

        function ($scope,
                  moment,
                  ModalService,
                  investorDataFactory,
                  investorDataModelFactory,
                  revenueDataFactory,
                  driverDataFactory,
                  carDataFactory,
                  contractDataFactory,
                  contractDataModelFactory) {

            //Objects
            $scope.dynamicPopover = {
                content: 'Hello, World!',
                templateUrl: 'contract_payment.html',
                revenueListUrl: 'revenue_list.html',
                title: 'Title',
                trigger: 'focus'
            };

            $scope.openRentAllocs = function (contract) {
                ModalService.showModal({
                    templateUrl: "contract-rent.html",
                    controller: "revenueModalController",
                    inputs: {
                        data: contract
                    }
                }).then(function (modal) {
                    modal.element.modal();
                    modal.close.then(function (result) {
                        console.log(result);
                    });
                });
            };
            $scope.openPayments = function (contract) {
                ModalService.showModal({
                    templateUrl: "contract-payments.html",
                    controller: "contractPaymentsModalController",
                    inputs: {
                        data: contract
                    }
                }).then(function (modal) {
                    modal.element.modal();
                    modal.close.then(function (result) {
                        console.log(result);
                    });
                });
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


            $scope.vm = {
                'investor': {},
                'create': {
                    'revenue': false,
                    'car': false,
                    'contract': false,
                    'driver': false
                },
                'selected_contract': -1,
                'statuses': []
            };
            $scope.search = {
                'cars': '',
                'contracts': '',
                'drivers': ''
            };
            $scope.filters = {
                car: {},
                contract: {},
                driver: {}
            };
            $scope.active = {
                'cars': false,
                'contracts': true,
                'drivers': false,
                'loading': true
            };
            $scope.dirty = {
                'revenue': {
                    'amount': null,
                    'contract': null
                },
                'car': {},
                'contract': {},
                'driver': {}
            };
            $scope.dateOptions = {
                'start_date': {
                    'maxDate': $scope.dirty.contract.dt_end_date
                },
                'end_date': {
                    'minDate': $scope.dirty.contract.dt_start_date
                },
                'acc_period_start': {
                    'maxDate': $scope.vm.investor.dt_acc_period_end
                },
                'acc_period_end': {
                    'minDate': $scope.vm.investor.dt_acc_period_start
                }
            };

            //Public methods

            $scope.edit = function (obj) {
                obj.edit_mode = true;
            };
            $scope.cancelEdit = function (obj) {
                obj.edit_mode = false;

            };
            $scope.deleteObj = function (obj, type) {
                switch (type) {
                    case 'investor':
                        delete_investor(obj);
                        break;
                    case 'car':
                        delete_car(obj);
                        break;
                    case 'contract':
                        delete_contract(obj);
                        break;
                    case 'driver':
                        delete_driver(obj);
                        break;
                    default :
                        break;

                }

            };

            //INVESTOR
            $scope.updateInvestor = function (investor) {
                investor.edit_mode = false;
                update_investor(investor.id, investor);
            };

            //REVENUE

            $scope.updateRev = function (rev) {
                rev.edit_mode = false;
                update_revenue(rev);
            };

            //CAR

            $scope.updateCar = function (car) {
                car.edit_mode = false;
                update_car(car);
            };

            //CONTRACT

            $scope.updateContract = function (contract) {
                contract.edit_mode = false;
                update_contract(contract);
            };

            $scope.contractAction = function (contract, action) {
                if (action == 'start') {
                    start_contract(contract);
                }
                else if (action == 'end') {
                    end_contract(contract);
                }
            };

            //DRIVER

            $scope.updateDriver = function (driver) {
                driver.edit_mode = false;
                update_driver(driver);
            };


            ///////////////////////// END CRUD //////////////////////////////

            $scope.showRevenues = function () {
                $scope.active.revenues = true;
                $scope.active.contracts =
                    $scope.active.cars =
                        $scope.active.drivers = false;
                cancel_add();
                load_revenues();
            };
            $scope.showRevenue = function (id) {
                $scope.vm.selected_contract = id;
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
            $scope.addNew = function () {
                $scope.vm.create.car = $scope.active.cars;
                $scope.vm.create.contract = $scope.active.contracts;

                $('.fixed-footer-button').toggleClass('clicked');
                $('.card-container').fadeToggle('fast');
                $('.extra-button').fadeToggle('fast');

            };
            $scope.cancelAdd = function () {
                cancel_add();
            };
            $scope.togglePay = function (contract) {
                contract.paying = !contract.paying;
            };
            $scope.cancelPay = function (contract) {
                contract.paying = false;
                contract.payment = 0;
            };
            $scope.pay = function (contract) {
                if (!$scope.isNumber(contract.payment)) {
                    alert("invalid amount");
                    return;
                }
                var payment = parseFloat(contract.payment);
                pay_investor_contract(contract.id, payment);
            };


            $scope.isNumber = function (n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            };
            $scope.newCar = function () {
                console.log($scope.dirty.car);
                $scope.dirty.car.investor_id = $scope.vm.investor.id;
                new_car($scope.dirty.car);
            };
            $scope.newContract = function () {
                console.log($scope.dirty.contract);
                new_contract(_.cloneDeep($scope.dirty.contract));
            };

            $scope.openPicker = function (obj) {
                obj.picker_open = true;
            };
            $scope.openStartPicker = function (obj) {
                obj.start_picker_open = true;
                $scope.dateOptions.start_date.maxDate = obj.dt_end_date;
            };
            $scope.openEndPicker = function (obj) {
                obj.end_picker_open = true;
                $scope.dateOptions.end_date.minDate = obj.dt_start_date;
            };

            $scope.getAge = function (date) {

                return moment(date).fromNow(true);
            };

            $scope.formatDate = function (date) {

                if (!date)return "-";
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };


            //Private methods
            var get_investor = function (id) {

                investorDataFactory.getInvestor(id)
                    .success(function (data) {
                        $scope.vm.investor = investorDataModelFactory.withExtras(data);
                    });
            };
            var get_investor_with_contracts = function (id) {
                $scope.vm.investor.loading = true;
                investorDataFactory.getInvestor(id)
                    .success(function (data) {
                        $scope.vm.investor = investorDataModelFactory.withExtras(data);
                        $scope.dateOptions.acc_period_start.maxDate = $scope.vm.investor.dt_acc_period_end;
                        $scope.dateOptions.acc_period_end.minDate = $scope.vm.investor.dt_acc_period_start;
                        load_contracts();
                        $scope.vm.investor.loading = false;
                    });
            };
            var update_investor = function (id, investor) {
                investor.loading = true;
                investor.dob = moment(investor.dt_dob).format("DD-MM-YYYY");
                investor.acc_period_start = moment(investor.dt_acc_period_start).format("DD-MM-YYYY");
                investor.acc_period_end = moment(investor.dt_acc_period_end).format("DD-MM-YYYY");
                investorDataFactory.updateInvestor(id, investor)
                    .success(function () {
                        investor.loading = false;
                    });
            };
            var update_car = function (car) {
                car.available_since = moment(car.dt_available_since).format("DD-MM-YYYY");
                carDataFactory.updateCar(car.id, car)
                    .success(function (result) {
                        alert(result);
                    });
            };
            var update_contract = function (contract) {
                contract.loading = true;
                contractDataFactory.updateContract(contract.id, contractDataModelFactory.withoutExtras(contract))
                    .then(function (result) {
                        var con = contractDataModelFactory.withExtras(result.data);
                        contract.canStart = con.canStart;
                        contract = con;
                        contract.loading = false;
                    });
            };

            var start_contract = function (contract) {
                contract.loading = true;
                contractDataFactory.startContract(contract.id)
                    .then(function (result) {
                        var con = contractDataModelFactory.withExtras(result.data);
                        contract.status = con.status;
                        contract.act_start_dt = con.act_start_dt;
                        contract.hasStarted = con.hasStarted;
                        contract.loading = false;
                    });

            };
            var end_contract = function (contract) {
                contract.loading = true;
                contractDataFactory.endContract(contract.id)
                    .then(function (result) {
                        var con = contractDataModelFactory.withExtras(result.data);
                        contract.status = con.status;
                        contract.act_end_dt = con.act_end_dt;
                        contract.hasTerminatedEarly = con.hasTerminatedEarly;
                        contract.loading = false;
                    });

            };

            var update_revenue = function (rev) {
                revenueDataFactory.updateRevenue(rev.id, rev)
                    .success(function (result) {
                        alert(result)
                    });
            };


            var cancel_add = function () {
                $('.fixed-footer-button').removeClass('clicked');
                $('.card-container').fadeOut('fast');
                $('.extra-button').fadeOut('fast');
                $scope.vm.create.revenue =
                    $scope.vm.create.car =
                        $scope.vm.create.contract =
                            $scope.vm.create.driver = false;
            };

            var load_contract_statuses = function () {
                $scope.vm.statuses.push({"key": "New", "value": 2});
                $scope.vm.statuses.push({"key": "Ongoing", "value": 1});

                /* DEPRECATED - Contract can only be in suspended or ongoing status*/
                //$scope.vm.statuses.push({"key": "Terminated", "value": 3});
                //$scope.vm.statuses.push({"key": "Complete", "value": 4});
                $scope.dirty.contract.x_status = $scope.vm.statuses[0];
            };
            var load_revenues = function () {
                $scope.active.loading = true;

                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getRevenues(investor_id)
                    .success(function (data) {
                        $scope.vm.investor.revenues = data;
                        $scope.active.loading = false;
                    });
            };
            var load_contracts = function () {
                $scope.active.loading = true;
                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getContracts(investor_id)
                    .then(function (result) {
                        $scope.vm.investor.contracts = investorDataModelFactory.withContractExtras(result.data);
                        $scope.active.loading = false;
                    });
            };
            var load_cars = function () {
                $scope.active.loading = true;
                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getCars(investor_id)
                    .success(function (data) {
                        $scope.vm.investor.cars = investorDataModelFactory.withCarExtras(data);
                        $scope.active.loading = false;
                    });
            };
            var load_drivers = function () {
                $scope.active.loading = true;
                var investor_id = $scope.vm.investor.id;
                investorDataFactory.getDrivers(investor_id)
                    .success(function (data) {
                        $scope.vm.investor.drivers = investorDataModelFactory.withDriverExtras(data);
                        $scope.active.loading = false;
                    });
            };
            var load_all_drivers = function () {
                driverDataFactory.getDrivers()
                    .success(function (data) {
                        $scope.vm.all_drivers = data;
                    });
            };

            var pay_investor_contract = function (contract, amount) {
                var data = {
                    'amount_paid': amount,
                    'contract_id': contract
                };

                revenueDataFactory.newRevenue(data)
                    .success(function (data) {
                        alert('revenue submitted!');
                        $scope.vm.create.revenue = false;
                        $scope.vm.investor.revenues.push(data);
                    });
            };

            var new_car = function (car) {
                car.available_since = moment(car.dt_available_since).format("DD-MM-YYYY");
                carDataFactory.newCar(car)
                    .success(function (result) {
                        $scope.vm.investor.cars.push(car);
                        cancel_add();
                    });

            };
            var new_contract = function (contract) {
                contract.status = contract.x_status.value;
                contract.rate = parseFloat(contract.rate);
                contract.start_date = moment(contract.dt_start_date).format("YYYY-MM-DD");
                contract.end_date = moment(contract.dt_end_date).format("YYYY-MM-DD");
                contractDataFactory.newContract(contract)
                    .success(function (result) {
                        contract.id = result.id;
                        contract.req_deposit = result.req_deposit;
                        $scope.vm.investor.contracts.push(contract);
                        cancel_add();
                    });
            };
            var init = function () {
                var url = (window.location.pathname);
                console.log(url);
                var id = _.takeRight(_.split(url, '/'))[0];
                console.log(id);
                if (id)
                    get_investor_with_contracts(id);

                load_contract_statuses();
                load_all_drivers();
            };

            init();
        }]);