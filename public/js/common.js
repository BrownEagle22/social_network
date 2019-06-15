$("document").ready(function() {
    $("body>div").eq(1).remove();
});

var waitingLike = false;

function toggleBigLike(isPositive, containerId, className, controllerName, inputData) {
    if (!waitingLike) {
        waitingLike = true;

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        inputData._token = CSRF_TOKEN;
        inputData.is_positive = isPositive ? "1" : "0";

        var increaseEl = $("#" + containerId + " .like");
        var otherEl = $("#" + containerId + " .dislike");

        if (!isPositive) {
            var temp = increaseEl;
            increaseEl = otherEl;
            otherEl = temp;
        }

        if (increaseEl.hasClass(className)) {
            $.post("/" + controllerName + "/destroy", inputData, function(response) {
                if (response.success) {
                    var countEl = increaseEl.find(".like-count");
                    countEl.text(parseInt(countEl.text(), 10) - 1);
                }
                
                increaseEl.removeClass(className);
                otherEl.removeClass(className);
                waitingLike = false;
            });
        } else {
            $.post("/" + controllerName + "/store", inputData, function(response) {
                if (response.success) {
                    var countEl = increaseEl.find(".like-count");
                    countEl.text(parseInt(countEl.text(), 10) + 1);
                }            

                if (otherEl.hasClass(className)) {
                    var countEl = otherEl.find(".like-count");
                    countEl.text(parseInt(countEl.text(), 10) - 1);
                }

                increaseEl.addClass(className);
                otherEl.removeClass(className);
                waitingLike = false;
            });
        }
    }
}

function toggleSmallLike(isPositive, containerId, className, controllerName, inputData) {
    if (!waitingLike) {
        waitingLike = true;

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        inputData._token = CSRF_TOKEN;
        inputData.is_positive = isPositive ? "1" : "0";

        var increaseEl = $("#" + containerId + " .like");
        var otherEl = $("#" + containerId + " .dislike");

        if (!isPositive) {
            var temp = increaseEl;
            increaseEl = otherEl;
            otherEl = temp;
        }

        if (increaseEl.find("i").hasClass(className)) {
            $.post("/" + controllerName + "/destroy", inputData, function(response) {
                if (response.success) {
                    var countEl = increaseEl.find(".like-count");
                    countEl.text(parseInt(countEl.text(), 10) - 1);
                }
                
                increaseEl.find("i").removeClass(className);
                otherEl.find("i").removeClass(className);
                waitingLike = false;
            });
        } else {
            $.post("/" + controllerName + "/store", inputData, function(response) {
                if (response.success) {
                    var countEl = increaseEl.find(".like-count");
                    countEl.text(parseInt(countEl.text(), 10) + 1);
                }            

                if (otherEl.find("i").hasClass(className)) {
                    var countEl = otherEl.find(".like-count");
                    countEl.text(parseInt(countEl.text(), 10) - 1);
                }

                increaseEl.find("i").addClass(className);
                otherEl.find("i").removeClass(className);
                waitingLike = false;
            });
        }
    }
}