materialAdmin

    .service('puzzleService', ['$http', function($http){
        this.getPuzzles = function() {
            return $http({
                method: 'get',
                url: "/puzzles"
              });
        };
        
        this.createTemplate = function(template){
            return $http({
                method: 'post',
                url: '/puzzleTemplates',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: $.param(template)
            });
        };
        
    }])