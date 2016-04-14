app.controller("ProjectController", function ($scope, $http) {
    $scope.raised = null;
    $scope.projectResponce = null;
    $scope.img=null;
    var res = $http.get('/api/v1/projects/1.json');
    res.success(function (data, status, headers, config) {
        $scope.projectResponce = data;
        
        $scope.raised = ($scope.projectResponce.quantum / 120000 * 100).toFixed(0);
    });
    res.error(function (data, status, headers, config) {
        console.log("failure message: " + JSON.stringify({data: data}));
    });
});
