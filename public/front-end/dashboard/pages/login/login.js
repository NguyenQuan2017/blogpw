app.controller("LoginController",['$scope','$http','$state', function ($scope,$http, $state) {
    $scope.init = function () {
        $http.get(apiUrl + '/check-token')
            .then(function(res) {
                if(res.data.status == 'ok') {
                    $state.go('dashboard');
                }
            });
        $http.post(apiUrl + '/ip')
            .then(function(res) {
                $scope.histories = res.data.data.histories;
            })
    };
    
    $scope.login = function () {
        $http.post(apiUrl + '/login',$scope.user)
            .then(function (res) {
                if(res.data.status == 'ok') {
                    localStorage.setItem('token',res.data.data.token);
                    location.reload();
                }else {
                    alert('login failed');
                }
            });
    }
}]);