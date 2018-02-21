app.controller("UserController",function($scope, $http) {
    $scope.init = function() {
        $http.get(apiUrl + '/users')
            .then(function(res) {
                $scope.users = res.data.data.users;
                $scope.viewby = 10;
                $scope.totalItems = $scope.users.length;
                $scope.currentPage = 1;
                $scope.itemsPerPage = $scope.viewby;
                $scope.maxSize = 3; //Number of pager buttons to show
                $scope.setPage = function (pageNo) {
                    $scope.currentPage = pageNo;
                };
            });
        $scope.user = {};
    }
});