app.controller("SearchController",function($scope,$http,$stateParams,$location) {
    $scope.keyword = $stateParams.keyword;
    $scope.init = function() {
        $http.get(apiUrl + '/posts/' + $scope.keyword + '/search')
            .then(function(res) {
                if(res.data.status == 'ok') {
                    $scope.posts = res.data.data.posts;
                }
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
});