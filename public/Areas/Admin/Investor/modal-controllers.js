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


app.controller('contractFilterModalController',
    ['$scope', 'close',
        function ($scope, close) {

            $scope.close = function (result) {
                close(result, 500); // close, but give 500ms for bootstrap to animate
            };
            $scope.dirty = {};
            $scope.vm = {
                statuses: ['suspended', 'ongoing', 'terminated', 'complete']
            };
            $scope.reset = function () {
                delete($scope.filters.contract);
            }

        }]);

app.controller('contractPaymentsModalController',
    ['$scope', 'paymentDataFactory', 'data', 'close',
        function ($scope, paymentDataFactory, data, close) {

            $scope.close = function (result) {
                close(result, 500); // close, but give 500ms for bootstrap to animate
            };

            $scope.dirty = {};
            $scope.vm = {
                contract: data
            };
            $scope.formatDate = function (date) {
                if (!date) return "-";
                return format_date(date);
            };

            $scope.pay = function () {
                var data = {
                    _token: $scope.dirty.token,
                    contract_id: $scope.vm.contract.id,
                    amount: $scope.dirty.amount,
                    value_dt: $scope.dirty.value_dt,
                    comments: $scope.dirty.comments
                };
                paymentDataFactory.newPayment(data)
                    .then(function (resp) {
                        console.log(resp.data);
                        $scope.vm.contract.payments.push(resp.data);
                    });
            };

            var format_date = function (date) {
                var dt = moment(date);
                return dt.format("MMM DD, YYYY");
            };

            var get_payments = function (contract_id) {
                paymentDataFactory.getPayments(contract_id)
                    .then(function (resp) {
                        $scope.vm.contract.payments = resp.data;
                    })
            };

            var init = function () {
                get_payments($scope.vm.contract.id);
            };

            init();
        }]);

app.controller('contractHandoverModalController',
    ['$scope', 'data', 'close',
        function ($scope, data, close) {

            $scope.close = function (result) {
                close(result, 500); // close, but give 500ms for bootstrap to animate
            };

            $scope.dirty = {};

        }]);