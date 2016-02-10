materialAdmin
    .service('profileService', ['$http', function($http){
        this.getMe = function() {
            return $http({
                method: 'get',
                url: "/auth/me"
            });
        };
        
        this.getProfile = function(username){
            return $http({
                method: 'get',
                url: "/users/" + username
            });
        };
        
        this.logout = function() {
            return $http({
                method: 'get',
                url: '/auth/logout'
            });
        };
    }]);
