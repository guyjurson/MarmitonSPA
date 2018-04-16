app.config(['$mdIconProvider', function ($mdIconProvider, $compile) {
    $mdIconProvider.icon('md-close', 'img/icons/ic_close_24px.svg', 24);
}])

    .config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.timeout = 20000;
    }])

    .filter('trusted', ['$sce', function ($sce) {
        return function (text) {
            return $sce.trustAsHtml(text);
        };
    }])

    .controller('testCtrl', function ($http, $scope, $timeout) {
        $scope.tags = [];
        $scope.submit = function () {
            $Vdata = {};
            for (var j = 0; j < $scope.tags.length; j++) {
                $Vdata["ing" + j] = $scope.tags[j];
            }

            $http({
                method: 'POST',
                url: "http://127.0.0.1:8888/API/SPA.php",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                transformRequest: function (obj) {
                    var str = [];
                    for (var p in obj)
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    return str.join("&");
                },
                data: $Vdata
            }).then(function (response) {
                $scope.recettes = response.data;
            })
                .catch(console.error);
        };
    })
    .directive('displayR', function () {
        return {
            restrict: 'E',
            templateUrl: 'template.html',
            scope: {
                recette: "=",
                action: "="
            },
            link: function (scope, element, attributes) {
                scope.bool = false;
                scope.showHide = function showHide() {
                    scope.bool = !scope.bool;
                };
            }
        };
    })

    .config(['$mdIconProvider', function ($mdIconProvider) {
        $mdIconProvider.icon('md-toggle-arrow', 'img/icons/toggle-arrow.svg', 48);
    }]);

