materialAdmin
    .controller('profileCtrl', function($scope, $location, $stateParams, $timeout, growlService, profileService) {
        var self = this;
        self.profile = {};
        
        profileService.getProfile($stateParams.username).success(function(d){
            self.profile = d;
        });
        
        self.isBlackSquare = function(template_slug, row, col){
            return self.profile.templates[template_slug].puzzle_template_squares[row + '-' + col].square_type == 'black';
        }
        
        self.clueNumber = function(template_slug, row, col){
            return self.profile.templates[template_slug].clue_squares.indexOf(row + '-' + col);
        }
        
        self.range = function(min,max,step){
            step = step || 1;
            var input = [];
            
            for (var i = min; i <= max; i += step){
                input.push(i);
            }
            return input;
        };
    });