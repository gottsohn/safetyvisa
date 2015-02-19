angular.module('safetyvisa.controllers', []);
angular.module('safetyvisa.services', [])
window.SafetyVisa = angular.module('SafetyVisa',
 ['ui.router',
  'ngAnimate',
  'ngMaterial',
  'safetyvisa.services',
  'safetyvisa.controllers'
]);

SafetyVisa.run(['$rootScope', function($rootScope) {

}]);

SafetyVisa.config(['$stateProvider','$locationProvider',
 function($stateProvider, $locationProvider) {


  $locationProvider.html5Mode(true);
  $stateProvider
    .state('default', {
      url: '/home',
      templateUrl: 'public/views/home.html',
      controller: 'HomeCtrl'
    });
}]);
angular.module('safetyvisa.services')
.factory('Http', ['$rootScope','$http', function($rootScope, $http){
  return {
    get: function (route, cb){
      var req = $http.get(PTH + route);
      if(_.isFunction(cb))
        req.success(function(res){
          cb(null, res);
        });
        req.error(function(err) {
          cb(err, null);
        });
    }
  };
}]);

angular.module('safetyvisa.controllers')
.controller('HomeCtrl', ['$scope', 'Http', '$timeout', function($scope, Http, $timeout) {
  $scope.init = function(){
    Http.get('categories',function(err, res) {
      if(!err) {
        $timeout(function(){
          $scope.categories = res;
        });

      }
      else {
        alert(err);
      }
    });
  };
  $scope.init();
}]);