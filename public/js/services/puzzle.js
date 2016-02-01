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
                url: '/puzzle_templates',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: $.param(template)
            });
        };
        
        this.getPuzzleTemplates = function(){
            return $http({
                method: 'get',
                url: "/puzzle_templates"
              });
        }
    }])