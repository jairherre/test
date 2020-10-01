<div class="tg-courses-wrap">
  <?php
  if ($courses) {
    foreach ($courses as $course) {
      setup_postdata($course);
  ?>
      <div class="tg-course-item-wrapper">
        <div class="tg-course-item">
          <?php the_course_overview_thumbnail($course); ?>
          <?php the_course_overview_title($course); ?>
          <?php the_course_overview_description($course); ?>
          <div class="tg-course-item-bottom">
            <?php the_course_overview_percentage_bar($course); ?>
            <?php the_course_overview_author($course); ?>
            <?php the_course_overview_percentage($course); ?>
          </div>
        </div>
      </div>
  <?php
    }
    wp_reset_postdata();
  }
  ?>
</div>