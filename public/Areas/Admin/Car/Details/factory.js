app.factory('detailsDataFactory', ['$http', function ($http) {

    var URL_BASE = '/api/admin/cars';
    var detailsDataFactory = {};

    detailsDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    detailsDataFactory.updateCar = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    detailsDataFactory.updateSelective = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/update/selective', data);
    };
    detailsDataFactory.getInvestors = function () {
        return $http.get('/api/admin/investors/all');
    };
    detailsDataFactory.getSuppliers = function () {
        return $http.get('/api/admin/suppliers/all');
    };
    return detailsDataFactory;

}]);
app.factory('detailsDataModelFactory', ['moment', function (moment) {
    var detailsDataModelFactory = {};

    detailsDataModelFactory.withExtras = function (car) {
        car.x_available_since = moment(car.available_since).toDate();
        car.x_first_reg_date = moment(car.first_reg_date).toDate();
        car.x_pco_expires_at = moment(car.pco_expires_at).toDate();
        car.x_warranty_exp_at = moment(car.warranty_exp_at).toDate();
        car.x_roadside_exp_at = moment(car.road_side_exp_at).toDate();
        car.x_road_tax_exp_at = moment(car.road_tax_exp_at).toDate();
        return car;
    };
    detailsDataModelFactory.removeExtras = function (car_data) {

        var car = _.cloneDeep(car_data);
        car.available_since = moment(car.x_available_since).format('YYYY-MM-DD');
        car.first_reg_date = moment(car.x_first_reg_date).format('YYYY-MM-DD');
        car.pco_expires_at = moment(car.x_pco_expires_at).format('YYYY-MM-DD');
        car.warranty_exp_at = moment(car.x_warranty_exp_at).format('YYYY-MM-DD');
        car.road_side_exp_at = moment(car.x_roadside_exp_at).format('YYYY-MM-DD');
        car.road_tax_exp_at = moment(car.x_road_tax_exp_at).format('YYYY-MM-DD');

        delete(car.x_available_since);
        delete(car.x_first_reg_date);
        delete(car.x_pco_expires_at);
        delete(car.x_warranty_exp_at);
        delete(car.x_roadside_exp_at);
        delete(car.x_road_tax_exp_at);

        return car;
    };
    return detailsDataModelFactory;

}]);

app.factory('overviewDataFactory', ['$http', function ($http) {

    var URL_BASE = '/api/admin/cars';
    var overviewDataFactory = {};

    overviewDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    overviewDataFactory.getOverview = function (id) {
        return $http.get(URL_BASE + '/' + id + '/overview');
    };
    return overviewDataFactory;

}]);
app.factory('overviewDataModelFactory', ['moment', function (moment) {
    var overviewDataModelFactory = {};

    overviewDataModelFactory.getNotifications = function (notis) {


        var displayed = [];
        var now = moment();

        var category = notis.danger;
        _.each(category, function (noti) {
            displayed.push({
                'title': noti.message.title,
                'class': 'danger',
                'message': noti.message.text,
                'days_left': moment(noti.date.date).diff(now)
            });
        });
        category = notis.warning;
        _.each(category, function (noti) {
            displayed.push({
                'title': noti.message.title,
                'class': 'warning',
                'message': noti.message.text,
                'days_left': moment(noti.date.date).diff(now)
            });
        });
        category = notis.info;
        _.each(category, function (noti) {
            displayed.push({
                'title': noti.message.title,
                'class': 'info',
                'message': noti.message.text,
                'days_left': moment(noti.date.date).diff(now)
            });
        });
        console.log(displayed);
        return displayed;
        //var regulars = notis.regular;
        //var displayed = [];
        //
        //var pco_exp_m = moment(regulars.pco_exp);
        //var contract_end_m = moment(regulars.contract_finish);
        //var mot_due_m = moment(regulars.mot_due);
        //var warranty_exp_m = moment(regulars.warranty_exp);
        //var roadside_exp_m = moment(regulars.roadside_exp);
        //var road_tax_due_m = moment(regulars.road_tax_due);
        //var now = moment();
        //
        //buildNotification(pco_exp_m,now,'PCO expiry: ','Please call DVLA to renew the licence. You will need your car details',displayed);
        //buildNotification(contract_end_m,now,'Current contract expiry: ','The car will be marked OFF ROAD then',displayed);
        //buildNotification(mot_due_m,now,'MOT due: ','Call your garage to book MOT checkup.',displayed);
        //buildNotification(warranty_exp_m,now,'Warranty expiry: ','No action required, this will disappear when warranty expires',displayed);
        //buildNotification(roadside_exp_m,now,'Road side assistance expiry: ','Please renew the agreement with the provider',displayed);
        //buildNotification(road_tax_due_m,now,'Road tax payment due: ','Please ensure timely payment and update the due date',displayed);
        //
        //return displayed;


    };

    overviewDataModelFactory.getHistories = function (histories) {
        return histories;
    };

    function buildNotification(due_date, start_date, title, message, collection) {
        if (due_date.diff(start_date, 'days') <= 30) {
            var noti = {
                'title': title + start_date.to(due_date),
                'class': getNotiClass(due_date.diff(start_date, 'days')),
                'message': message,
                'date': due_date.format('ddd, DD/MM/YYYY'),
                'days_left': due_date.diff(start_date, 'days')
            };
            collection.push(noti);
        }
    }

    function getNotiClass(days_left) {
        if (days_left < 7)
            return 'danger';
        else if (days_left < 15)
            return 'warning';
        else if (days_left < 31)
            return 'info';
        else
            return '';
    }


    return overviewDataModelFactory;
}]);

