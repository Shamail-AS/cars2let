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