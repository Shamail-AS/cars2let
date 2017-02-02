app.controller('detailsController', ['$scope', 'detailsDataFactory', 'detailsDataModelFactory', function ($scope, detailsDataFactory, detailsDataModelFactory) {

    //Objects
    $scope.vm = {
        'driver': {},
        'loading': true,
        // 'transmissions': [],
        // 'fuels': [],
        // 'statuses': [],
        // 'suppliers': [],
        // 'investors': []
    };

    $scope.formatDate = function (date) {
        var dt = moment(date);
        return dt.format("DD, MMM YYYY");
    };

    $scope.updateDriver = function (driver) {
        save_driver(driver);
    };
    $scope.saveSelective = function (driver, prop) {
        if (driver == 'comments')
            update_comments(driver);
    };


    var load_driver = function (id) {
        detailsDataFactory.getDriver(id)
            .success(function (data) {
                $scope.vm.driver = detailsDataModelFactory.withExtras(data);
                $scope.vm.loading = false;
            });
    };

    var save_driver = function (driver) {
        var data = detailsDataModelFactory.removeExtras(driver);
        $scope.vm.loading = true;
        detailsDataFactory.updateDriver(driver.id, data)
            .success(function (data) {
                $scope.vm.loading = false;
                alert('Record Successfully Updated');
            });
    };
    var update_comments = function (driver) {
        var data = {
            id: driver.id,
            prop: 'comments',
            value: driver.comments
        };
        detailsDataFactory.updateSelective(driver.id, data)
            .success(function (response) {
                console.log(response);
            });
    };

    var init = function () {
        $scope.vm.driver.loading = false;
        var id = get_id_from_url();
        if (id) {
            load_driver(id);
        }
    };
    var get_id_from_url = function () {
        var url = (window.location.pathname);
        var id = _.split(url, '/')[3]; // that's where the Driver id is stored
        return id;
    };

    init();
}]);

app.controller('overviewController',
    ['$scope',
        'moment',
        'overviewDataFactory',
        'overviewDataModelFactory',
        'detailsDataModelFactory',
        'contractDataFactory',
        'contractDataModelFactory',
        function ($scope,
                  moment,
                  overviewDataFactory,
                  overviewDataModelFactory,
                  detailsDataModelFactory,
                  contractDataFactory,
                  contractDataModelFactory) {

            $scope.vm = {
                loading: true,
                car: {},
                contract: {},
                notifications: [],
                histories: []
            };

            $scope.formatDate = function (date) {
                if (!date) return "-";
                var dt = moment(date);
                return dt.format("DD MMM, YYYY");
            };

            var get_overview = function (id) {
                overviewDataFactory.getOverview(id)
                    .success(function (response) {
                        //$scope.vm.notifications = overviewDataModelFactory.getNotifications(response.alerts);
                        $scope.vm.histories = overviewDataModelFactory.getHistories(response.histories);
                    });
            };


            var get_driver = function (id) {
                $scope.vm.loading = true;
                overviewDataFactory.getDriver(id)
                    .then(function (result) {
                        $scope.vm.driver = detailsDataModelFactory.withExtras(result.data);
                        $scope.vm.notifications = overviewDataModelFactory.getNotifications(result.data.notis);
                        $scope.vm.loading = false;
                        return result.data.currentContract;
                    })
                    .then(function (contract) {
                        if (contract != null) {
                            get_contract(contract.id);
                        }
                    });
            };

            var get_contract = function (id) {
                contractDataFactory.getContract(id)
                    .then(function (result) {
                        $scope.vm.contract = contractDataModelFactory.withExtras(result.data);
                    });
            };

            var init = function () {
                var id = get_id_from_url();
                if (id) {
                    get_driver(id);
                    //get_overview(id);
                }
            };
            var get_id_from_url = function () {
                var url = (window.location.pathname);
                var id = _.split(url, '/')[3]; // that's where the car id is stored
                return id;
            };

            init();
        }]);

