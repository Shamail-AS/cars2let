app.controller('userController',
    [
        '$scope',
        'userDataFactory',
        'userDataModelFactory',
        function ($scope, userDataFactory, userDataModelFactory) {

            //Objects
            $scope.vm = {
                'users': [],
                'statuses': [],
                'access_levels': [],
                'types': []
            };
            $scope.filters = {
                'user': ''
            };
            $scope.dirty = {
                'user': {}
            };

            //Public methods
            $scope.getUsers = function () {
                get_users();
            };
            $scope.editUser = function (user) {
                user.edit_mode = true;
            };
            $scope.cancelEdit = function (user) {
                user.edit_mode = false;
            };
            $scope.updateUser = function (user) {
                update_user(user);
            };
            $scope.resetPassword = function (user) {
                user.status = 'new';
                reset_user_pass(user);
            };

            $scope.formatDate = function (date) {
                var dt = moment(date);
                return dt.format("DD, MMM YYYY");
            };

            //Private methods
            var get_users = function () {
                userDataFactory.getUsers()
                    .success(function (data) {
                        $scope.vm.users = userDataModelFactory.withEditMode(data);
                    });
            };
            var update_user = function (user) {
                userDataFactory.putUser(user.id, user)
                    .success(function (result) {
                        alert(result);
                        user.edit_mode = false;
                    });
            };
            var reset_user_pass = function (user) {
                userDataFactory.resetPassword(user.id)
                    .success(function (data) {
                        alert(data);
                    });
            };

            var add_types = function () {
                $scope.vm.types.push("admin");
                $scope.vm.types.push("super-admin");
            };

            var add_statuses = function () {
                $scope.vm.statuses.push("active");
                $scope.vm.statuses.push("new");
                $scope.vm.statuses.push("disabled");
            };

            var add_access_levels = function () {
                $scope.vm.access_levels.push("read");
                $scope.vm.access_levels.push("edit");
                $scope.vm.access_levels.push("full");
            };


            var init = function () {
                get_users();
                add_types();
                add_statuses();
                add_access_levels();
            };

            init();
        }]);