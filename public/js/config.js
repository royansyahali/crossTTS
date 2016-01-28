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

            .state ('puzzles.new-puzzle-template', {
                url: '/edit-puzzle-template',
                templateUrl: 'views/edit-puzzle-template.html'
            })

            .state ('puzzles.edit-puzzle-template', {
                url: '/edit-puzzle-template/:puzzle_template_id',
                templateUrl: 'views/edit-puzzle-template.html'
            })

            .state ('puzzles.new-puzzle', {
                url: '/edit-puzzle',
                templateUrl: 'views/edit-puzzle.html'
            })

            .state ('puzzles.edit-puzzle', {
                url: '/edit-puzzle/:puzzle_id',
                templateUrl: 'views/edit-puzzle.html'
            })

            .state ('puzzles.detail', {
                url: '/:puzzle_id',
                templateUrl: 'views/puzzle-detail.html'
            })
    });
