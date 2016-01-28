materialAdmin
    .controller('puzzleTemplateCtrl', function($scope, $timeout, puzzleService) {
        var self = this;
        self.width = 10;
        self.height = 10;
        self.forceSymmetry = true;
        self.blackSquares = [];
        
        self.symmetryClick = function(){
            if (self.forceSymmetry){
                self.height = self.width;
            }
        }
        
        self.changeWidth = function(){
            if (self.forceSymmetry){
                self.height = self.width;
            }
            self.blackSquares = [];
        }
        
        self.changeHeight = function(){
            if (self.forceSymmetry){
                self.width = self.height;
            }
            self.blackSquares = [];
        }
        
        self.changeBlock = function(row, col){
            var index = self.blackSquares.indexOf(row + '-' + col);
            if (index > -1){
                self.blackSquares.splice(index, 1);
            }else{
                self.blackSquares.push(row + '-' + col);
            }
            if (self.forceSymmetry){
                col = self.width - col + 1;
                row = self.height - row + 1;
                index = self.blackSquares.indexOf(row + '-' + col);
                if (index > -1){
                    self.blackSquares.splice(index, 1);
                }else{
                    self.blackSquares.push(row + '-' + col);
                }
            }
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