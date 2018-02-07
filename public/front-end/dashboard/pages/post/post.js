app.controller("PostController", function($scope,$http,$window,$timeout) {
    $scope.post = {};
    $scope.cate = [];
    $scope.category = [];
    $scope.tag = [];
   $scope.init = function () {
       $http.get(apiUrl + '/posts')
           .then(function(res) {
               $scope.posts = res.data.data.posts;
               $scope.categories = res.data.data.categories;
               $scope.tags = res.data.data.tags;
           });
   };

    $scope.add = function () {
        $scope.image = true;
        $scope.category = [];
        $scope.tag = [];
        $scope.post = {
            title :'',
            content : ''
        };
        var $el = $('#image');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap();

    };

    $scope.edit = function (posts) {
        $http.get(apiUrl + '/posts/' + posts.id + '/categories')
            .then(function(res) {
                if(res.data.status == 'ok') {
                    $scope.category = res.data.data.posts.categories;
                    $scope.tag = res.data.data.posts.tags;
                    // console.log($scope.category);
                }
            });
        $scope.post = {
            id : posts.id,
            title : posts.title,
            content: posts.content,
            image : posts.image
        };
        $scope.image = false;
        var $el = $('#image');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap();
        $window.scrollTo(0, 0);
    };
      
    $scope.save = function (posts,cate,tag) {

        $scope.title = posts.title;
        $scope.content = posts.content;
        $scope.image = posts.image;
        $scope.cate = cate;
        $scope.tag = tag;
        if(posts.id) {
            var data = {title:$scope.title,content:$scope.content,image : $scope.image,cate: $scope.cate,tag: $scope.tag};
            $http.put(apiUrl + '/posts/' + posts.id, data)
                .then(function(res) {
                    if(res.data.status == 'ok') {
                        // $scope.posts.push(posts);
                        $scope.init();
                        $scope.add();
                    }
                })
        }else {
            var data1 = {title:$scope.title,content:$scope.content,image : $scope.image,cate: $scope.cate,tag: $scope.tag};
            $http.post(apiUrl + '/posts',data1)
                .then(function(res) {
                    if(res.data.status == 'ok') {
                        // $scope.posts.push(posts);
                        $scope.init();
                        $scope.add();
                    }
                })
        }
    };


    $scope.delete = function(post) {
        $http.delete(apiUrl + '/posts/' + post.id)
            .then(function(res) {
                if(res.data.status == 'ok') {
                   $scope.init();
                }
            })
    };
    $scope.tinymceOptions = {
        onChange: function(e) {
            // put logic here for keypress and cut/paste changes
        },
        inline: false,
        plugins : 'advlist autolink link image lists charmap print preview',
        skin: 'lightgray',
        theme : 'modern'
    };
});
