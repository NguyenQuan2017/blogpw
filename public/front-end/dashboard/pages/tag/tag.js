app.controller("TagController",function($scope,$http) {
   $scope.tag = {};
    $scope.init = function() {
        $http.get(apiUrl + '/tags')
            .then(function(res) {
                $scope.tags = res.data.data.tags;
            })
    };

    $scope.add = function () {
        $scope.tag = {
            tag : ''
        }
    };
    $scope.edit = function (tag) {
        $scope.tag = {
            id : tag.id,
            tag : tag.tag
        }
    };

    $scope.save = function (tag) {
        var data = {tag:tag.tag};
        if(tag.id) {
            $http.put(apiUrl + '/tags/' + tag.id,data)
                .then(function(res) {
                    if(res.data.status == 'ok') {
                        $scope.init();
                    }
                })
        }else {
            $http.post(apiUrl + '/tags',data)
                .then(function(res) {
                    if(res.data.status == 'ok') {
                        $scope.init();
                    }
                });
        }
    };

    $scope.delete = function (tag) {
        if(tag.id) {
            $http.delete(apiUrl + '/tags/' + tag.id,tag)
                .then(function(res) {
                    if(res.data.status == 'ok') {
                        $scope.init();
                    }
                })
        }
    }
});