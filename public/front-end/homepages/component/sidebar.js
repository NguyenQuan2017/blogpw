app.controller("SideBarController",function($scope,$http,$location) {
    $scope.init = function() {
        $http.get(apiUrl + '/category')
            .then(function (res) {
                $scope.categories = res.data.data.categories;
            });

        $http.get(apiUrl + '/posts/popular')
            .then(function(res) {
                if(res.data.status == 'ok') {
                    $scope.popular = res.data.data.popular;
                }
            });
        $http.get(apiUrl + '/posts/recent')
            .then(function(res) {
                if(res.data.status == 'ok') {
                    $scope.recent = res.data.data.recent;
                }
            });
        $http.get(apiUrl + '/tags')
            .then(function(res) {
                $scope.tags = res.data.data.tags;
            })

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

    $scope.detailPost = function(post) {
        if(post.id) {
            $location.path('/post/' + post.id);
        }
    };

    $scope.searchCate = function(cate) {
        $scope.categories = 'categories';
        $location.path('/' + $scope.categories + '/' + cate.category);
    };

    $scope.searchTag = function(tag) {
        $scope.tags = 'tags';
        $location.path('/' + $scope.tags + '/' + tag.tag);
    }

});