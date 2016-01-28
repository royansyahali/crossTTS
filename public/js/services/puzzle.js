materialAdmin

    .service('puzzleService', ['$http', function($http){
        this.getPuzzles = function() {
            return $http({
                method: 'get',
                url: "/puzzles"
              });
        };
    }])