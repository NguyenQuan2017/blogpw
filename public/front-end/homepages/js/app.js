
    apiUrl = 'http://192.168.1.76:9000/api/homepages';
var app = angular.module("BlogApp",['ui.router','ngSanitize','ngDisqus','ui.bootstrap'])
    .run([function($scope) {
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
    }])
    .config(['$stateProvider', '$urlRouterProvider','$locationProvider', function ($stateProvider, $urlRouterProvider,$locationProvider) {

        $stateProvider
            .state({
                name: 'home',
                url : '/',
                templateUrl : '/front-end/homepages/pages/home/home.html'
            })
            .state ({
                name: 'postDetail',
                url: '/post/:postId',
                templateUrl : '/front-end/homepages/pages/detail_post/detail-post.html'
            })
            .state({
                name: 'search',
                url: '/:paramSearch/:keyword',
                templateUrl : '/front-end/homepages/pages/search/search.html'
            });

        $urlRouterProvider.otherwise('/');
        $locationProvider.hashPrefix('');
    }]);
    app.filter('removeHTMLTags', function() {
        return function(text) {
            return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
        };
    });


