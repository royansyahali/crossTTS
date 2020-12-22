materialAdmin

    //Warning Message
    .directive('createPuzzleWarning', function($location, $timeout, puzzleService){
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                element.click(function(){
                    swal({   
                        title: "Are you sure?",   
                        text: "You will not be able to change this puzzle any more!",   
                        type: "warning",   
                        showCancelButton: true,   
                        confirmButtonColor: "#DD6B55",   
                        confirmButtonText: "Yes, create it!",   
                        closeOnConfirm: false 
                    }, function(){
                        var sent = {
                            slug: attrs.puzzleSlug,
                        };
                        puzzleService.activatePuzzle(sent).success(function(d){
                            if (d['success']){
                                swal("Created!", "Your puzzle has been created", "success"); 
                                $timeout(function(){
                                    $location.path('/home');
                                },2000);
                            }else{
                                var msg = '';
                                if (d['errors']['missing_clues'].length > 0){
                                    msg += 'The following clue(s) are missing:\n';
                                    for(var i in d['errors']['missing_clues']){
                                        msg += d['errors']['missing_clues'][i]+'clue'+ '\n';
                                    }
                                }
                                if (d['errors']['missing_letters'].length > 0){
                                    msg += 'The following letter(s) are missing:\n';
                                    for(var i in d['errors']['missing_letters']){
                                        msg += d['errors']['missing_letters'][i]+'letter'+ '\n';
                                    }
                                }
                                swal(":(", "There was a problem. Sorry.\n" + msg, "error"); 
                            }
                        });
                    });
                });
            }
        }
    })