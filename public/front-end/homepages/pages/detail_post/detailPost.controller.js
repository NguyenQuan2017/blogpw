app.controller("DetailPostController",['$scope','$http','$stateParams',function ($scope,$http,$stateParams) {
    $scope.postId = $stateParams.postId;
    $scope.init = function () {

        if($scope.postId) {
            $http.get(apiUrl + '/posts/'+ $scope.postId + '/detail')
                .then(function(res) {
                    $scope.posts = res.data.data.posts;
                })
        }
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://bestcmsever.disqus.com/embed.js';
            s.setAttribute('data-timestamp', + new Date());
            (d.head || d.body).appendChild(s);
        })();
    };

}]);