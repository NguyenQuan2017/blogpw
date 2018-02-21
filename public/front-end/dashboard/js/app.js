
// apiUrl = 'http://blogpw.localhost/api/dashboard';
apiUrl = 'http://192.168.1.76:9000/api/dashboard';
var app = angular.module("BlogApp",['ui.router','angular-jwt','multipleSelect','appFilereader','ui.tinymce','ui.bootstrap'])
    .run(function ($rootScope,$state,jwtHelper,$http) {
        $http.get(apiUrl + '/user')
            .then(function(res) {
                $rootScope.user = res.data.data.user;

            });
        $rootScope.logout = function () {
            localStorage.removeItem('token');
            location.reload();
        };
        // ===== Scroll to Top ====
        $(window).scroll(function() {
            if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                $('#return-to-top').fadeIn(200);    // Fade in the arrow
            } else {
                $('#return-to-top').fadeOut(200);   // Else fade out the arrow
            }
        });
        $('#return-to-top').click(function() {      // When arrow is clicked
            $('body,html').animate({
                scrollTop : 0                       // Scroll to top of body
            }, 500);
        });
    })
    .config(['$stateProvider', '$urlRouterProvider','$httpProvider','$locationProvider', function ($stateProvider, $urlRouterProvider,$httpProvider,$locationProvider) {

        $stateProvider
            .state({
                name: 'login',
                url : '/login',
                templateUrl : '/front-end/dashboard/pages/login/login.html'
            })
            .state ({
                name : 'dashboard',
                url : '/',
                templateUrl : '/front-end/dashboard/pages/dashboard.html'
            })
            .state ({
                name: 'categories',
                url: '/categories',
                templateUrl : '/front-end/dashboard/pages/category/category.html'
            })
            .state({
                name : 'posts',
                url : '/posts',
                templateUrl : '/front-end/dashboard/pages/post/post.html'
            })
            .state({
                name : 'tags',
                url : '/tags',
                templateUrl : '/front-end/dashboard/pages/tag/tag.html'
            })
            .state({
                name : 'users',
                url : '/users',
                templateUrl : '/front-end/dashboard/pages/user/user.html'
            });

        // $urlRouterProvider.otherwise('/');
        $httpProvider.defaults.headers.common = {
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
        };
        $locationProvider.hashPrefix('');

        $httpProvider.interceptors.push(function($q, $rootScope, $state) {
            var xhrCreations = 0;
            var xhrResolutions = 0;

            function isLoading() {
                return xhrResolutions < xhrCreations;
            }

            function updateStatus() {
                $rootScope.loading = isLoading() && ($state.current.name != 'index');
            }

            return {
                'request': function(config) {
                    xhrCreations++;
                    updateStatus();
                    return config;
                },
                requestError: function(rejection) {
                    xhrResolutions++;
                    updateStatus();
                    return $q.reject(rejection);
                },
                'response': function(response) {
                    xhrResolutions++;
                    updateStatus();
                    return response;
                },
                'responseError': function(rejection) {
                    xhrResolutions++;
                    updateStatus();
                    if (rejection.status === 401) {
                        $state.go('login');
                    } else if (rejection.status === 403) {
                        // alert('You don\'t have permission to see this resource');
                    } else if (rejection.status === 500) {

                    }
                    return $q.reject(rejection);
                }
            };
        });

    }]);