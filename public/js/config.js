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
                templateUrl: 'views/puzzles-list.html',
                resolve: {
                    loadPlugin: function($ocLazyLoad) {
                        return $ocLazyLoad.load ([
                            {
                                name: 'css',
                                insertBefore: '#app-level',
                                files: [
                                    'vendors/bower_components/nouislider/jquery.nouislider.css',
                                    'vendors/bower_components/chosen/chosen.min.css',
                                ]
                            },
                            {
                                name: 'vendors',
                                files: [
                                    'vendors/bower_components/nouislider/jquery.nouislider.min.js',
                                    'vendors/bower_components/chosen/chosen.jquery.js',
                                    'vendors/bower_components/angular-chosen-localytics/chosen.js',
                                ]
                            }
                        ])
                    }
                }
            })
            
            .state ('puzzles.my-incomplete-list', {
                url: '/incomplete-list',
                templateUrl: 'views/puzzles-list-incomplete.html',
                resolve: {
                    loadPlugin: function($ocLazyLoad) {
                        return $ocLazyLoad.load ([
                            {
                                name: 'css',
                                insertBefore: '#app-level',
                                files: [
                                    'vendors/bower_components/nouislider/jquery.nouislider.css',
                                    'vendors/bower_components/chosen/chosen.min.css',
                                ]
                            },
                            {
                                name: 'vendors',
                                files: [
                                    'vendors/bower_components/nouislider/jquery.nouislider.min.js',
                                    'vendors/bower_components/chosen/chosen.jquery.js',
                                    'vendors/bower_components/angular-chosen-localytics/chosen.js',
                                ]
                            }
                        ])
                    }
                }
            })

            .state ('puzzles.edit', {
                url: '/edit/:puzzle_slug',
                templateUrl: 'views/puzzle-edit.html'
            })

            .state ('puzzles.solve', {
                url: '/solve/:puzzle_slug',
                templateUrl: 'views/puzzle-solve.html'
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
                templateUrl: 'views/puzzle-templates-list.html',
                resolve: {
                    loadPlugin: function($ocLazyLoad) {
                        return $ocLazyLoad.load ([
                            {
                                name: 'css',
                                insertBefore: '#app-level',
                                files: [
                                    'vendors/bower_components/nouislider/jquery.nouislider.css',
                                    'vendors/bower_components/chosen/chosen.min.css',
                                ]
                            },
                            {
                                name: 'vendors',
                                files: [
                                    'vendors/bower_components/nouislider/jquery.nouislider.min.js',
                                    'vendors/bower_components/chosen/chosen.jquery.js',
                                    'vendors/bower_components/angular-chosen-localytics/chosen.js',
                                ]
                            }
                        ])
                    }
                }
            })

            .state ('puzzle-templates.new', {
                url: '/new',
                templateUrl: 'views/puzzle-template-edit.html'
            })

            .state ('puzzle-templates.detail', {
                url: '/:puzzle_template_id',
                templateUrl: 'views/puzzle-template-detail.html'
            })
            
        
            //Profile
        
            .state ('users', {
                url: '/users',
                templateUrl: 'views/common.html'
            })
            
            .state ('users.profile', {
                url: '/:username',
                templateUrl: 'views/profile.html'
            })
        
            .state ('users.profile.puzzles-made', {
                url: '/puzzles-made',
                templateUrl: 'views/profile-puzzles-made.html'
            })
        
            .state ('users.profile.templates-made', {
                url: '/templates-made',
                templateUrl: 'views/profile-templates-made.html'
            })
            
            .state ('users.profile.puzzles-worked', {
                url: '/puzzles-worked',
                templateUrl: 'views/profile-puzzles-worked.html',
            })
    });
