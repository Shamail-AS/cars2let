app.controller('revenueModalController',
    function ($scope, $element, $log, data, moment, contractDataFactory, revenueDataFactory, close) {

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
        $scope.allocated = function () {
            var allocated = 0;
            if (!$scope.loading && $scope.vm.revenues) {
                allocated = _.sumBy($scope.vm.revenues, function (rev) {
                    return parseFloat(rev.amount_received || 0);
                });
            }
            return parseFloat(allocated);
        };
        $scope.unallocated = function () {
            return $scope.vm.contract.total_payments - $scope.vm.contract.rec_deposit - $scope.allocated();
        };
        $scope.grossBalance = function () {
            var balance = $scope.vm.contract.rec_deposit - $scope.vm.contract.req_deposit;
            if (!$scope.loading && $scope.vm.revenues) {
                balance += _.sumBy($scope.vm.revenues, function (rev) {
                    return parseFloat((rev.amount_received || 0) - (rev.amount_due || 0));
                });
            }
            return parseFloat(balance);
        };

        $scope.canSave = function () {
            return $scope.unallocated() >= 0;
        };
        $scope.save = function () {
            update_revenues();
            update_contract_deposit();
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
            return _.each(revenues, function (rev) {
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

        };

        var update_revenues = function () {
            $scope.vm.loading = true;
            var allocations = $scope.vm.revenues;
            revenueDataFactory.updateAllocations(allocations)
                .then(function (result) {
                    console.log(result);
                }, function (error) {
                    alert(error)
                }).finally(function () {
                $scope.vm.loading = false;
            });
        };

        var update_contract_deposit = function () {
            var data = {
                id: $scope.vm.contract.id,
                rec_deposit: $scope.vm.contract.rec_deposit,
                req_deposit: $scope.vm.contract.req_deposit
            };
            $scope.vm.loading = true;
            contractDataFactory.updateContract(data.id, data)
                .then(function (result) {
                    console.log(result);
                }, function (error) {
                    alert(error);
                }).finally(function () {
                $scope.vm.loading = false;
                $element.modal('hide');
                $scope.close('Saved');
            });

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
                var new_payments = _.filter($scope.vm.contract.payments, ['isNew', true]);
                //send back new payments to append to the contract's payment collection
                // send back empty collection is new_payments is null or undefined
                close(new_payments || [], 500); // close, but give 500ms for bootstrap to animate
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
                        resp.data.isNew = true;
                        $scope.close(resp.data);
                        //$scope.vm.contract.payments.push(resp.data);
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