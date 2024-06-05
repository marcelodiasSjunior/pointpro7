window.addEventListener("DOMContentLoaded", function () {
  jQuery(function () {
    jQuery("input[name=update_profile_fields]").click(() => {
      var user = pw_script_vars.alert
      var url =
        "https://api.pointpro7.com/api/woocommerce_membership_updated";

      jQuery.ajax({
        url,
        method: "POST",
        data: { user },
        body: { user },
        success: function (data) {
        },
        error: function () {
          console.log("Cannot get data");
        },
      });
    });
  });
});
