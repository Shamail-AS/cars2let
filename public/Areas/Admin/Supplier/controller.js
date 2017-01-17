app.controller('supplierController',
    [
        '$scope',
        'supplierDataFactory',
        'supplierDataModelFactory',
        function ($scope, supplierDataFactory, supplierDataModelFactory) {

            //Objects
            $scope.vm = {
                'suppliers': [],
                'loading': true
            };
            $scope.filters = {
                'search': ''
            };
            $scope.dateOptions = {
                dateDisabled: false,
                formatYear: 'yyyy',
                startingDay: 1
            };
            $scope.openPicker = function (supplier) {
                supplier.picker_open = true;
            };

            //Public methods
            $scope.getSuppliers = function () {
                get_suppliers();
            };

            $scope.formatDate = function (date) {
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };
            $scope.editsupplier = function (supplier) {
                console.log(supplier);
                supplier.edit_mode = true
            };
            $scope.cancelEdit = function (supplier) {
                supplier.edit_mode = false;
            };
            $scope.updatesupplier = function (supplier) {
                update_supplier(supplier);
            };

            //Private methods
            var get_suppliers = function () {
                $scope.vm.loading = true;
                supplierDataFactory.getSuppliers()
                    .success(function (data) {
                        $scope.vm.suppliers = supplierDataModelFactory.withExtras(data);
                        console.log($scope.vm.suppliers);
                        $scope.vm.loading = false;
                    });
            };

            var update_supplier = function (supplier) {
                console.log(supplier);
                supplierDataFactory.updateSupplier(supplier.id, supplier)
                    .success(function (result) {
                        alert(result);
                        supplier.edit_mode = false;
                    });
            };


            var init = function () {
                get_suppliers();
            };

            init();
        }]);
