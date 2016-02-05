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
                                swal(":(", "There was a problem. Sorry.", "error"); 
                            }
                        });
                    });
                });
            }
        }
    })