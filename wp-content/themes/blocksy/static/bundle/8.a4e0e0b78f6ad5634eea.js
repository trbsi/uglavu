(window.webpackJsonp=window.webpackJsonp||[]).push([[8],{44:function(n,t,o){"use strict";o.r(t),o.d(t,"mount",function(){return e});var e=function(){var n=document.querySelector(".ct-back-to-top");if(n){var t=!1,o=function(){var n=document.querySelector(".ct-back-to-top");n&&(window.scrollY>500?n.classList.add("ct-show"):n.classList.remove("ct-show"))};o(),window.addEventListener("scroll",function(){t||(t=!0,requestAnimationFrame(function(){o(),t=!1}))}),n.addEventListener("click",function(n){n.preventDefault();var t=window.scrollY,o=null;requestAnimationFrame(function n(e){o||(o=e);var c,r,i,a=e-o,s=Math.max((c=a,r=t,i=-t,(c/=350)<1?i/2*c*c+r:-i/2*(--c*(c-2)-1)+r),0);scrollTo(0,s),a<700&&requestAnimationFrame(n)})})}}}}]);