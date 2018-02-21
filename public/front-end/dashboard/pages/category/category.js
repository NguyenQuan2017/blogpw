app.controller("CategoryController", function ($scope, $http) {

    $scope.cates = {};
    $scope.categories = {};
    $scope.add = function () {
        $scope.cates = {
            category : '',
            description : ''
        };
    };
    $scope.init = function (){
        $http.get(apiUrl + '/categories')
            .then(function(res) {
                $scope.categories = res.data.data.categories;
            })
    };

    $scope.edit = function (cate) {
        $scope.cates = {
            id : cate.id,
            category : cate.category,
            description : cate.description,
            created_at : cate.created_at
        }
    };

    $scope.save = function (cate) {
        var data = {category:cate.category,description:cate.description};
        if(cate.id) {
            $http.put(apiUrl + '/categories/' + cate.id,data)
                .then(function(res) {
                    if(res.data.status = 'ok') {
                        $scope.categories.push(cate);
                        $scope.init();
                    }
                })
        }
        else {
            $http.post(apiUrl + '/categories',data)
                .then(function (res) {
                    if(res.data.status = 'ok') {
                        $scope.categories.push(cate);
                        $scope.init();
                        $scope.cates = {};
                    }
                })
        }
    };

    $scope.delete = function (cate) {
        if(cate.id) {
            $http.delete(apiUrl + '/categories/' + cate.id)
                .then(function(res) {
                    if(res.data.status == 'ok') {
                        $scope.init();
                    }
                });

        }
    }
});