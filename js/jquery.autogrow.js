/*
* Auto Expanding Text Area (2.0.0)
* by Chrys Bader (www.chrysbader.com)
* chrysb@gmail.com
*
* Special thanks to:
* Jake Chapa - jake@hybridstudio.com
* John Resig - jeresig@gmail.com
*
* Copyright (c) 2008 Chrys Bader (www.chrysbader.com)
* Licensed under the GPL (GPL-LICENSE.txt) license.
*
*
* NOTE: This script requires jQuery to work. Download jQuery at www.jquery.com
*
*/

jQuery.fn.autoGrow=function(){return this.each(function(){var a=this.cols;var b=this.rows;var c=function(){d(this)};var d=function(c){var d=0;var e=c.value.split("\n");for(var f=e.length-1;f>=0;--f){d+=Math.floor(e[f].length/a+1)}if(d>=b)c.rows=d+1;else c.rows=b};var e=function(a){var b=0;var c=0;var d=0;var e=a.cols;a.cols=1;c=a.offsetWidth;a.cols=2;d=a.offsetWidth;b=d-c;a.cols=e;return b};this.style.width="auto";this.style.height="auto";this.style.overflow="hidden";this.style.width=e(this)*this.cols+6+"px";this.onkeyup=c;this.onfocus=c;this.onblur=c;d(this)})}