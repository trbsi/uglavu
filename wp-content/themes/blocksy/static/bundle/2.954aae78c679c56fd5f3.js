(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{16:function(e,t,n){"use strict";n.d(t,"b",function(){return u}),n.d(t,"a",function(){return l});var o=0,r=!1;try{var c=Object.defineProperty({},"passive",{get:function(){r=!0}});window.addEventListener("test",null,c)}catch(e){}var a=function(e){var t=e.target,n=window.innerWidth/window.document.documentElement.clientWidth;if(!(e.touches.length>1||1!==n)){for(;t!==document.body&&t!==document;){var r=window.getComputedStyle(t);if(!r)break;if("INPUT"===t.nodeName&&"range"===t.getAttribute("type"))return;var c=r.getPropertyValue("-webkit-overflow-scrolling"),a=r.getPropertyValue("overflow-y"),i=parseInt(r.getPropertyValue("height"),10),d="touch"===c&&("auto"===a||"scroll"===a),u=t.scrollHeight>t.offsetHeight;if(d&&u){var l=e.touches?e.touches[0].screenY:e.screenY,s=o<=l&&0===t.scrollTop,m=o>=l&&t.scrollHeight-t.scrollTop===i;return void((s||m)&&e.preventDefault())}t=t.parentNode}e.preventDefault()}},i=function(e){o=e.touches?e.touches[0].screenY:e.screenY},d=function(){var e=document.createElement("div");document.documentElement.appendChild(e),e.style.WebkitOverflowScrolling="touch";var t="getComputedStyle"in window&&"touch"===window.getComputedStyle(e)["-webkit-overflow-scrolling"];return document.documentElement.removeChild(e),t},u=function(){d()&&(window.addEventListener("touchstart",i,!!r&&{passive:!1}),window.addEventListener("touchmove",a,!!r&&{passive:!1}),!0)},l=function(){d()&&(window.removeEventListener("touchstart",i,!1),window.removeEventListener("touchmove",a,!1),!1)}},47:function(e,t,n){"use strict";n.r(t),n.d(t,"initSingleModal",function(){return a}),n.d(t,"handleClick",function(){return i});var o=n(16);function r(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{},o=Object.keys(n);"function"==typeof Object.getOwnPropertySymbols&&(o=o.concat(Object.getOwnPropertySymbols(n).filter(function(e){return Object.getOwnPropertyDescriptor(n,e).enumerable}))),o.forEach(function(t){c(e,t,n[t])})}return e}function c(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var a=function(e){!function(e,t){var n=r({modalTarget:"animatedModal",animatedIn:"ct-fade-in",animatedOut:"ct-fade-out"},t);document.querySelector(n.modalTarget).querySelector(".ct-bag-container").addEventListener("click",function(e){e.stopPropagation()}),e.addEventListener("click",function(t){return i(t,e,n)})}(e,{modalTarget:e.hash})};var i=function(e,t,n){var c,a=r({modalTarget:"animatedModal",animatedIn:"ct-fade-in",animatedOut:"ct-fade-out",clickOutside:!1},n);e.preventDefault();var i=document.querySelector(t.hash),u=i.querySelector(".ct-bag-container");i.classList.add("opened"),document.body.classList.add("ct-modal-open"),i.classList.add("active"),Object(o.b)(),(c=u.classList).add.apply(c,["".concat(a.animatedIn),"ct-animated"]),u.querySelector("input")&&u.querySelector("input").focus(),u.addEventListener("animationend",function(){var e;(e=u.classList).remove.apply(e,["".concat(a.animatedIn),"ct-animated"])},{once:!0});document.addEventListener("keyup",function e(t){var n=t.keyCode;t.target;27===n&&(t.preventDefault(),document.removeEventListener("keyup",e),d(i,a))}),i.querySelector(".ct-bag-close").addEventListener("click",function(e){e.preventDefault(),e.stopPropagation(),d(i,a)},{once:!0}),a.clickOutside&&(i.querySelector(".ct-bag-content").firstElementChild.addEventListener("click",function(e){return e.stopPropagation()}),i.querySelector(".ct-bag-content").addEventListener("click",function(e){return d(i,a)},{once:!0}))};function d(e,t){var n=e.querySelector(".ct-bag-container");document.querySelector(".mobile-menu-toggle").firstElementChild.classList.remove("close"),n.classList.add(t.animatedOut,"ct-animated"),e.classList.remove("active"),n.addEventListener("animationend",function(){document.body.classList.remove("ct-modal-open"),n.classList.remove(t.animatedOut,"ct-animated"),e.classList.remove("opened"),Object(o.a)(),ctEvents.trigger("ct:modal:closed",n)},{once:!0})}}}]);