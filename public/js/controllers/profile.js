materialAdmin
    .controller('profileCtrl', function($scope, $location, $stateParams, $timeout, growlService, profileService) {
        var self = this;
        self.profile = {};
        
        profileService.getProfile($stateParams.username).success(function(d){
            self.profile = d;
        });
    });