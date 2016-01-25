materialAdmin
    .config(function ($stateProvider, $urlRouterProvider){
        $urlRouterProvider.otherwise("/home");


        $stateProvider
        
            //------------------------------
            // HOME
            //------------------------------
        
            .state ('home', {
                url: '/home',
                templateUrl: 'views/dashboard.html'
            })
        

            //------------------------------
            // PUZZLES
            //------------------------------
        
            .state ('puzzles', {
                url: '/puzzles',
                templateUrl: 'views/common.html'
            })
            
            .state ('puzzles.list', {
                url: '/list',
                templateUrl: 'views/puzzles-list.html'
            })

            .state ('puzzles.detail', {
                url: '/:puzzle_id',
                templateUrl: 'views/puzzle-detail.html'
            })
    });