app.controller('ticketsController', ['$scope', 'moment', 'ModalService', 'ticketDataFactory', 'ticketDataModelFactory'
    , function ($scope, moment, ModalService, ticketDataFactory, ticketDataModelFactory) {

        $scope.vm = {
            'car_id': -1,
            'tickets': [],
            'drivers': []
        };

        $scope.dirty = {
            token: ''
        };

        $scope.formatDate = function (date) {
            if (!date) return "-";
            var dt = moment(date);
            return dt.format("DD MMM, YYYY");
        };

        $scope.newTicket = function () {
            ModalService.showModal({
                scope: $scope,
                templateUrl: "new-ticket.html",
                controller: "ticketModalController",
                inputs: {
                    data: {
                        token: $scope.dirty.token,
                        car_id: $scope.vm.car_id
                    }
                }
            }).then(function (modal) {
                modal.element.modal();
                modal.close.then(function (result) {
                    if (result.id) {
                        $scope.vm.tickets.push(result);
                    }
                });
            });
        };

        $scope.editTicket = function (ticket) {
            ModalService.showModal({
                scope: $scope,
                templateUrl: "new-ticket.html",
                controller: "ticketModalController",
                inputs: {
                    data: {
                        token: $scope.dirty.token,
                        car_id: $scope.vm.car_id,
                        ticket: ticket
                    }
                }
            }).then(function (modal) {
                modal.element.modal();
                modal.close.then(function (result) {
                    console.log(result);
                });
            });
        };


        var load_tickets = function (id) {
            ticketDataFactory.getTickets(id)
                .then(function (result) {
                    $scope.vm.tickets = ticketDataModelFactory.withExtras(result.data);
                });
        };

        var get_id_from_url = function () {
            var url = (window.location.pathname);
            var id = _.split(url, '/')[3]; // that's where the car id is stored
            return id;
        };

        var init = function () {
            var id = get_id_from_url();
            if (id) {
                $scope.vm.car_id = id;
                $scope.dirty.token = $('input#csrf_token').val();
                load_tickets(id);
            }

        };

        init();
    }]);

app.controller('ticketModalController', ['$scope', 'moment', 'data', 'overviewDataFactory', 'ticketDataFactory', 'close', function ($scope, moment, data, overviewDataFactory, ticketDataFactory, close) {

    $scope.vm = {
        causes: [],
        statuses: [],
        token: data.token
    };

    $scope.ticket = {};
    $scope.dirty = {
        incident_open: false,
        issue_open: false,
        isNew: true

    };
    $scope.close = function (result) {
        close(result, 500); // close, but give 500ms for bootstrap to animate
    };
    $scope.formatDate = function (date) {
        if (!date) return "-";
        return format_date(date);
    };
    $scope.inferDriver = function () {
        var car_id = data.car_id;
        var incident_dt = moment($scope.ticket.incident_dt).unix();

        ticketDataFactory.inferDriver(car_id, incident_dt)
            .then(function (result) {
                $scope.ticket.driver = result.data;
            });
    };

    $scope.save = function () {
        if (!$scope.dirty.isNew) {
            //console.log('update');
            update_ticket($scope.ticket);
        }
        else {
            //console.log('save');
            save_ticket($scope.ticket);
        }
    };

    var format_date = function (date) {
        var dt = moment(date);
        return dt.format("MMM DD, YYYY");
    };

    var save_ticket = function (data) {
        data._token = $scope.vm.token;
        ticketDataFactory.newTicket(data.car.id, data)
            .then(function (result) {
                $scope.close(result.data);
            });
    };
    var update_ticket = function (data) {
        data._token = $scope.vm.token;
        ticketDataFactory.updateTicket(data.car.id, data)
            .then(function (result) {
                console.log(result);
            });
    };

    var load_causes = function () {
        $scope.vm.causes.push('pco');
        $scope.vm.causes.push('lsp');
        $scope.vm.causes.push('ffd');
    };

    var load_statuses = function () {
        $scope.vm.statuses.push('new');
        $scope.vm.statuses.push('appealing');
        $scope.vm.statuses.push('closed');
    };

    var init = function () {
        load_causes();
        load_statuses();
        if (data.ticket) {
            $scope.ticket = data.ticket;
            $scope.dirty.isNew = false;
            $scope.ticket.incident_dt = moment(data.ticket.incident_dt).toDate();
            $scope.ticket.issue_dt = moment(data.ticket.issue_dt).toDate();
            return;
        }
        overviewDataFactory.getCar(data.car_id)
            .then(function (result) {
                $scope.ticket.car = result.data;
            });
    };

    init();


}]);

