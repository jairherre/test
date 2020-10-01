<div class="ap-table access-log-wrap">

<h3><?php echo get_the_title($am_id);?></h3>

<?php
$courses = tg_get_courses_from_am_id($am_id);
if(is_array($courses)){
echo '<ul class="courses-ul">';
  foreach($courses as $cid){
    $course_completion_data = tg_get_user_lesson_completion_data($cid,$user_id);

    echo '<li>';
      echo '<span class="caret"><strong>';
      echo get_the_title($cid);
      echo '</strong></span>';

      echo ' - ';
      echo $course_completion_data['percentage'] .'%' . ' ' .  __('is completed','teachground');

      $sections = tg_get_sections_from_course_id($cid);

      if(is_array($sections)){
        echo '<ul class="sections-ul nested">';
        foreach($sections as $section){
          echo '<li>';
            echo '<span class="caret"><strong>';
            echo tg_get_section_name($section->s_id);
            echo '</strong></span>';

            $lessons = tg_get_lessons_from_section_id($section->s_id);
            if($lessons){
              echo '<ul class="nested">';
              foreach($lessons as $lesson){
                $is_complete = tg_is_lesson_marked_as_completed( $user_id, $lesson->l_id );
                echo '<li>';
                  echo get_the_title($lesson->l_id);
                  echo ' - ';
                  echo ( $is_complete == true?TG_COMPLETED_IMAGE:TG_NOT_COMPLETED_IMAGE );
                echo '</li>';
              }
              echo '</ul>'; // end of "lessons-ul
            }
          echo '</li>';
        }
        echo '</ul>'; // end of "sections-ul
      }
    echo '</li>';
  }
echo '</ul>'; // end of "courses-ul
}
?>

</div>