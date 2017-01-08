app.controller('detailsController', ['$scope', 'detailsDataFactory', 'detailsDataModelFactory', function ($scope, detailsDataFactory, detailsDataModelFactory) {

    //Objects
    $scope.vm = {
        'car': {},
        'loading': true,
        'transmissions': [],
        'fuels': [],
        'statuses': [],
        'suppliers': [],
        'investors': []
    };

    $scope.formatDate = function (date) {
        var dt = moment(date);
        return dt.format("DD, MMM YYYY");
    };

    $scope.updateCar = function (car) {
        save_car(car);
    };
    $scope.saveSelective = function (car, prop) {
        if (prop == 'comments')
            update_comments(car);
    };


    var load_extras = function () {
        detailsDataFactory.getSuppliers().success(function (data) {
            $scope.vm.suppliers = data;
        });
        detailsDataFactory.getInvestors().success(function (data) {
            $scope.vm.investors = data;
        });

        $scope.vm.transmissions = _.concat($scope.vm.transmissions, ['automatic', 'semi-automatic', 'manual']);
        $scope.vm.fuels = _.concat($scope.vm.fuels, ['petrol', 'diesel', 'lpg', 'bio']);
        $scope.vm.statuses = _.concat($scope.vm.statuses, ['on-road', 'off-road']);

    };
    var load_car = function (id) {
        detailsDataFactory.getCar(id)
            .success(function (data) {
                $scope.vm.car = detailsDataModelFactory.withExtras(data);
                $scope.vm.loading = false;
            });
    };

    var save_car = function (car) {
        var data = detailsDataModelFactory.removeExtras(car);
        $scope.vm.loading = true;
        detailsDataFactory.updateCar(car.id, data)
            .success(function (data) {
                $scope.vm.loading = false;
            });
    };
    var update_comments = function (car) {
        var data = {
            id: car.id,
            prop: 'comments',
            value: car.comments
        };
        detailsDataFactory.updateSelective(car.id, data)
            .success(function (response) {
                console.log(response);
            });
    };

    var init = function () {
        $scope.vm.car.loading = false;
        var id = get_id_from_url();
        if (id) {
            load_car(id);
            load_extras();
        }
    };
    var get_id_from_url = function () {
        var url = (window.location.pathname);
        var id = _.split(url, '/')[3]; // that's where the car id is stored
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


            var get_car = function (id) {
                $scope.vm.loading = true;
                overviewDataFactory.getCar(id)
                    .then(function (result) {
                        $scope.vm.car = detailsDataModelFactory.withExtras(result.data);
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
                    get_car(id);
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

app.controller('alertsController', ['$scope', function ($scope) {

}]);

app.controller('servicesController', ['$scope', 'moment', 'ModalService', 'servicesDataFactory', 'servicesDataModelFactory'
    , function ($scope, moment, ModalService, servicesDataFactory, servicesDataModelFactory) {

        $scope.vm = {
            'car_id': -1,
            'orders': []
        };

        $scope.dirty = {
            token: ''
        };

        $scope.formatDate = function (date) {
            if (!date) return "-";
            var dt = moment(date);
            return dt.format("DD MMM, YYYY");
        };

        $scope.newOrder = function () {
            ModalService.showModal({
                scope: $scope,
                templateUrl: "new-service.html",
                controller: "serviceModalController",
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
                        $scope.vm.orders.push(result);
                    }
                });
            });
        };

        $scope.editOrder = function (order) {
            ModalService.showModal({
                scope: $scope,
                templateUrl: "new-service.html",
                controller: "serviceModalController",
                inputs: {
                    data: {
                        token: $scope.dirty.token,
                        car_id: $scope.vm.car_id,
                        order: order
                    }
                }
            }).then(function (modal) {
                modal.element.modal();
                modal.close.then(function (result) {
                    console.log(result);
                });
            });
        };


        var load_orders = function (id) {
            servicesDataFactory.getOrders(id)
                .then(function (result) {
                    console.log(result);
                    $scope.vm.orders = servicesDataModelFactory.withExtras(result.data);
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
                load_orders(id);
            }

        };

        init();
}]);
app.controller('serviceModalController',
    ['$scope', 'moment', 'overviewDataFactory', 'servicesDataFactory', 'servicesDataModelFactory', 'supplierDataFactory', 'data', 'close',
        function ($scope, moment, overviewDataFactory, servicesDataFactory, servicesDataModelFactory, supplierDataFactory, data, close) {

            $scope.vm = {
                types: [],
                statuses: [],
                suppliers: [],
                token: data.token
            };

            $scope.order = {};
            $scope.dirty = {
                suppliers: [],
                isNew: true
            };
            $scope.close = function (result) {
                close(result, 500); // close, but give 500ms for bootstrap to animate
            };
            $scope.formatDate = function (date) {
                if (!date) return "-";
                return format_date(date);
            };

            $scope.save = function () {
                if (!$scope.dirty.isNew) {
                    //console.log('update');
                    update_order($scope.order);
                }
                else {
                    //console.log('save');
                    save_order($scope.order);
                }
            };

            var format_date = function (date) {
                var dt = moment(date);
                return dt.format("MMM DD, YYYY");
            };

            var save_order = function (data) {
                data._token = $scope.vm.token;
                servicesDataFactory.newOrder(data.car.id, servicesDataModelFactory.withoutObjects(data))
                    .then(function (result) {
                        $scope.close(result.data);
                    });
            };
            var update_order = function (data) {
                data._token = $scope.vm.token;
                servicesDataFactory.updateOrder(data)
                    .then(function (result) {

                    });
            };

            var load_types = function () {
                $scope.vm.types.push('PCO');
                $scope.vm.types.push('MOT');
                $scope.vm.types.push('Regular');
                $scope.vm.types.push('REPAIR');
            };

            var load_statuses = function () {
                $scope.vm.statuses.push('new');
                $scope.vm.statuses.push('handed');
                $scope.vm.statuses.push('received');
            };

            var load_suppliers = function () {
                supplierDataFactory.getSuppliers()
                    .then(function (result) {
                        $scope.vm.suppliers = result.data;
                    })
            };

            var init = function () {
                load_types();
                load_statuses();
                load_suppliers();
                if (data.order) {
                    $scope.order = data.order;
                    $scope.dirty.isNew = false;
                    $scope.order.booked_dt = moment(data.order.booked_dt).toDate();
                    $scope.order.handover_dt = moment(data.order.handover_dt).toDate();
                    return;
                }
                overviewDataFactory.getCar(data.car_id)
                    .then(function (result) {
                        $scope.order.car = result.data;
                    });
            };

            init();


        }]);

app.controller('deliveriesController',
    ['$scope', 'moment', 'ModalService', 'deliveriesDataFactory', 'deliveriesDataModelFactory',
        function ($scope, moment, ModalService, deliveriesDataFactory, deliveriesDataModelFactory) {

            $scope.vm = {
                deliveries: []
            };
            $scope.dirty = {
                token: ''
            };

            var format_date = function (date) {
                var dt = moment(date);
                return dt.format("MMM DD, YYYY");
            };

            $scope.newDelivery = function () {
                ModalService.showModal({
                    scope: $scope,
                    templateUrl: "new-delivery.html",
                    controller: "deliveriesModalController",
                    inputs: {
                        data: {
                            token: $scope.dirty.token,
                            car_id: $scope.vm.car_id
                        }
                    }
                }).then(function (modal) {
                    modal.element.modal();
                    modal.close.then(function (result) {
                        $scope.vm.deliveries.push(result);
                    });
                });
            };

            $scope.editDelivery = function (delivery) {
                ModalService.showModal({
                    scope: $scope,
                    templateUrl: "new-delivery.html",
                    controller: "deliveriesModalController",
                    inputs: {
                        data: {
                            token: $scope.dirty.token,
                            car_id: $scope.vm.car_id,
                            delivery: delivery
                        }
                    }
                }).then(function (modal) {
                    modal.element.modal();
                    modal.close.then(function (result) {
                        console.log(result);
                    });
                });
            };

            var load_deliveries = function (id) {
                deliveriesDataFactory.getDeliveries(id)
                    .then(function (result) {
                        $scope.vm.deliveries = deliveriesDataModelFactory.withExtras(result.data);
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
                    load_deliveries(id);
                }

            };

            init();
}]);
app.controller('deliveriesModalController',
    ['$scope', 'moment', 'deliveriesDataFactory', 'overviewDataFactory', 'deliveriesDataModelFactory', 'data', 'close',
        function ($scope, moment, deliveriesDataFactory, overviewDataFactory, deliveriesDataModelFactory, data, close) {

            $scope.vm = {
                types: [],
                statuses: []
            };
            $scope.delivery = {};
            $scope.dirty = {
                isNew: true
            };
            $scope.close = function (result) {
                close(result, 500); // close, but give 500ms for bootstrap to animate
            };

            $scope.save = function () {
                if (!$scope.dirty.isNew) {
                    console.log('update');
                    update_delivery($scope.delivery);
                }
                else {
                    console.log('save');
                    save_delivery($scope.delivery);
                }
            };

            var save_delivery = function (data) {
                data._token = $scope.vm.token;
                deliveriesDataFactory.newDelivery(data.car.id, deliveriesDataModelFactory.withoutExtras(data))
                    .then(function (result) {
                        $scope.close(result.data);
                    });
            };
            var update_delivery = function (data) {
                data._token = $scope.vm.token;
                deliveriesDataFactory.updateDelivery(data)
                    .then(function (result) {

                    });
            };

            var load_statuses = function () {
                $scope.vm.statuses.push('expected');
                $scope.vm.statuses.push('delayed');
                $scope.vm.statuses.push('cancelled');
                $scope.vm.statuses.push('received');
            };
            var load_types = function () {
                $scope.vm.types.push('contract-return');
                $scope.vm.types.push('car-order');
                $scope.vm.types.push('service-order');
                $scope.vm.types.push('other');
            };

            var init = function () {
                load_types();
                load_statuses();
                if (data.delivery) {
                    $scope.delivery = data.delivery;
                    $scope.dirty.isNew = false;
                    $scope.delivery.scheduled_at = moment(data.delivery.scheduled_at).toDate();
                    $scope.delivery.delivered_at = moment(data.delivery.delivered_at).toDate();
                    return;
                }
                overviewDataFactory.getCar(data.car_id)
                    .then(function (result) {
                        $scope.delivery.car = result.data;
                    });
            };

            init();

        }]);

app.controller('partsController', ['$scope', 'cameraDataFactory', 'trackerDataFactory', 'simDataFactory',
    function ($scope, cameraDataFactory, trackerDataFactory, simDataFactory) {

        $scope.vm = {
            camera: {},
            sim: {},
            tracker: {}
        };


        var get_parts = function (car_id) {

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
                load_deliveries(id);
            }
        };

        init();
}]);