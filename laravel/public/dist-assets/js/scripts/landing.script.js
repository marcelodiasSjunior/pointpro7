"use strict";

$(document).ready(function () {
  $(".view_demo").click(function (e) {
    e.preventDefault();
    $("html, body").animate({
      scrollTop: $("#demo").offset().top
    }, 400);
  });
});