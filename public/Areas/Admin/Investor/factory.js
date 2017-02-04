app.factory('investorDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/investors';
    var investorDataFactory = {};

    investorDataFactory.getInvestors = function () {
        return $http.get(URL_BASE + '/all');
    };
    investorDataFactory.getInvestor = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    investorDataFactory.getCars = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'cars');
    };
    investorDataFactory.getDrivers = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'drivers');
    };
    investorDataFactory.getContracts = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'contracts');
    };
    investorDataFactory.getRevenues = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'revenues');
    };

    investorDataFactory.updateInvestor = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };

    return investorDataFactory;
}]);
app.factory('investorDataModelFactory', ['moment', 'contractDataModelFactory', 'carDataModelFactory', 'driverDataModelFactory', function (moment, contractDataModelFactory, carDataModelFactory, driverDataModelFactory) {

    var investorDataModelFactory = {};

    investorDataModelFactory.withExtras = function (investor) {
        investor.dt_dob = moment(investor.dob).toDate();
        investor.dt_acc_period_start = moment(investor.acc_period_start).toDate();
        investor.dt_acc_period_end = moment(investor.acc_period_end).toDate();
        return investor;
    };
    investorDataModelFactory.withDriverExtras = function (drivers) {
        _.each(drivers, function (driver) {
            if(!driver) return;
            driverDataModelFactory.withExtras(driver);
        });
        return drivers;
    };
    investorDataModelFactory.withContractExtras = function (contracts) {
        _.each(contracts, function (contract) {
            contractDataModelFactory.withExtras(contract);
        });
        return contracts;
    };
    investorDataModelFactory.withCarExtras = function (cars) {
        _.each(cars, function (car) {
            carDataModelFactory.withExtras(car);
        });
        return cars;
    };

    return investorDataModelFactory;
}]);

app.factory('carDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/cars';
    var carDataFactory = {};

    carDataFactory.getCars = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    carDataFactory.getCar = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    carDataFactory.updateCar = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    carDataFactory.newCar = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    carDataFactory.deleteCar = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    return carDataFactory;
}]);
app.factory('carDataModelFactory', ['moment', function (moment) {
    var carDataModelFactory = {};
    carDataModelFactory.withExtras = function (car) {
        car.dt_available_since = moment(car.available_since).toDate();
        return car;
    };
    return carDataModelFactory;
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
        contract.loading = false;
        contract.canStart = moment().diff(contract.start_date) >= 0;
        contract.low_deposit = contract.rec_deposit < contract.req_deposit;
        contract.outHandover = _.find(contract.handovers || [], function (handover) {
            return handover.type.includes('outgoing');
        });
        contract.inHandover = _.find(contract.handovers || [], function (handover) {
            return handover.type.includes('incoming');
        });
        contract.handoverCreateUrl = '/api/admin/contracts/' + contract.id + '/handovers/create';
        if (contract.outHandover) contract.outUrl = '/api/admin/contracts/' + contract.id + '/handovers/' + contract.outHandover.id;
        if (contract.inHandover) contract.inUrl = '/api/admin/contracts/' + contract.id + '/handovers/' + contract.inHandover.id;

        contract.total_payments = _.sumBy(contract.payments, function (payment) {
            return parseFloat(payment.amount);
        });
        return contract;
    };

    contractDataModelFactory.withoutExtras = function (contract) {
        contract.status = contract.x_status.value;
        contract.start_date = moment(contract.dt_start_date).format("YYYY-MM-DD");
        contract.end_date = moment(contract.dt_end_date).format("YYYY-MM-DD");
        //delete(contract.x_status);
        //delete(contract.dt_start_date);
        //delete(contract.dt_end_date);
        //delete(contract.hasStarted);
        //delete(contract.canStart);
        //delete(contract.hasTerminatedEarly);
        //delete(contract.loading);

        return contract;
    };
    return contractDataModelFactory;

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
    driverDataModelFactory.withoutExtras = function (driver) {
        delete(driver.dt_dob);
        delete(driver.edit_mode);
        delete(driver.picker_open);
        return driver;
    };
    driverDataModelFactory.withExtras = function (drivers) {
        _.each(drivers, function (driver) {
            if(driver){
                driver.edit_mode = false;
                driver.picker_open = false;
                driver.dt_dob = moment(driver.dob).toDate();
            }
        });
        return drivers;
    };
    return driverDataModelFactory;
}]);

