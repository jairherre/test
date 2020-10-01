$tg = jQuery.noConflict();
$tg(function () {
  $tg(".widget-section-header").on("click", function () {
    $tg(this).next("ul").toggle();
  });
  $tg(".lessons-widget-openall").on("click", function () {
    var show = true;
    var section = $tg(this).attr("sec-data");

    $tg(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        if (!$tg(this).is(":visible")) {
          show = false;
        }
      });
    if (show) {
      $tg(this).html('Open All <i class="fas fa-angle-down"></i>');
      $tg(".lessons-widget-cont")
        .children("ul")
        .each(function () {
          $tg(this).hide();
        });
      tgOpenedSection(section);
    } else {
      $tg(this).html('Close All <i class="fas fa-angle-up"></i>');
      $tg(".lessons-widget-cont")
        .children("ul")
        .each(function () {
          $tg(this).show();
        });
    }
  });

  $tg(".lesson-title").on("click", function () {
    var delay_elem = $tg(this).nextAll(".lesson-delay:first");
    $tg(delay_elem).animate({ color: "#ff0000" }, "slow");
    $tg(delay_elem).animate({ color: "#8B8B8B" }, "slow");
  });

  $tg(document).ready(function () {
    $tg(".tg-lessons-widget").tooltip();
  });
});
function tgOpenedSection(section) {
  if (section == "open_all") {
    if (localStorage.getItem("show") && localStorage.getItem("show") == 1) {
      localStorage.setItem("show", "2");
    } else {
      localStorage.setItem("show", "1");
    }
    $tg(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        if (localStorage.getItem("show") == "1") {
          $tg(this).show();
        } else {
          $tg(this).hide();
        }
      });
  } else if (section == "") {
    $tg(".lessons-widget-cont > ul").first().show();
  } else if (section && section !== "open_all" && section !== "") {
    $tg(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        $tg(this).hide();
      });
    $tg(".lessons-widget-cont > ul.sec-" + section).show();
  } else {
    $tg(".lessons-widget-cont")
      .children("ul")
      .each(function () {
        $tg(this).hide();
      });

    $tg(".lessons-widget-cont > ul.sec-0").show();
  }
}

$tg(function () {
  var testing = false;
  $tg("#mark-lesson-complete-submit").click(function () {
    $tg
      .ajax({
        method: "POST",
        dataType: "json",
        async: false,
        data: { option: "markCompletePreSubmit", l_id: $tg("#l_id").val() },
      })
      .done(function (res) {
        if (res.status == "success") {
          testing = true;
          $tg("#mark-lesson-complete").submit();
        } else {
          alert(res.msg);
        }
      });
    return testing;
  });

  $tg("#mark-lesson-uncomplete-submit").click(function () {
    $tg
      .ajax({
        method: "POST",
        dataType: "json",
        async: false,
        data: { option: "markUncompletePreSubmit", l_id: $tg("#l_id").val() },
      })
      .done(function (res) {
        if (res.status == "success") {
          testing = true;
          $tg("#mark-lesson-uncomplete").submit();
        } else {
          alert(res.msg);
        }
      });
    return testing;
  });
});

/* $tg(function () {
  var dialog;
  function doCourseCompleteAction() {
    if ($tg("#course-complete-popup").dialog().data("redirect") != "") {
      window.location.href = $tg("#course-complete-popup")
        .dialog()
        .data("redirect");
    } else {
      dialog.dialog("close");
    }
  }
  dialog = $tg("#course-complete-popup").dialog({
    autoOpen: true,
    modal: true,
    buttons: {
      Ok: doCourseCompleteAction,
    },
  });
}); */

$tg(function () {
  var dialog;
  dialog = $tg("#course-complete-popup").dialog({
    autoOpen: true,
    modal: true,
  });
});
