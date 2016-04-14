app.controller("ProfileController", function ($scope, $http) {
    //$scope.profileResponce = null;
    var url ='/api/v1/lenders/'+$('#profile-id').val();
    var res = $http.get(url);
    res.success(function (data, status, headers, config) {
        $scope.profileResponce = data;
        $(".loading").hide();
    });
    res.error(function (data, status, headers, config) {
        console.log("failure message: " + JSON.stringify({data: data}));
    });
});

app.controller("HomeController", function ($scope, $http) {
    $scope.indexResponce = null;
    var res = $http.get('/api/v1/projects/featured-project/1.json');
    res.success(function (data, status, headers, config) {
        $scope.indexResponce = data;
        $(".loading").hide();
    });
    res.error(function (data, status, headers, config) {
        console.log("failure message: " + JSON.stringify({data: data}));
    });
});