app.factory('policyDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/policies';
    var policyDataFactory = {};

    policyDataFactory.getPolicies = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    policyDataFactory.getPolicy = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    policyDataFactory.updatePolicy = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    policyDataFactory.newPolicy = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    policyDataFactory.deletePolicy = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    return policyDataFactory;
}]);
app.factory('policyDataModelFactory', ['moment', function (moment) {
    var policyDataModelFactory = {};
    policyDataModelFactory.withExtras = function (policy) {
        policy.policy_start = moment(policy.policy_start).toDate();
        policy.policy_end = moment(policy.policy_end).toDate();
        
    };
    policyDataModelFactory.withoutExtras = function (policy) {
        delete(policy.policy_start);
        delete(policy.policy_end);

        delete(policy.edit_mode);
        delete(policy.picker_open);
        return policy;
    };
    policyDataModelFactory.withExtras = function (policies) {
        _.each(policies, function (policy) {
            policy.edit_mode = false;
            policy.picker_open = false;
        });
        return policies;
    };
    return policyDataModelFactory;
}]);

app.factory('supplierDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/suppliers';
    var supplierDataFactory = {};

    supplierDataFactory.getSuppliers = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    supplierDataFactory.getSupplier = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    supplierDataFactory.updateSupplier = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    supplierDataFactory.newSupplier = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    supplierDataFactory.deleteSupplier = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    return supplierDataFactory;
}]);
app.factory('supplierDataModelFactory', ['moment', function (moment) {
    var supplierDataModelFactory = {};
    supplierDataModelFactory.withExtras = function (supplier) {
        supplier.supplier_start = moment(supplier.supplier_start).toDate();
        supplier.supplier_end = moment(supplier.supplier_end).toDate();
        
    };
    supplierDataModelFactory.withoutExtras = function (supplier) {
        delete(supplier.supplier_start);
        delete(supplier.supplier_end);

        delete(supplier.edit_mode);
        delete(supplier.picker_open);
        return supplier;
    };
    supplierDataModelFactory.withExtras = function (suppliers) {
        _.each(suppliers, function (supplier) {
            supplier.edit_mode = false;
            supplier.picker_open = false;
        });
        return suppliers;
    };
    return supplierDataModelFactory;
}]);

app.factory('revenueDataFactory', ['$http', function ($http) {
    var URL_BASE = '/api/admin/revenues';
    var revenueDataFactory = {};

    revenueDataFactory.getRevenues = function () {
        return $http.get(URL_BASE + '/' + 'all');
    };
    revenueDataFactory.getRevenue = function (id) {
        return $http.get(URL_BASE + '/' + id);
    };
    revenueDataFactory.updateRevenue = function (id, data) {
        return $http.put(URL_BASE + '/' + id + '/' + 'update', data);
    };
    revenueDataFactory.newRevenue = function (data) {
        return $http.put(URL_BASE + '/' + 'post', data);
    };
    revenueDataFactory.deleteRvenue = function (id) {
        return $http.get(URL_BASE + '/' + id + '/' + 'delete');
    };

    revenueDataFactory.updateAllocations = function (allocations) {
        return $http.put(URL_BASE + '/update/allocations', allocations);
    };

    return revenueDataFactory;
}]);

app.factory('paymentDataFactory', [
    '$http',
    function ($http) {
        var URL_BASE = '/api/admin/payments';
        var paymentDataFactory = {};

        paymentDataFactory.getPayments = function (contract_id) {
            return $http.get(URL_BASE + '/contract/' + contract_id);
        };
        paymentDataFactory.newPayment = function (data) {
            return $http.post(URL_BASE + '/contract', data);
        };
        return paymentDataFactory;
    }
]);