app.factory('contractDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/contracts';
    var contractDataFactory = {};

    contractDataFactory.getContracts = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    contractDataFactory.getContract = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    contractDataFactory.getContractDetails = function (id) {
        return $http.get(URL_BASE + '/' + id + '/detail');
    };
    /* DEPRECATED - No updates allowed. Contracts are immutable*/
    contractDataFactory.updateContract = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    contractDataFactory.startContract = function (id) {
        return $http.get(URL_BASE + '/' + id + '/action/start');
    };
    contractDataFactory.endContract = function (id) {
        return $http.get(URL_BASE + '/' + id + '/action/end');
    };

    contractDataFactory.newContract = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    contractDataFactory.deleteContract = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };
    contractDataFactory.getContractRevenueDetail = function (id) {
        return $http.get(URL_BASE + '/' + id + '/revenue/detail');
    };
    contractDataFactory.getRevenues = function (id) {
        return $http.get(URL_BASE + '/' + id + '/revenues');
    };

    return contractDataFactory;
}]);
app.factory('contractDataModelFactory', ['moment', function (moment) {

    var contractDataModelFactory = {};
    contractDataModelFactory.withExtras = function (contract) {
        contract.dt_start_date = moment(contract.start_date).toDate();
        contract.dt_end_date = moment(contract.end_date).toDate();

        if (contract.status == 1) {
            contract.x_status = {"key": "Ongoing", "value": 1}
        }
        else if (contract.status == 2) {
            contract.x_status = {"key": "Suspended", "value": 2}
        }
        else if (contract.status == 3) {
            contract.x_status = {"key": "Terminated", "value": 3}
        }
        else if (contract.status == 4) {
            contract.x_status = {"key": "Complete", "value": 4}
        }
        contract.hasStarted = contract.act_start_dt != null;
        contract.hasTerminatedEarly = false;
        if (contract.act_end_dt != null) {
            var act_end = moment(contract.act_end_dt);
            contract.hasTerminatedEarly = act_end.isBefore(contract.end_date);
        }

        return contract;
    };
    return contractDataModelFactory;

}]);

