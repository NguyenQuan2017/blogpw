app.controller("HomeController", function ($scope,$http,$location,$stateParams) {
    $scope.init = function () {
        $http.get(apiUrl + '/posts')
            .then(function (res) {
                $scope.posts = res.data.data.posts;
            });
        
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
    $scope.limit= 4;
    $scope.loadMore = function(post) {
        $scope.limit = $scope.limit + 4;
    }


});