var cSpeed=9;

var cWidth=30;
var cHeight=32;

var cTotalFrames=29;
var cFrameWidth=30;
var cImageSrc='/img/anim/sprites.gif';

var cImageTimeout=false;
var cIndex=0;
var cXpos=0;
var cPreloaderTimeout=false;
var SECONDS_BETWEEN_FRAMES=0;

function startAnimation(){

    document.getElementById('loaderImage').style.backgroundImage='url('+cImageSrc+')';
    document.getElementById('loaderImage').style.width=cWidth+'px';
    document.getElementById('loaderImage').style.height=cHeight+'px';

    //FPS = Math.round(100/(maxSpeed+2-speed));
    FPS = Math.round(100/cSpeed);
    SECONDS_BETWEEN_FRAMES = 1 / FPS;

    cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES/1000);

}

function continueAnimation(){

    cXpos += cFrameWidth;
    //increase the index so we know which frame of our animation we are currently on
    cIndex += 1;

    //if our cIndex is higher than our total number of frames, we're at the end and should restart
    if (cIndex >= cTotalFrames) {
        cXpos =0;
        cIndex=0;
    }

    if(document.getElementById('loaderImage'))
        document.getElementById('loaderImage').style.backgroundPosition=(-cXpos)+'px 0';

    cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES*1000);
}

function stopAnimation(){//stops animation
    clearTimeout(cPreloaderTimeout);
    cPreloaderTimeout=false;
}

function imageLoader(s, fun)//Pre-loads the sprites image
{
    clearTimeout(cImageTimeout);
    cImageTimeout=0;
    genImage = new Image();
    genImage.onload=function (){cImageTimeout=setTimeout(fun, 0)};
    genImage.onerror=new Function('alert(\'Could not load the image\')');
    genImage.src=s;
}
//The following code starts the animation
//<div id="loaderImage"></div>
//new imageLoader(cImageSrc, 'startAnimation()');
/**
 * Created by Develop on 11.08.14.
 */

var Animation = function(obj, action ){

    var text;
    var flag_start = false;
    var flag_hidden_class = true;

    this.isStart = function(){
        return flag_start
    }
    this.setImage = function(image){
        cImageSrc = '/img/anim/'+image
    }
    this.setText = function(set_text){
        text = set_text;
    }
    this.hidden = function(bool){
flag_hidden_class = bool;
    }
    this.setProperty = function(widtch, height){
        cWidth = widtch;
        cFrameWidth = widtch;
        cHeight = height;
    }


    this.start = function()
    {

        console.log(flag_start)

        if(flag_start == false)
        {
            if(flag_hidden_class)
            {
                obj.addClass('hidden');
            }


            var loader  = $('<label/>',{"id":"loader","class":"text-success",text:text})

                .append( $('<div />',{"id":"loaderImage"}));
            obj.parent().append(loader)

            new imageLoader(cImageSrc, 'startAnimation()');
            flag_start = true;
            return false;
        }

        return flag_start;
    }


    this.stop = function(){
        stopAnimation();
        obj.parent().find('#loader').remove();
        obj.removeClass('hidden');
        flag_start = false;
    }
}
//var animation_start = function(this_){
//    $(this_).html($('<div />',{"id":"loaderImage"}))
//    new imageLoader(cImageSrc, 'startAnimation()');
//}
//var animation_start = function(this_){
//    $(this_).html($('<div />',{"id":"loaderImage"}))
//    new imageLoader(cImageSrc, 'startAnimation()');
//}