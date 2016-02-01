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

            .state ('puzzles.new', {
                url: '/new',
                templateUrl: 'views/edit-puzzle.html'
            })

            .state ('puzzles.detail', {
                url: '/:puzzle_id',
                templateUrl: 'views/puzzle-detail.html'
            })
            

            //------------------------------
            // PUZZLE-TEMPLATES
            //------------------------------
            
            .state ('puzzle-templates', {
                url: '/puzzle-templates',
                templateUrl: 'views/common.html'
            })
            
            .state ('puzzle-templates.list', {
                url: '/list',
                templateUrl: 'views/puzzle-templates-list.html'
            })

            .state ('puzzle-templates.new', {
                url: '/new',
                templateUrl: 'views/edit-puzzle-template.html'
            })

            .state ('puzzle-templates.detail', {
                url: '/:puzzle_template_id',
                templateUrl: 'views/puzzle-template-detail.html'
            })
    });
