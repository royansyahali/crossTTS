materialAdmin
    .controller('puzzleTemplateCtrl', function($scope, $location, $timeout, puzzleService, growlService) {
        var self = this;
        self.name = '';
        self.username = '';
        self.width = 10;
        self.height = 10;
        self.forceSymmetry = true;
        self.blackSquares = [];
        self.clueSquares = [];
        
        puzzleService.getPuzzleTemplate($location.path().substr(18,999)).success(function(d){
            self.puzzleTemplate = d;
            self.name = d.name;
            self.width = d.width;
            self.height = d.height;
            self.owner = d.owner;
            self.username = d.username;
            self.forceSymmetry = d.symmetrical == 1;
            self.blackSquares = d.blackSquares;
            self.clueSquares = d.clueSquares;
        });
        
        self.symmetryClick = function(){
            if (self.forceSymmetry){
                self.height = self.width;
                self.blackSquares = [];
                self.clueSquares = [];
            }
        }
        
        self.changeWidth = function(){
            if (self.forceSymmetry){
                self.height = self.width;
                self.blackSquares = [];
                self.clueSquares = [];
            }
        }
        
        self.changeHeight = function(){
            if (self.forceSymmetry){
                self.width = self.height;
                self.blackSquares = [];
                self.clueSquares = [];
            }
        }
        
        self.changeBlock = function(row, col){
            var index = self.blackSquares.indexOf(row + '-' + col);
            if (index > -1){
                self.blackSquares.splice(index, 1);
            }else{
                self.blackSquares.push(row + '-' + col);
            }
            if (self.forceSymmetry && (col != self.width - col + 1 || row != self.height - row + 1)){
                col = self.width - col + 1;
                row = self.height - row + 1;
                index = self.blackSquares.indexOf(row + '-' + col);
                if (index > -1){
                    self.blackSquares.splice(index, 1);
                }else{
                    self.blackSquares.push(row + '-' + col);
                }
            }
            self.makeClueNumbers();
        }
        
        self.makeClueNumbers = function(){
            self.clueSquares = [];
            for (var row = 1; row <= self.height; row++){
                for (var col = 1; col <= self.width; col++){
                    if (self.blackSquares.indexOf(row + '-' + col) == -1 && (row == 1 || col == 1 || self.blackSquares.indexOf((row - 1) + '-' + col) > -1 || self.blackSquares.indexOf(row + '-' + (col - 1)) > -1)){
                        self.clueSquares.push(row + '-' + col);
                    }
                }
            }
        }
        
        self.createTemplate = function(){
            var template = {
                name: self.name,
                width: self.width,
                height: self.height,
                blackSquares: self.blackSquares
            };
            
            puzzleService.createTemplate(template).success(function(d){
                if (d['errors']){
                    for(e in d['errors']){
                        growlService.growl('There was an error: ' + d['errors'][e], 'danger');
                    }
                }else{
                    growlService.growl('Success!', 'success');
                }
            }).error(function(d){
                growlService.growl('There was an error: ' + d, 'danger');
            });
        }
        
        self.clueNumber = function(row, col){
            return self.clueSquares.indexOf(row + '-' + col);
        }
        
        self.isBlackSquare = function(row, col){
            return self.blackSquares.indexOf(row + '-' + col) > -1;
        }
        
        self.range = function(min,max,step){
            step = step || 1;
            var input = [];
            
            for (var i = min; i <= max; i += step){
                input.push(i);
            }
            return input;
        };
    })