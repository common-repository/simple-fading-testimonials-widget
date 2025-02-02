<?php
/* Create widget */
class wp_simple_fading_testimonials extends WP_Widget {

// constructor
function wp_simple_fading_testimonials() {
  parent::WP_Widget(false, $name = __('Simple Fading Testimonials', 'simple-fading-testimonials-widget') );
}

// widget form creation
function form($instance) {
    
// check values
if( $instance) {
     $widget_custom_title = esc_attr($instance['widget_custom_title']);
     $number_testimonials = esc_attr($instance['number_testimonials']);
     $duration_testimonial = esc_attr($instance['duration_testimonial']);
     $speed_transition = esc_attr($instance['speed_transition']);
     $author_prefix = esc_attr($instance['author_prefix']);
     $author_delay = esc_attr($instance['author_delay']);
     $author_fade_speed = esc_attr($instance['author_fade_speed']);
} else {
     $widget_title = '';
     $number_testimonials = '';
     $duration_testimonial = '';
     $speed_transition = '';
     $author_prefix = '';
     $author_delay = '';
     $author_fade_speed = '';
} ?>

<!-- credits -->

<p><i><a href="https://en-gb.wordpress.org/plugins/simple-fading-testimonials-widget/" target="_blank">Simple Fading Testimonials </a> by <a href="https://www.stephenkempin.co.uk/" target="_blank">Stephen Kempin</a></i></p>
<hr>

<!-- set widget title -->
<p>
  <label for="<?php echo $this->get_field_id('widget_custom_title'); ?>"><?php _e('Widget Title <em>(leave blank for none)</em>:', 'simple-fading-testimonials-widget'); ?></label>
  <br><input id="<?php echo $this->get_field_id('widget_custom_title'); ?>" name="<?php echo $this->get_field_name('widget_custom_title'); ?>" type="text" value="<?php echo $widget_custom_title; ?>" />
</p>

<!-- set number of testimonials -->
<p>
<label for="<?php echo $this->get_field_id('number_testimonials'); ?>"><?php _e('Number of testimonials to display:', 'simple-fading-testimonials-widget');
  // count total posts
  $count_posts = wp_count_posts( 'testimonial' );
  // count total published testimonial posts
  $total = $count_posts->publish; //
  // cast total to integer
  $int = (int)$total;
  // create blank array
  $total_array = array();
  // populate array
  $x=1;
    while($x <= $int) {
      $total_array[] = $x;
      $x++;
  }?></label>
<select name="<?php echo $this->get_field_name('number_testimonials'); ?>" id="<?php echo $this->get_field_id('number_testimonials'); ?>" class="">
<?php
$options = $total_array;
foreach ($options as $option) {
echo '<option value="' . $option . '" id="' . $option . '"', $number_testimonials == $option ? ' selected="selected"' : '', '>', $option, '</option>';
}
?>
</select>
</p>

<!-- set duration -->
<p>
<label for="<?php echo $this->get_field_id('duration_testimonial'); ?>"><?php _e('Duration of each testimonial (<em>ms</em>):', 'simple-fading-testimonials-widget'); ?></label>
<input id="<?php echo $this->get_field_id('duration_testimonial'); ?>" name="<?php echo $this->get_field_name('duration_testimonial'); ?>" type="number" value="<?php echo (empty($duration_testimonial) ? 4000 : $duration_testimonial); ?>" size="3" />
</p>

<!-- set transition speed -->
<p>
<label for="<?php echo $this->get_field_id('speed_transition'); ?>"><?php _e('Transition speed (<em>ms</em>):', 'simple-fading-testimonials-widget'); ?></label>
<input id="<?php echo $this->get_field_id('speed_transition'); ?>" name="<?php echo $this->get_field_name('speed_transition'); ?>" type="number" value="<?php echo (empty($speed_transition) ? 500 : $speed_transition); ?>" />
</p>

<!-- set testimonial author prefix -->
<p>
<label for="<?php echo $this->get_field_id('author_prefix'); ?>"><?php _e('Author prefix:', 'simple-fading-testimonials-widget'); ?></label>
<select name="<?php echo $this->get_field_name('author_prefix'); ?>" id="<?php echo $this->get_field_id('author_prefix'); ?>" class="">
 <?php
$prefixes = array('', '-', '--', '•','~');
    foreach ($prefixes as $prefix) {
    echo '<option value="' . $prefix . '" id="' . $prefix . '"', $author_prefix == $prefix ? ' selected="selected"' : '', '>';
      // check if prefix is empty
      if ($prefix == "") {
        echo "(no prefix)";
      } else {
        echo $prefix;
      };
    echo '</option>';
}
?>
 </select>
</p>

<!-- set author delay speed -->
<p>
<label for="<?php echo $this->get_field_id('author_delay'); ?>"><?php _e('Author Delay (<em>ms</em>):', 'simple-fading-testimonials-widget'); ?></label>
<input id="<?php echo $this->get_field_id('author_delay'); ?>" name="<?php echo $this->get_field_name('author_delay'); ?>" type="number" value="<?php echo (empty($author_delay) ? 1200 : $author_delay); ?>" />
</p>


<!-- set author fade IN speed -->
<p>
<label for="<?php echo $this->get_field_id('author_fade_speed'); ?>"><?php _e('Author Fade In Speed (<em>ms</em>):', 'simple-fading-testimonials-widget'); ?></label>
<input id="<?php echo $this->get_field_id('author_fade_speed'); ?>" name="<?php echo $this->get_field_name('author_fade_speed'); ?>" type="number" value="<?php echo (empty($author_fade_speed) ? 750 : $author_fade_speed); ?>" />
</p>



<?php }
// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // assign fields
      $instance['widget_custom_title'] = strip_tags($new_instance['widget_custom_title']);
      $instance['number_testimonials'] = strip_tags($new_instance['number_testimonials']);
      $instance['duration_testimonial'] = strip_tags($new_instance['duration_testimonial']);
      $instance['speed_transition'] = strip_tags($new_instance['speed_transition']);
      $instance['author_prefix'] = strip_tags($new_instance['author_prefix']);
      $instance['author_delay'] = strip_tags($new_instance['author_delay']);
      $instance['author_fade_speed'] = strip_tags($new_instance['author_fade_speed']);
      return $instance;
}


// display widget
function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
   $widget_custom_title =  $instance['widget_custom_title'];
   $number_testimonials = (int)$instance['number_testimonials']; // cast number of testimonials to integer
   $author_prefix =  $instance['author_prefix'];
   echo $before_widget; // assign widget ID and class

    // Query Testimonials Custom Field
    $args = array(
      'posts_per_page' => $number_testimonials,
      'post_type' => 'testimonial'
    );
    // The Query
    query_posts( $args );
      if ($widget_custom_title) { // check if field is set
        echo "<h3 class=\"widget-title\">$widget_custom_title</h3>";
      };
    echo '<ul>';
    // The Loop
    while ( have_posts() ) : the_post();
        $testimonial_author = get_the_title(); // grab the title
        $testimonial_content = get_the_content(); // grab the content
            echo '<li>';
        if ($testimonial_content) { // check if field is set
            echo ''.$testimonial_content.'';
        };
            if ($testimonial_author) { // check if field is set
                echo '<span class="author">';
                if($author_prefix) { // check if field is set
                  echo $author_prefix.' ';
                };
                echo $testimonial_author. '</span>';
            };
            echo '</li>';
    endwhile;
    echo '</ul>'.$after_widget;
    // Reset Query
    wp_reset_query();
}}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_simple_fading_testimonials");'));

?>



