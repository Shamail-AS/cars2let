app.controller('investorController',
    [
        '$scope',
        'investorDataFactory',
        'investorDataModelFactory',
        'revenueDataFactory',
        'driverDataFactory',
        'carDataFactory',
        'contractDataFactory',
        'moment',
        function ($scope,
                  investorDataFactory,
                  investorDataModelFactory,
                  revenueDataFactory,
                  driverDataFactory,
                  carDataFactory,
                  contractDataFactory,
                  moment) {

            //Objects
            $scope.dynamicPopover = {
                content: 'Hello, World!',
                templateUrl: 'contract_payment.html',
                revenueListUrl: 'revenue_list.html',
                title: 'Title',
                trigger: 'focus'
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
            $scope.updateInvestor = function (obj) {
                obj.edit_mode = false;
                update_investor(obj.id, obj);
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

            $scope.newRevenue = function () {
                pay_investor_contract($scope.dirty.revenue.contract.id, parseFloat($scope.dirty.revenue.amount));

            };
            $scope.newCar = function () {
                console.log($scope.dirty.car);
                $scope.dirty.car.investor_id = $scope.vm.investor.id;
                new_car($scope.dirty.car);
            };
            $scope.newContract = function () {
                console.log($scope.dirty.contract);
                new_contract($scope.dirty.contract);
            };
            $scope.newDriver = function () {
                console.log($scope.dirty.driver);
                new_driver($scope.dirty.driver);
            };

            $scope.openPicker = function (obj) {
                obj.picker_open = true;
            };
            $scope.openStartPicker = function (contract) {
                contract.start_picker_open = true;
            };
            $scope.openEndPicker = function (contract) {
                contract.end_picker_open = true;
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
                        load_contracts();
                    });
            };
            var update_investor = function (id, investor) {
                investor.dob = moment(investor.dt_dob).format("DD-MM-YYYY");
                investorDataFactory.updateInvestor(id, investor)
                    .success(function () {
                        get_investor(id);
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
                        $scope.vm.selected_contract = $scope.vm.investor.contracts[0].id;
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
                        load_cars();
                    });

            };
            var new_contract = function (contract) {
                contract.status = contract.x_status.value;
                contract.rate = parseFloat(contract.rate);
                contract.start_date = moment(contract.dt_start_date).format("YYYY-MM-DD");
                contract.end_date = moment(contract.dt_end_date).format("YYYY-MM-DD");
                contractDataFactory.newContract(contract)
                    .success(function (result) {
                        load_contracts();
                    });
            };
            var new_driver = function (data) {
                driverDataFactory.newDriver(data)
                    .success(function (result) {
                        alert(result);
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
                load_all_drivers();
            };

            init();
        }]);