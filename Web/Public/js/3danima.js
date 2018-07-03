function preloadimages(arr) {   
    var newimages = [], loadedimages = 0;
    var postaction = function() {};
    var arr = (typeof arr != "object") ? [arr] : arr;
    function imageloadpost() {
        loadedimages++;
        if (loadedimages == arr.length) {
            postaction(newimages);
        }
    }
    for (var i = 0; i < arr.length; i++) {
        newimages[i] = new Image();
        newimages[i].src = arr[i];
        newimages[i].onload = function() {
            imageloadpost();
        };
        newimages[i].onerror = function() {
            imageloadpost();
        };
    }
    return {
        done:function(f) {
            postaction=f || postaction;
        }
    }
}

function initAnima(touchId, imgDom, canUpPosition, images, spcImages, callback) {
    var upActive = false;
    var downActive = false;
    var leftRightActive = true;
    var currentPostion = 0;
    var currentUpDownPostion = -1;
    var upDownRestPostion = 0;
    var hammertime = new Hammer(document.getElementById(touchId));
    
    var currentX = 0;
    var currentY = 0;
    var canChangeX = false;
    var canChangeY = false;
    
    imgDom.css("background-image", 'url('+images[0].src+')');

    hammertime.get('pan').set({direction : Hammer.DIRECTION_ALL});
    hammertime.on("hammer.input", function(ev) {
        
        // down
        if (ev.isFirst && !ev.isFinal) {
            currentX = ev.deltaX;
            currentY = ev.deltaY;
        }
        // move
        if (!ev.isFirst && !ev.isFinal) {
            if (ev.deltaX % 6 == 0 && ev.deltaX != currentX) {
                canChangeX = true;
                currentX = ev.deltaX;
            } else {
                canChangeX = false;
            }
            if (ev.deltaY % 6 == 0 && ev.deltaY != currentY) {
                canChangeY = true;
                currentY = ev.deltaY;
            } else {
                canChangeY = false;
            }
        }
        // up
        if (!ev.isFirst && ev.isFinal) {
            canChangeX = false;
            canChangeY = false;
            currentX = 0;
            currentY = 0;
        }
    });
    hammertime.on("panleft", function (e) {
        if (!leftRightActive || !canChangeX) {
            return;
        }
        currentPostion++;
        if (currentPostion == images.length) {
            currentPostion = 0;
        }
        imgDom.css("background-image", 'url('+images[currentPostion].src+')');

        if ($.inArray(currentPostion+"",canUpPosition) >= 0) {
            downActive = true;
            upDownRestPostion = currentPostion;
        } else {
            downActive = false;
        }
        if (callback) {
            callback(upActive, downActive, leftRightActive);
        }
    });
    hammertime.on("panright", function (e) {
        if (!leftRightActive || !canChangeX) {
            return;
        }
        currentPostion--;
        if (currentPostion < 0) {
            currentPostion = images.length - 1;
        }
        imgDom.css("background-image", 'url('+images[currentPostion].src+')');
        if ($.inArray(currentPostion+"",canUpPosition) >= 0) {
            downActive = true;
            upDownRestPostion = currentPostion;
        } else {
            downActive = false;
        }
        if (callback) {
            callback(upActive, downActive, leftRightActive);
        }
    });
    hammertime.on("panup", function(e) {
        e.preventDefault();
        if (!upActive || currentUpDownPostion < 0 || !canChangeY) {
            return;
        }
        currentUpDownPostion--;
        if (currentUpDownPostion >= 0) {
            imgDom.css("background-image", 'url('+spcImages[upDownRestPostion][currentUpDownPostion].src+')');
        } else {
            imgDom.css("background-image", 'url('+spcImages[upDownRestPostion][currentUpDownPostion].src+')');
            imgDom.attr("src", images[upDownRestPostion].src);
            upActive = false;
            leftRightActive = true;
        }
        if (callback) {
            callback(upActive, downActive, leftRightActive);
        }
    });
    hammertime.on("pandown", function(e) {
        e.preventDefault();
        if (!downActive || currentUpDownPostion == spcImages[upDownRestPostion].length - 1 || !canChangeY) {
            return;
        }
        currentUpDownPostion++;
        imgDom.css("background-image", 'url('+spcImages[upDownRestPostion][currentUpDownPostion].src+')');
        leftRightActive = false;
        upActive = true;
        if (callback) {
            callback(upActive, downActive, leftRightActive);
        }
    });
}