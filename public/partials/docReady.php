<?php 
function neccessary_codes_for_sft(){
     $admin_sft_settings = new wp_simple_fading_testimonials();
     $settings = $admin_sft_settings->get_settings();
     $instance_key = key($settings);

     // Set vars
     $speed_transition = $settings[$instance_key][speed_transition];
     $duration_testimonial = $settings[$instance_key][duration_testimonial];
     $author_delay = $settings[$instance_key][author_delay];
     $author_fade_speed = $settings[$instance_key][author_fade_speed];
     
?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
    
        $(".widget_wp_simple_fading_testimonials").fader({
             fadeSpeed: <?php echo $speed_transition; ?>,
             duration: <?php echo $duration_testimonial; ?>,
             authorDelay: <?php echo $author_delay; ?>,
             authorFadeSpeed: <?php echo $author_fade_speed; ?>
        })
    
        var totalHeight = []; // create new array
    
        // loop through each li to obtain height
        $('.widget_wp_simple_fading_testimonials li').each(function() {
            totalHeight.push($(this).height()); // push each li height to array
             $(this).height( $(this).height() ); // set li height
        });
        var maxHeight = Math.max.apply(Math, totalHeight); // find max li height used
        $(".widget_wp_simple_fading_testimonials ul").height(maxHeight); // assign that height to widget
    
    });
</script>

<?php }
add_action('wp_footer', 'neccessary_codes_for_sft');