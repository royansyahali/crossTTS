materialAdmin
    .controller('dashboardCtrl', function($scope, $timeout, profileService, puzzleService) {
        var self = this;
        self.puzzles = [];
        self.incompletePuzzles = [];
        
        puzzleService.getPuzzles(5).success(function(d){
            self.puzzles = d;
        });
        
        profileService.getProfile().success(function(profile){
            self.profile = profile;
            if (profile.logged_in){
                puzzleService.getIncompletePuzzles().success(function(d){
                    self.incompletePuzzles = d;
                });
            }
        });
    });