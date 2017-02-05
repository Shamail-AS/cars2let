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
        $scope.vm.statuses = _.concat($scope.vm.statuses, ['on-road', 'off-road','off-rent']);

    };
    var load_car = function (id) {
        detailsDataFactory.getCar(id)
            .success(function (data) {
                $scope.vm.car = detailsDataModelFactory.withExtras(data);
                $scope.vm.loading = false;
            });
    };

    var save_car = function (car) {
        console.log(car);
        var data = detailsDataModelFactory.removeExtras(car);

        $scope.vm.loading = true;
        detailsDataFactory.updateCar(car.id, data)
            .success(function (data) {
                $scope.vm.loading = false;
                alert('The Car Updated Successfully');
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

app.controller('accidentController', ['$scope', 'ModalService', 'accidentDataFactory', 'accidentDataModelFactory',
    function ($scope, ModalService, accidentDataFactory, accidentDataModelFactory) {

        $scope.vm = {
            car_id: -1,
            accidents: []
        };
        $scope.dirty = {};
        $scope.formatDate = function (date) {
            if (!date) return "-";
            return format_date(date);
        };
        $scope.newAccident = function () {
            ModalService.showModal({
                scope: $scope,
                templateUrl: "new-accident.html",
                controller: "accidentModalController",
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
                        $scope.vm.accidents.push(result);
                    }
                });
            });
        };

        $scope.editAccident = function (accident) {
            ModalService.showModal({
                scope: $scope,
                templateUrl: "new-accident.html",
                controller: "accidentModalController",
                inputs: {
                    data: {
                        token: $scope.dirty.token,
                        car_id: $scope.vm.car_id,
                        accident: accident
                    }
                }
            }).then(function (modal) {
                modal.element.modal();
                modal.close.then(function (result) {
                    if (result.id) {
                        accident = result;
                    }
                });
            });
        };

        var format_date = function (date) {
            var dt = moment(date);
            return dt.format("YYYY-MM-DD, HH:mm");
        };


        var load_accidents = function (car_id) {
            accidentDataFactory.getAccidents(car_id)
                .then(function (result) {
                    $scope.vm.accidents = accidentDataModelFactory.collectionWithExtras(result.data);
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
                load_accidents(id);
            }

        };

        init();
    }]);
app.controller('accidentModalController',
    ['$scope', '$element', 'moment', 'accidentDataFactory', 'ticketDataFactory', 'accidentDataModelFactory', 'data', 'close',
        function ($scope, $element, moment, accidentDataFactory, ticketDataFactory, accidentDataModelFactory, data, close) {

            $scope.vm = {
                car_id: data.car_id,
                token: data.token,
                types: [],
                statuses: []
            };
            $scope.dirty = {};

            $scope.close = function (result) {
                $element.modal('hide');
                close(result, 500); // close, but give 500ms for bootstrap to animate
            };
            $scope.formatDate = function (date) {
                if (!date) return "-";
                return format_date(date);
            };

            $scope.save = function () {
                var data = ($scope.dirty);
                data._token = $scope.vm.token;
                var car_id = $scope.vm.car.id;
                var driver = _.cloneDeep(data.driver);
                if ($scope.dirty.isEdit) {
                    update_accident(car_id, data);
                }
                else {
                    console.log('hello');
                    record_accident(car_id, data);
                }
                $scope.dirty.driver = driver;
            };

            $scope.inferDriver = function () {
                var car_id = data.car_id;
                var incident_dt = moment($scope.dirty.incident_at).unix();

                ticketDataFactory.inferDriver(car_id, incident_dt)
                    .then(function (result) {
                        $scope.dirty.driver = result.data;
                    });
            };

            var format_date = function (date) {
                var dt = moment(date);
                return dt.format("MMM DD, YYYY");
            };

            var record_accident = function (id, accident) {
                var data = accidentDataModelFactory.withoutExtras(accident);
                accidentDataFactory.newCarAccident(id, data)
                    .then(function (result) {

                        $scope.close(result.data);
                    }, function (error) {
                        alert('There was an error in processing your request');
                    });
            };
            var update_accident = function (id, accident) {
                var data = accidentDataModelFactory.withoutExtras(accident);
                accidentDataFactory.updateAccident(id, data)
                    .then(function (result) {
                        $scope.close('updated');
                    }, function (error) {
                         alert('There was an error in processing your request');
                    });
            };
            var load_car = function (id) {
                accidentDataFactory.getCar(id)
                    .then(function (result) {
                        $scope.vm.car = result.data;
                    });
            };

            var init = function () {
                load_car(data.car_id);
                $scope.vm.statuses = _.concat($scope.vm.statuses, ['open', 'more-info', 'police-case', 'insured', 'settled', 'closed']);
                $scope.vm.types = _.concat($scope.vm.types, ['minor', 'major']);
                if (data.accident) {
                    $scope.dirty = data.accident;
                    $scope.dirty.isEdit = true;
                }
            };

            init();


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
                    var orders = servicesDataModelFactory.collectionWithExtras(result.data);
                    console.log(orders);
                    $scope.vm.orders = orders;
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

            var save_order = function (order) {
                order._token = $scope.vm.token;
                var data = servicesDataModelFactory.withoutObjects(order);
                console.log(data);
                servicesDataFactory.newOrder(order.car.id, data)
                    .then(function (result) {
                        $scope.close(result.data);
                    });
            };
            var update_order = function (order) {
                order._token = $scope.vm.token;
                var data = servicesDataModelFactory.withoutObjects(order);
                console.log(data);
                servicesDataFactory.updateOrder(data)
                    .then(function (result) {
                        console.log(result);
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
            $scope.formatDate = function (date) {
                if (!date) return "-";
                return format_date(date);
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
                        delivery = result;
                        console.log(result);
                    });
                });
            };

            var format_date = function (date) {
                var dt = moment(date);
                if (!dt.isValid()) return "-";
                return dt.format("MMM DD, YYYY");
            };

            var load_deliveries = function (id) {
                deliveriesDataFactory.getDeliveries(id)
                    .then(function (result) {
                        $scope.vm.deliveries = deliveriesDataModelFactory.collectionWithExtras(result.data);
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
                        data = deliveriesDataModelFactory.withExtras(result.data);
                        $scope.close(data);
                    }, function (error) {
                        alert(error.data);
                    });
            };
            var update_delivery = function (data) {
                data._token = $scope.vm.token;
                deliveriesDataFactory.updateDelivery(data.car.id, data.id, data)
                    .then(function (result) {
                        data = deliveriesDataModelFactory.withExtras(result.data);
                        $scope.close(data);
                    }, function (error) {
                        console.log(error.data);
                    });
            };

            var load_statuses = function () {
                $scope.vm.statuses.push('expected');
                $scope.vm.statuses.push('delayed');
                $scope.vm.statuses.push('cancelled');
                $scope.vm.statuses.push('received');
            };
            var load_types = function () {
                $scope.vm.types.push('contract-handover');
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
                $scope.delivery.type = 'other';
                overviewDataFactory.getCar(data.car_id)
                    .then(function (result) {
                        $scope.delivery.car = result.data;
                    });
            };

            init();

        }]);

