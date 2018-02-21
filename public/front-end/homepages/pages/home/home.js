app.controller("HomeController", function ($scope,$http,$location,$stateParams,$window) {
    $scope.init = function () {
        $http.get(apiUrl + '/posts')
            .then(function (res) {
                $scope.posts = res.data.data.posts;
                $scope.viewby = 10;
                $scope.totalItems = $scope.posts.length;
                $scope.currentPage = 1;
                $scope.itemsPerPage = $scope.viewby;
                $scope.maxSize = 5; //Number of pager buttons to show
                $scope.setPage = function (pageNo) {
                    $scope.currentPage = pageNo;
                };
            });
    };
    $scope.scrollTop = function () {
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 300);
        $scope.limit = 4;
    };
    $scope.detailPost = function(post) {
        if(post.id) {
            $location.path('/post/' + post.id);
        }
    };
    $scope.counter = function(post) {
        $scope.counter = post.counter;
        if(post.id) {
            $http.post(apiUrl + '/posts/' + post.id + '/counter',{counter:$scope.counter})
                .then(function(res) {
                    if(res.data.status == 'ok') {
                        console.log(res.data.data.counter);
                    }
                })
        }
    };

    $scope.limit = 4;
    $scope.loadMore = function() {
        $scope.limit = $scope.limit + 4;
    }

});