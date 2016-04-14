app.controller("PortfolioController", function ($scope, $http) {
    $scope.amounts = amounts;
    var res = $http.get('/api/v1/borrowers/2.json');
    res.success(function (data, status, headers, config) {
        $scope.portfolioResponce = data;
        console.log(data);
    });
    // res.error(function(data, status, headers, config) {
    //   alert( "failure message: " + JSON.stringify({data: data}));
    // });
});
var amounts = [
    {
        id: 1,
        value: 500
    },
    {
        id: 2,
        value: 1000
    },
    {
        id: 3,
        value: 1500
    },
    {
        id: 4,
        value: 2000
    }
];
    
