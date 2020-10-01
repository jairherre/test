$lms = jQuery.noConflict();
$lms(function () {
  $lms(".widget-section-header").on("click", function () {
    $lms(this).next("ul").toggle();
  });
  $lms(".lessons-widget-openall").on("click", function () {
    var show = true;
    var section = $lms(this).attr("sec-data");

    $lms(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        if (!$lms(this).is(":visible")) {
          show = false;
        }
      });
    if (show) {
      $lms(this).html('Open All <i class="fas fa-angle-down"></i>');
      $lms(".lessons-widget-cont")
        .children("ul")
        .each(function () {
          $lms(this).hide();
        });
      lmsOpenedSection(section);
    } else {
      $lms(this).html('Close All <i class="fas fa-angle-up"></i>');
      $lms(".lessons-widget-cont")
        .children("ul")
        .each(function () {
          $lms(this).show();
        });
    }
  });

  $lms(".lesson-title").on("click", function () {
    var delay_elem = $lms(this).nextAll(".lesson-delay:first");
    $lms(delay_elem).animate({ color: "#ff0000" }, "slow");
    $lms(delay_elem).animate({ color: "#8B8B8B" }, "slow");
  });

  $lms(document).ready(function () {
    $lms(".lms-lessons-widget").tooltip();
  });
});
function lmsOpenedSection(section) {
  if (section == "open_all") {
    if (localStorage.getItem("show") && localStorage.getItem("show") == 1) {
      localStorage.setItem("show", "2");
    } else {
      localStorage.setItem("show", "1");
    }
    $lms(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        if (localStorage.getItem("show") == "1") {
          $lms(this).show();
        } else {
          $lms(this).hide();
        }
      });
  } else if (section == "") {
    $lms(".lessons-widget-cont > ul").first().show();
  } else if (section && section !== "open_all" && section !== "") {
    $lms(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        $lms(this).hide();
      });
    $lms(".lessons-widget-cont > ul.sec-" + section).show();
  } else {
    $lms(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        $lms(this).hide();
      });

    $lms(".lessons-widget-cont > ul.sec-0").show();
  }
}

$lms(function () {
  var testing = false;
  $lms("#mark-lesson-complete-submit").click(function () {
    $lms
      .ajax({
        method: "POST",
        dataType: "json",
        async: false,
        data: { option: "markCompletePreSubmit", l_id: $lms("#l_id").val() },
      })
      .done(function (res) {
        if (res.status == "success") {
          testing = true;
          $lms("#mark-lesson-complete").submit();
        } else {
          alert(res.msg);
        }
      });
    return testing;
  });

  $lms("#mark-lesson-uncomplete-submit").click(function () {
    $lms
      .ajax({
        method: "POST",
        dataType: "json",
        async: false,
        data: { option: "markUncompletePreSubmit", l_id: $lms("#l_id").val() },
      })
      .done(function (res) {
        if (res.status == "success") {
          testing = true;
          $lms("#mark-lesson-uncomplete").submit();
        } else {
          alert(res.msg);
        }
      });
    return testing;
  });
});

/* $lms(function () {
  var dialog;
  function doCourseCompleteAction() {
    if ($lms("#course-complete-popup").dialog().data("redirect") != "") {
      window.location.href = $lms("#course-complete-popup")
        .dialog()
        .data("redirect");
    } else {
      dialog.dialog("close");
    }
  }
  dialog = $lms("#course-complete-popup").dialog({
    autoOpen: true,
    modal: true,
    buttons: {
      Ok: doCourseCompleteAction,
    },
  });
}); */

$lms(function () {
  var dialog;
  dialog = $lms("#course-complete-popup").dialog({
    autoOpen: true,
    modal: true,
  });
});
