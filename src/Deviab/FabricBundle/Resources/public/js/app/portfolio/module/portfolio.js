var app = angular.module('myApp', ['ngRoute']);
app.config(function ($routeProvider, $interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    $routeProvider.
        when('/', {
            templateUrl: '/bundles/fabric/js/app/templates/home.html',
        }).
        when('/project', {
            templateUrl: '/bundles/fabric/js/app/templates/project.html',
        }).
        when('/faqs', {
            templateUrl: '/bundles/fabric/js/app/templates/faqs.html'
        }).
        when('/how_it_works', {
            templateUrl: '/bundles/fabric/js/app/templates/how_it_works.html'
        }).
        when('/setting', {
            templateUrl: '/bundles/fabric/js/app/templates/setting.html'
        }).
        when('/dashboard', {
            templateUrl: '/bundles/fabric/js/app/templates/dashboard.html',
        });
});
