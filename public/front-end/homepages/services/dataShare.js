angular.module("ShareData",[]).factory('shareData',function($rootScope){
    var service = {};
    service.data = false;
    service.sendData = function(data){
        this.data = data;
        $rootScope.$broadcast('data_shared');
    };
    service.getData = function(){
        return this.data;
    };
    return service;
});