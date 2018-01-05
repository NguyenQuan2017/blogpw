var app = angular.module("BlogApp",['ui.router'])
    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/');
        $stateProvider
            .state({
                name: '/',
                url : '/',
                templateUrl : '/front-end/index.html'
            })
    }]);
app.controller("HomeController", function ($scope) {
    $scope.init = function () {
        $('.carousel').carousel({
            interval: 2000
        })
    }
});