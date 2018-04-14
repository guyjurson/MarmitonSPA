var app = angular.module('MyApp', ['ngMaterial', 'ngMessages']);
var value ="";
app.config(['$mdIconProvider', function($mdIconProvider,$compile) {
        $mdIconProvider.icon('md-close', 'img/icons/ic_close_24px.svg', 24);
      }])
      .controller('testctrl', submit);

      var temp = 0;
function submit($compile,$scope,$timeout){
  temp=temp+1;
  data = "<button ng-click=\"bool0=!bool0\" ng-show=\"!bool0\">Plus"+temp+"</button><button ng-click=\"bool0=!bool0\" ng-hide=\"!bool0\">Moins"+temp+"</button>";
  document.getElementById("div-result").innerHTML=data;
  value = "test";
  $compile(document.getElementById("div-result"))($scope);


}



app.directive("w3TestDirective", function() {
    return {
        template : value
    };
});
