!function(){var a=document.getElementById("site-navigation");if(void 0==a)return!1;var b=a.getElementsByTagName("h1")[0],c=a.getElementsByTagName("ul")[0];return void 0==b||void 0==c?!1:(b.onclick=function(){-1==c.className.indexOf("nav-menu")&&(c.className="nav-menu"),-1!=b.className.indexOf("toggled-on")?(b.className=b.className.replace(" toggled-on",""),c.className=c.className.replace(" toggled-on",""),a.className=a.className.replace("main-small-navigation","navigation-main")):(b.className+=" toggled-on",c.className+=" toggled-on",a.className=a.className.replace("navigation-main","main-small-navigation"))},c.childNodes.length||(b.style.display="none"),void 0)}(),function(){var a=navigator.userAgent.toLowerCase().indexOf("webkit")>-1,b=navigator.userAgent.toLowerCase().indexOf("opera")>-1,c=navigator.userAgent.toLowerCase().indexOf("msie")>-1;if((a||b||c)&&"undefined"!=typeof document.getElementById){var d=window.addEventListener?"addEventListener":"attachEvent";window[d]("hashchange",function(){var a=document.getElementById(location.hash.substring(1));a&&(/^(?:a|select|input|button|textarea)$/i.test(a.tagName)||(a.tabIndex=-1),a.focus())},!1)}}(),function(a){a(document).ready(function(){prettyPrint()})}(jQuery);