app.controller('partsController',
    ['$scope',
        'cameraDataFactory',
        'cameraDataModelFactory',
        'trackerDataFactory',
        'trackerDataModelFactory',
        'simDataFactory',
        'simDataModelFactory',
        'partOrderDataFactory',
        'partOrderDataModelFactory',
        'partDeliveryDataFactory',
        'partDeliveryDataModelFactory',
        function ($scope,
                  cameraDataFactory,
                  cameraDataModelFactory,
                  trackerDataFactory,
                  trackerDataModelFactory,
                  simDataFactory,
                  simDataModelFactory,
                  partOrderDataFactory,
                  partOrderDataModelFactory,
                  partDeliveryDataFactory,
                  partDeliveryDataModelFactory) {

        $scope.vm = {
            car_id: -1,
            camera: {},
            sim: {},
            tracker: {},
            suppliers: [],
            statuses: {
                tracker: ['ordered', 'delivered', 'fitted', 'faulty', 'removed', 'deactivated'],
                camera: ['ordered', 'delivered', 'fitted', 'faulty', 'removed', 'deactivated'],
                order: ['ready', 'scheduled', 'delivered', 'cancelled']
            }
        };

            $scope.dirty = {};

            $scope.create = function (type) {
                if (type == 'tracker')
                    new_tracker($scope.vm.tracker);
                else if (type == 'camera')
                    new_camera($scope.vm.camera);
                else if (type == 'sim')
                    new_sim($scope.vm.sim);
            };
            $scope.update = function (type) {
                if (type == 'tracker')
                    update_tracker($scope.vm.tracker);
                else if (type == 'camera')
                    update_camera($scope.vm.camera);
                else if (type == 'sim')
                    update_sim($scope.vm.sim);
            };

            $scope.order = function (type) {
                if (type == 'tracker')
                    order_tracker($scope.vm.tracker);
                else if (type == 'camera')
                    order_camera($scope.vm.camera);
                else if (type == 'sim')
                    order_sim($scope.vm.sim);
            };

            $scope.deliver = function (order) {
                var data = order.delivery;
                data._token = $scope.dirty.token;
                book_delivery(order, data);
            };


            $scope.updateOrder = function (order) {
                if (!order) return;
                update_order(order.id, order);
            };
            $scope.updateDelivery = function (delivery) {
                if (!delivery) return;
                update_delivery(delivery.id, delivery);
            };

            var new_tracker = function (tracker) {
                var data = tracker;
                var car_id = $scope.vm.car_id;
                if (car_id < 0) return;

                tracker.loading = true;
                trackerDataFactory.newTracker(car_id, trackerDataModelFactory.withoutExtras(data))
                    .then(function (result) {
                        $scope.vm.tracker = trackerDataModelFactory.withExtras(result.data);
                        tracker.loading = false;
                    });
            };
            var new_camera = function (camera) {
                var data = camera;
                var car_id = $scope.vm.car_id;
                if (car_id < 0) return;

                camera.loading = true;
                cameraDataFactory.newCamera(car_id, cameraDataModelFactory.withoutExtras(data))
                    .then(function (result) {
                        $scope.vm.camera = cameraDataModelFactory.withExtras(result.data);
                        camera.loading = false;
                    });
            };
            var new_sim = function (sim) {
                var data = sim;
                data.tracker_id = $scope.vm.tracker.id;

                sim.loading = true;
                simDataFactory.newSim(simDataModelFactory.withoutExtras(data))
                    .then(function (result) {
                        $scope.vm.sim = simDataModelFactory.withExtras(result.data);
                        sim.loading = false;
                    });
            };

            var update_tracker = function (tracker) {
                var data = tracker;
                var car_id = $scope.vm.car_id;
                if (car_id < 0) return;

                tracker.loading = true;
                trackerDataFactory.updateTracker(car_id, tracker.id, data)
                    .then(function (result) {
                        tracker.loading = false;
                    });
            };
            var update_camera = function (camera) {
                var data = camera;
                var car_id = $scope.vm.car_id;
                if (car_id < 0) return;

                camera.loading = true;
                cameraDataFactory.updateCamera(car_id, camera.id, data)
                    .then(function (result) {
                        camera.loading = false;
                    });
            };
            var update_sim = function (sim) {
                var data = sim;
                sim.loading = true;
                simDataFactory.updateSim(sim.id, data)
                    .then(function (result) {
                        sim.loading = false;
                    });
            };

            var order_tracker = function (tracker) {
                var data = $scope.vm.tracker.order;
                delete(data.supplier);
                $scope.vm.tracker.order.loading = true;
                partOrderDataFactory.orderTracker(tracker.id, data)
                    .then(function (result) {
                        tracker.order = partOrderDataModelFactory.withExtras(result.data);
                        $scope.vm.tracker.order.loading = false;
                    });
            };
            var order_camera = function (camera) {
                var data = $scope.vm.camera.order;
                $scope.vm.camera.order.loading = true;
                partOrderDataFactory.orderCamera(camera.id, data)
                    .then(function (result) {
                        console.log(result.data);
                        camera.order = partOrderDataModelFactory.withExtras(result.data);
                        $scope.vm.camera.order.loading = false;
                    });
            };
            var order_sim = function (sim) {
                var data = $scope.vm.sim.order;
                $scope.vm.sim.order.loading = true;
                partOrderDataFactory.orderSim(sim.id, data)
                    .then(function (result) {
                        console.log(result.data);
                        sim.order = partOrderDataModelFactory.withExtras(result.data);
                        $scope.vm.sim.order.loading = false;
                    });
            };

            var book_delivery = function (order, delivery_data) {
                delivery_data.loading = true;
                partDeliveryDataFactory.newDelivery(order.id, delivery_data)
                    .then(function (result) {
                        console.log(result.data);
                        order.delivery = partDeliveryDataModelFactory.withExtras(result.data);
                        delivery_data.loading = false;
                    });
            };

            var update_order = function (order_id, order) {
                order.loading = true;
                partOrderDataFactory.updateOrder(order_id, order)
                    .then(function (result) {
                        order.loading = false;
                    })
            };

            var update_delivery = function (delivery_id, delivery) {
                delivery.loading = true;
                partDeliveryDataFactory.updateDelivery(delivery_id, delivery)
                    .then(function (result) {
                        console.log(result.data);
                        delivery.loading = false;
                    })
        };

            var get_parts = function (car_id) {
                cameraDataFactory.getCamera(car_id)
                    .then(function (result) {
                        $scope.vm.camera = cameraDataModelFactory.withExtras(result.data);
                        return result.data.order;
                    });
                trackerDataFactory.getTracker(car_id)
                    .then(function (result) {
                        $scope.vm.tracker = trackerDataModelFactory.withExtras(result.data);
                        return $scope.vm.tracker.sim;
                    })
                    .then(function (sim) {
                        simDataFactory.getSim(sim.id)
                            .then(function (result) {
                                console.log(result);
                                $scope.vm.sim = simDataModelFactory.withExtras(result.data);
                            });
                    });

            };

            var load_suppliers = function () {
                partOrderDataFactory.getSuppliers()
                    .then(function (result) {
                        $scope.vm.suppliers = result.data;
                    })
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
                get_parts(id);
                load_suppliers();
            }
        };

        init();
        }]);