app.factory('ticketDataFactory', ['$http', function ($http) {

    var URL_BASE = '/api/admin/cars';
    var ticketDataFactory = {};

    ticketDataFactory.getTickets = function (car_id) {
        return $http.get(URL_BASE + '/' + car_id + '/tickets');
    };

    ticketDataFactory.getTicket = function (car_id, ticket_id) {
        return $http.get(URL_BASE + '/' + car_id + '/tickets' + ticket_id);
    };

    ticketDataFactory.newTicket = function (car_id, data) {
        return $http.post(URL_BASE + '/' + car_id + '/tickets', data);
    };
    ticketDataFactory.updateTicket = function (car_id, data) {
        return $http.put(URL_BASE + '/' + car_id + '/tickets/' + data.id, data);
    };

    ticketDataFactory.inferDriver = function (car_id, unix_date) {
        return $http.get('/api/admin/tickets/infer_driver/' + car_id + '/' + unix_date);
    };

    return ticketDataFactory;

}]);
app.factory('ticketDataModelFactory', ['moment', function (moment) {

    var ticketDataModelFactory = {};
    ticketDataModelFactory.withExtras = function (tickets) {
        return tickets;
    };

    return ticketDataModelFactory;
}]);

app.factory('driverDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/drivers';
    var driverDataFactory = {};

    driverDataFactory.getDrivers = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    driverDataFactory.getDriver = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    driverDataFactory.updateDriver = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    driverDataFactory.newDriver = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    driverDataFactory.deleteDriver = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    return driverDataFactory;
}]);
app.factory('driverDataModelFactory', ['moment', function (moment) {
    var driverDataModelFactory = {};
    driverDataModelFactory.withExtras = function (driver) {
        driver.dt_dob = moment(driver.dob).toDate();
    };
    return driverDataModelFactory;
}]);

app.factory('servicesDataFactory', ['$http', function ($http) {

    var URL_BASE = '/api/admin/cars';
    var servicesDataFactory = {};

    servicesDataFactory.getOrders = function (car_id) {
        return $http.get(URL_BASE + '/' + car_id + '/service_orders');
    };
    servicesDataFactory.newOrder = function (car_id, data) {
        return $http.post(URL_BASE + '/' + car_id + '/service_orders', data);
    };
    servicesDataFactory.updateOrder = function (data) {
        return $http.put(URL_BASE + '/' + data.car.id + '/service_orders/' + data.id, data);
    };

    return servicesDataFactory;

}]);
app.factory('servicesDataModelFactory', ['moment', function (moment) {

    var servicesDataModelFactory = {};
    servicesDataModelFactory.withExtras = function (orders) {
        return orders;
    };
    servicesDataModelFactory.withoutObjects = function (order) {
        order.car_id = order.car.id;
        order.supplier_id = order.supplier.id;
    };

    return servicesDataModelFactory;
}]);

app.factory('supplierDataFactory', ['$http', function ($http) {

    var URL_BASE = '/api/admin/suppliers';
    var supplierDataFactory = {};

    supplierDataFactory.getSuppliers = function () {
        return $http.get(URL_BASE + '/all');
    };

    supplierDataFactory.getSuppliersFor = function (type) {
        return $http.get(URL_BASE + '/for/' + type);
    };

    return supplierDataFactory;
}]);
app.factory('supplierDataModelFactory', ['moment', function (moment) {

    var supplierDataModelFactory = {};
    supplierDataModelFactory.onlyForType = function (orders, type) {
        var result = [];
        result = _.takeWhile(orders, function (order) {
            return order.type == type;
        });
        return result;
    };

    supplierDataModelFactory.onlyForTypes = function (orders, types) {
        var result = [];
        result = _.takeWhile(orders, function (order) {
            return _.includes(types, order.type);
        });
        return result;
    };
    return supplierDataModelFactory;
}]);

app.factory('deliveriesDataFactory', ['$http', function ($http) {

    var deliveriesDataFactory = {};
    var URL_BASE = '/api/admin/cars';

    deliveriesDataFactory.getDeliveries = function (car_id) {
        return $http.get(URL_BASE + '/' + car_id + '/deliveries');
    };

    deliveriesDataFactory.newDelivery = function (car_id, data) {
        return $http.post(URL_BASE + '/' + car_id + '/deliveries', data);
    };

    deliveriesDataFactory.updateDelivery = function (car_id, delivery_id, data) {
        return $http.put(URL_BASE + '/' + car_id + '/deliveries/' + delivery_id, data);
    };

    return deliveriesDataFactory;
}]);
app.factory('deliveriesDataModelFactory', ['moment', function (moment) {

    var deliveriesDataModelFactory = {};
    deliveriesDataModelFactory.withExtras = function (deliveries) {
        return deliveries;
    };
    deliveriesDataModelFactory.withoutExtras = function (delivery) {
        delete(delivery.car);
        return delivery;
    };
    return deliveriesDataModelFactory;

}]);

