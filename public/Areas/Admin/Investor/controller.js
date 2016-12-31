app.controller('revenueModalController', function ($scope, data, moment, contractDataFactory, revenueDataFactory, close) {

    $scope.vm = {
        loading: true,
        contract: data,
        revenues: []
    };
    $scope.close = function (result) {
        close(result, 500); // close, but give 500ms for bootstrap to animate
    };
    $scope.formatDate = function (date) {
        if (!date) return "-";
        return format_date(date);
    };
    $scope.save = function () {
        update_revenues();
    };

    var format_date = function (date) {
        var dt = moment(date);
        return dt.format("MMM DD, YYYY");
    };

    var load_revenues = function (id) {
        $scope.vm.loading = true;
        contractDataFactory.getRevenues(id)
            .then(function (result) {
                $scope.vm.revenues = withExtras(result.data);
                $scope.vm.loading = false;
            });
    };
    var withExtras = function (revenues) {
        _.each(revenues, function (rev) {
            var start = moment(rev.dates.start.date);
            var end = moment(rev.dates.end.date);
            var act_end = moment(rev.dates.act_end.date);

            if (start.diff(act_end) >= 0) {
                rev.class = 'disabled';
            }
            else {
                rev.class = 'enabled';
            }

            if (act_end.isBefore(end, 'day')) {
                rev.date_string = format_date(start) + " - " + format_date(end) + " [" + format_date(act_end) + "] ";
            }
            else {
                rev.date_string = format_date(start) + " - " + format_date(end);
            }

        });
        return revenues;
    };

    var update_revenues = function () {
        var allocations = $scope.vm.revenues;
        revenueDataFactory.updateAllocations(allocations)
            .then(function (result) {
                alert(result.data);
                console.log(result);
            })
    };
    var init = function () {
        load_revenues($scope.vm.contract.id);
    };

    init();
});

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

        function ($scope,
                  moment,
                  ModalService,
                  investorDataFactory,
                  investorDataModelFactory,
                  revenueDataFactory,
                  driverDataFactory,
                  carDataFactory,
                  contractDataFactory) {

            //Objects
            $scope.dynamicPopover = {
                content: 'Hello, World!',
                templateUrl: 'contract_payment.html',
                revenueListUrl: 'revenue_list.html',
                title: 'Title',
                trigger: 'focus'
            };

            $scope.openRevenues = function (contract) {
                ModalService.showModal({
                    templateUrl: "contract-payments.html",
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
                    'minDate': new Date(),
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

            //$scope.newRevenue = function () {
            //    pay_investor_contract($scope.dirty.revenue.contract.id, parseFloat($scope.dirty.revenue.amount));
            //
            //};
            $scope.newCar = function () {
                console.log($scope.dirty.car);
                $scope.dirty.car.investor_id = $scope.vm.investor.id;
                new_car($scope.dirty.car);
            };
            $scope.newContract = function () {
                console.log($scope.dirty.contract);
                new_contract(_.cloneDeep($scope.dirty.contract));
            };
            //$scope.newDriver = function () {
            //    console.log($scope.dirty.driver);
            //    new_driver($scope.dirty.driver);
            //};

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
                contract.status = contract.x_status.value;
                contract.start_date = moment(contract.dt_start_date).format("YYYY-MM-DD");
                contract.end_date = moment(contract.dt_end_date).format("YYYY-MM-DD");
                contractDataFactory.updateContract(contract.id, contract)
                    .success(function (result) {
                        alert(result);
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
                $scope.vm.statuses.push({"key": "Ongoing", "value": 1});
                $scope.vm.statuses.push({"key": "Suspended", "value": 2});
                $scope.vm.statuses.push({"key": "Terminated", "value": 3});
                $scope.vm.statuses.push({"key": "Complete", "value": 4});
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
                    .success(function (data) {
                        $scope.vm.investor.contracts = investorDataModelFactory.withContractExtras(data);
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
                        console.log(contract.id);
                        $scope.vm.investor.contracts.push(contract);
                        cancel_add();
                    });
            };
            //var new_driver = function (data) {
            //    driverDataFactory.newDriver(data)
            //        .success(function (result) {
            //            alert(result);
            //        });
            //};

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