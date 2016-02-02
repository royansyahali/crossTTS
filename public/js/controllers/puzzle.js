materialAdmin
    .controller('puzzleCtrl', function($scope, $location, $timeout, puzzleService) {
        var self = this;
        self.puzzle = {};
        self.puzzle.clues = {};
        self.selectedRow = 0;
        self.selectedCol = 0;
        self.selectedDirection = 'across';
        
        puzzleService.getPuzzleTemplate($location.path().substr(13,999)).success(function(d){
            self.puzzleTemplate = d;
            self.puzzle.squares = {};
            for(var row = 1; row <= d.height; row++){
                for(var col = 1; col <= d.width; col++){
                    self.puzzle.squares[row + '-' + col] = {
                        type: self.isBlackSquare(row, col) ? 'black' : 'white',
                    };
                }
            }
        });
        
        self.keyDown = function(e){
            var preventDefault = true;
            if (e.keyCode > 64 && e.keyCode < 91){
                self.puzzle.squares[self.selectedCol + '-' + self.selectedRow] = String.fromCharCode(e.keyCode);
                if (self.selectedDirection == 'across'){
                    self.moveRight();
                }else if (self.selectedDirection == 'down'){
                    self.moveDown();
                }
            }else{
                switch (e.keyCode){
                    case 37:
                        //left arrow
                        self.moveLeft();
                        break;
                    case 38:
                        //up arrow
                        self.moveUp();
                        break;
                    case 39:
                        //right arrow
                        self.moveRight();
                        break;
                    case 40:
                        //down arrow
                        self.moveDown();
                        break;
                    case 8:
                        //backspace
                        self.puzzle.squares[self.selectedRow + '-' + self.selectedCol].letter = '';
                        if (self.selectedDirection == 'across'){
                            self.moveLeft();
                        }else if (self.selectedDirection == 'down'){
                            self.moveUp();
                        }
                        break;
                    case 46:
                        //delete
                        self.puzzle.squares[self.selectedRow + '-' + self.selectedCol].letter = '';
                        break;
                    case 9:
                        //tab
                    case 13:
                        //enter
                        if1:
                        if (self.selectedDirection == 'across'){
                            for (var col = self.selectedCol + 1; col <= self.puzzleTemplate.width; col++){
                                if (!self.isBlackSquare(self.selectedRow, col)){
                                    self.selectedCol = col;
                                    break if1;
                                }
                            }
                            loop1:
                            for (var row = self.selectedRow + 1; row <= self.puzzleTemplate.height; row++){
                                for (var col = 1; col <= self.puzzleTemplate.width; col++){
                                    if (!self.isBlackSquare(row, col)){
                                        self.selectedRow = row;
                                        self.selectedCol = col;
                                        break loop1;
                                    }
                                }
                            }
                        }else if (self.selectedDirection == 'down'){
                            for (var row = self.selectedRow + 1; col <= self.puzzleTemplate.height; row++){
                                if (!self.isBlackSquare(row, self.selectedCol)){
                                    self.selectedRow = row;
                                    break if1;
                                }
                            }
                            loop2:
                            for (var col = self.selectedCol + 1; col <= self.puzzleTemplate.width; col++){
                                for (var row = 1; row <= self.puzzleTemplate.height; row++){
                                    if (!self.isBlackSquare(row, col)){
                                        self.selectedRow = row;
                                        self.selectedCol = col;
                                        break loop2;
                                    }
                                }
                            }
                        }
                        break;
                    default:
                        preventDefault = false;
                        break;
                }
                if (preventDefault){
                    e.preventDefault();
                }
            }
            $("[data-row="+self.selectedRow+"][data-col="+self.selectedCol+"] div").focus();
        }
        
        self.moveLeft = function(){
            self.selectedDirection = 'across';
            var destinationCol = self.selectedCol - 1;
            while (destinationCol > 0 && self.isBlackSquare(self.selectedRow, destinationCol)){
                destinationCol--;
            }
            if (destinationCol > 0){
                self.selectedCol = destinationCol;
            }
        };
        
        self.moveRight = function(){
            self.selectedDirection = 'across';
            var destinationCol = self.selectedCol + 1;
            while (destinationCol < self.puzzleTemplate.width + 1 && self.isBlackSquare(self.selectedRow, destinationCol)){
                destinationCol++;
            }
            if (destinationCol < self.puzzleTemplate.width + 1){
                self.selectedCol = destinationCol;
            }
        };
        
        self.moveUp = function(){
            self.selectedDirection = 'down';
            var destinationRow = self.selectedRow - 1;
            while (destinationRow > 0 && self.isBlackSquare(destinationRow, self.selectedCol)){
                destinationRow--;
            }
            if (destinationRow > 0){
                self.selectedRow = destinationRow;
            }
        };
        
        self.moveDown = function(){
            self.selectedDirection = 'down';
            var destinationRow = self.selectedRow + 1;
            while (destinationRow < self.puzzleTemplate.height + 1 && self.isBlackSquare(destinationRow, self.selectedCol)){
                destinationRow++;
            }
            if (destinationRow < self.puzzleTemplate.height + 1){
                self.selectedRow = destinationRow;
            }
        };
        
        self.inSelectedWord = function(row, col){
            if (self.isBlackSquare(row, col)){
                return false;
            }
            if (self.selectedDirection == 'down'){
                if (col != self.selectedCol){
                    return false;
                }
                var keepLookingDown = true;
                var r = row;
                while (keepLookingDown){
                    if (r == self.selectedRow){
                        return true;
                    }
                    r++;
                    if (r == self.puzzleTemplate.width + 1 || self.isBlackSquare(r, col)){
                        keepLookingDown = false;
                    }
                }
                var keepLookingUp = true;
                r = row;
                while (keepLookingUp){
                    if (r == self.selectedRow){
                        return true;
                    }
                    r--;
                    if (r == 0 || self.isBlackSquare(r, col)){
                        keepLookingUp = false;
                    }
                }
            }else if(self.selectedDirection == 'across'){
                if (row != self.selectedRow){
                    return false;
                }
                var keepLookingRight = true;
                var c = col;
                while (keepLookingRight){
                    if (c == self.selectedCol){
                        return true;
                    }
                    c++;
                    if (c == self.puzzleTemplate.height + 1 || self.isBlackSquare(row, c)){
                        keepLookingRight = false;
                    }
                }
                var keepLookupLeft = true;
                c = col;
                while (keepLookupLeft){
                    if (c == self.selectedCol){
                        return true;
                    }
                    c--;
                    if (c == 0 || self.isBlackSquare(row, c)){
                        keepLookupLeft = false;
                    }
                }
            }
            return false;
        };
        
        self.selectLetter = function(row, col){
            if (self.selectedRow == row && self.selectedCol == col){
                if (self.selectedDirection == 'across'){
                    self.selectedDirection = 'down';
                }else{
                    self.selectedDirection = 'across';
                }
            }
            self.selectedRow = row;
            self.selectedCol = col;
        };
        
        self.selectedLetter = function(row, col){
            return self.puzzle.squares[self.selectedRow + '-' + self.selectedCol];
        };
        
        self.isBlackSquare = function(row, col){
            return self.puzzleTemplate.blackSquares.indexOf(row + '-' + col) > -1;
        };
        
        self.clueNumber = function(row, col){
            return self.puzzleTemplate.clueSquares.indexOf(row + '-' + col);
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