materialAdmin

    .service('puzzleService', ['$http', function($http){
        this.getPuzzles = function() {
            return $http({
                method: 'get',
                url: "/puzzles"
              });
        };
        
        this.getIncompletePuzzles = function() {
            return $http({
                method: 'get',
                url: "/incomplete_puzzles"
              });
        };
        
        this.getPuzzle = function(slug) {
            return $http({
                method: 'get',
                url: "/puzzles/" + slug
              });
        };
        
        this.createPuzzle = function(sent){
            return $http({
                method: 'post',
                url: '/puzzles',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: $.param(sent)
            });
        }
        
        
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
        
        this.getPuzzleTemplate = function(slug){
            return $http({
                method: 'get',
                url: "/puzzle_templates/" + slug
              });
        }
        
        
        this.getPuzzleSquareSuggestion = function (slug, row, col){
            return $http({
                method: 'get',
                url: "/puzzle_squares/suggestion/" + slug + "/" + row + "/" + col
              });
        }
        
        this.setPuzzleSquare = function (sent){
            return $http({
                method: 'post',
                url: '/puzzle_square',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: $.param(sent)
            });
        }
        
        
        this.saveClue = function(sent){
            return $http({
                method: 'post',
                url: '/clue',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: $.param(sent)
            });
        }
    }])