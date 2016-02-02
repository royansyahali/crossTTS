materialAdmin
    .directive('contenteditable', function() {
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                // view -> model
                elm.bind('keydown', function(event) {
                    var keyCode = event.which || event.keyCode;
                    
                    if (keyCode > 64 && keyCode < 91){
                        elm.html(String.fromCharCode(keyCode));
                        event.preventDefault();
                    }
                });

                // model -> view
                ctrl.$render = function() {
                    elm.html(ctrl.$viewValue);
                };

                // load init value from DOM
                //ctrl.$setViewValue(elm.html());
            }
        };
    });