app.factory('accidentDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/cars';
    var accidentDataFactory = {};

    accidentDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    accidentDataFactory.getAccidents = function (car_id) {
        return $http.get(URL_BASE + '/' + car_id + '/accidents');
    };
    accidentDataFactory.newCarAccident = function (car_id, data) {
        return $http.post(URL_BASE + '/' + car_id + '/accidents', data);
    };
    accidentDataFactory.updateAccident = function (car_id, data) {
        return $http.put(URL_BASE + '/' + car_id + '/accidents/' + data.id, data);
    };

    return accidentDataFactory;

}]);
app.factory('accidentDataModelFactory', ['moment', function (moment) {
    var accidentDataModelFactory = {};
    accidentDataModelFactory.collectionWithExtras = function (accidents) {

        return _.each(accidents, function (accident) {
            accidentDataModelFactory.withExtras(accident);
        });
    };
    accidentDataModelFactory.withExtras = function (accident) {
        var m_date = moment(accident.incident_at);
        var year = m_date.year();
        var month = m_date.month();
        var date = m_date.date();
        var hour = m_date.hour();
        var minute = m_date.minute();
        accident.incident_at = moment([year, month, date, hour, minute]).toDate();
        accident.incident_time = moment([year, month, date, hour, minute]).toDate();
        accident.detailUrl = '/api/admin/cars/' + accident.car.id + '/accidents/' + accident.id;
        return accident;
    };
    accidentDataModelFactory.withoutExtras = function (accident) {
        accident.driver_id = accident.driver.id;

        var m_incident = moment(accident.incident_at);
        var m_time = moment(accident.incident_time);
        var year = m_incident.year();
        var month = m_incident.month();
        var date = m_incident.date();
        var hour = m_time.hour();
        var minute = m_time.minute();

        var final_date = moment([year, month, date, hour, minute]);
        console.log(final_date);

        accident.incident_at = final_date.toDate();
        delete(accident.driver);
        delete(accident.incident_open);
        delete(accident.isEdit);
        return accident;
    };
    return accidentDataModelFactory;
}]);
app.factory('cameraDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/cars';
    var cameraDataFactory = {};

    cameraDataFactory.getCamera = function (car_id) {
        return $http.get(URL_BASE + '/' + car_id + '/cameras');
    };
    cameraDataFactory.newCamera = function (car_id, data) {
        return $http.post(URL_BASE + '/' + car_id + '/cameras', data);
    };
    cameraDataFactory.updateCamera = function (car_id, camera_id, data) {
        return $http.put(URL_BASE + '/' + car_id + '/cameras/' + camera_id, data);
    };
    return cameraDataFactory;
}]);
app.factory('cameraDataModelFactory', function (moment, partOrderDataModelFactory, partDeliveryDataModelFactory) {
    var factory = {};
    factory.withoutExtras = function (camera) {
        camera.supplier_id = camera.supplier.id;
        var data = _.cloneDeep(camera);
        delete(data.supplier);
        return data;
    };

    factory.withExtras = function (camera) {
        camera.installed_at = moment(camera.installed_at).toDate();
        if (camera.order) {
            camera.order = partOrderDataModelFactory.withExtras(camera.order);
            camera.order.delivery = _.head(camera.order.deliveries);
            if (camera.order.delivery) {
                camera.order.delivery = partDeliveryDataModelFactory.withExtras(camera.order.delivery);
            }
        }
        return camera;
    };
    return factory;
});
app.factory('trackerDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/cars';
    var trackerDataFactory = {};

    trackerDataFactory.getTracker = function (car_id) {
        return $http.get(URL_BASE + '/' + car_id + '/trackers');
    };
    trackerDataFactory.newTracker = function (car_id, data) {
        return $http.post(URL_BASE + '/' + car_id + '/trackers', data);
    };
    trackerDataFactory.updateTracker = function (car_id, tracker_id, data) {
        return $http.put(URL_BASE + '/' + car_id + '/trackers/' + tracker_id, data);
    };
    return trackerDataFactory;
}]);
app.factory('trackerDataModelFactory', function (moment, partOrderDataModelFactory, partDeliveryDataModelFactory) {
    var factory = {};

    factory.withoutExtras = function (tracker) {
        tracker.supplier_id = tracker.supplier.id;
        var data = _.cloneDeep(tracker);
        delete(data.supplier);
        return data;
    };
    factory.withExtras = function (tracker) {
        tracker.installed_at = moment(tracker.installed_at).toDate();
        if (tracker.order) {
            tracker.order = partOrderDataModelFactory.withExtras(tracker.order);
            tracker.order.delivery = _.head(tracker.order.deliveries);
            if (tracker.order.delivery) {
                tracker.order.delivery = partDeliveryDataModelFactory.withExtras(tracker.order.delivery);
            }
        }
        if (tracker.sims) {
            tracker.sim = _.head(tracker.sims);
        }
        return tracker;
    };
    return factory;
});
app.factory('simDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/sims';
    var simDataFactory = {};

    simDataFactory.getSims = function () {
        return $http.get(URL_BASE);
    };
    simDataFactory.getSim = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    simDataFactory.newSim = function (data) {
        return $http.post(URL_BASE, data);
    };
    simDataFactory.updateSim = function (sim_id, data) {
        return $http.put(URL_BASE + '/' + sim_id, data);
    };
    return simDataFactory;
}]);
app.factory('simDataModelFactory', function (moment, partOrderDataModelFactory, partDeliveryDataModelFactory) {
    var factory = {};

    factory.withoutExtras = function (sim) {
        sim.supplier_id = sim.supplier.id;
        var data = _.cloneDeep(sim);
        delete(data.supplier);
        return data;
    };
    factory.withExtras = function (sim) {
        if (sim.order) {
            sim.order = partOrderDataModelFactory.withExtras(sim.order);
            sim.order.delivery = _.head(sim.order.deliveries);
            if (sim.order.delivery) {
                sim.order.delivery = partDeliveryDataModelFactory.withExtras(sim.order.delivery);
            }
        }
        return sim;
    };
    return factory;
});
app.factory('partOrderDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/part_orders';
    var partOrderDataFactory = {};

    partOrderDataFactory.getDeliveries = function (id) {
        return $http.get(URL_BASE + '/' + id + '/deliveries');
    };
    partOrderDataFactory.getSuppliers = function () {
        return $http.get('/api/admin/suppliers/all');
    };
    partOrderDataFactory.orderCamera = function (id, data) {
        return $http.post(URL_BASE + '/camera/' + id, data);
    };
    partOrderDataFactory.orderTracker = function (id, data) {
        return $http.post(URL_BASE + '/tracker/' + id, data);
    };
    partOrderDataFactory.orderSim = function (id, data) {
        return $http.post(URL_BASE + '/sim/' + id, data);
    };

    partOrderDataFactory.updateOrder = function (id, data) {
        return $http.put(URL_BASE + '/' + id, data);
    };


    return partOrderDataFactory;
}]);
app.factory('partOrderDataModelFactory', function (moment) {
    var factory = {};
    factory.withExtras = function (order) {
        order.cost = _.toNumber(order.cost);
        return order;
    };
    return factory;
});

app.factory('partDeliveryDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/part_deliveries';
    var partDeliveryDataFactory = {};

    partDeliveryDataFactory.newDelivery = function (order_id, data) {
        return $http.post(URL_BASE + '/' + order_id, data);
    };
    partDeliveryDataFactory.updateDelivery = function (id, data) {
        return $http.put(URL_BASE + '/' + id, data);
    };

    return partDeliveryDataFactory;
}]);
app.factory('partDeliveryDataModelFactory', function (moment) {

    var factory = {};
    factory.withExtras = function (delivery) {
        delivery.scheduled_at = moment(delivery.scheduled_at).toDate();
        delivery.delivered_at = moment(delivery.delivered_at).toDate();
        return delivery;
    };
    return factory;
});
