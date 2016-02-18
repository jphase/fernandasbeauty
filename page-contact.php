<?php
/*
 *  Template Name: Contact Page
 */

  get_header();
?>
<style>
#map {
  height: 100%;
  min-height: 375px;
  color: #020202;
}
#map a {
  color: blue;
}
#info {
  text-align: center;
  margin-bottom: 40px;
}
</style>
<main id="main">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 <?php echo ci_get_layout_classes( 'blog', 'content' ); ?>">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'inc_section_titles' ); ?>

          <article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
            <?php if ( ci_has_image_to_show() ) : ?>
              <figure class="entry-thumb">
                <a href="<?php echo ci_get_featured_image_src( 'large' ); ?>" data-rel="prettyPhoto">
                  <?php ci_the_post_thumbnail(); ?>
                </a>
              </figure>
            <?php endif; ?>

            <div class="entry-content">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <?php the_content(); ?>
                  <?php wp_link_pages(); ?>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div id="info">
                    <h4><?php _e( "Fernanda's Beauty", 'ci_theme' ); ?></h4>
                    5005 Collins Ave<br>
                    Miami Beach, FL 33140<br>
                    <a href="tel:+13058670108">(305) 867-0108</a>
                  </div>
                  <iframe width="100%" height="365" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=5005+Collins,+Miami+Beach+-+Florida&amp;sll=37.0625,-95.677068&amp;sspn=33.901528,78.662109&amp;ie=UTF8&amp;hq=&amp;hnear=5005+Collins+Ave,+Miami+Beach,+Miami-Dade,+Florida+33140&amp;ll=25.836359,-80.116768&amp;spn=0.009406,0.019205&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
                </div>
              </div>
            </div>
          </article>

          <!-- <div id="map"></div> -->

          <?php comments_template(); ?>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</main>
<script>
  // This example displays a marker at the center of Australia.
  // When the user clicks the marker, an info window opens.
  // The maximum width of the info window is set to 200 pixels.

  function initMap() {
    var fernandas = {lat: 25.8262997, lng: -80.1211605};
    var center = {lat: 25.8362997, lng: -80.1211605};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: center,
      scrollwheel: false
    });

    var contentString = jQuery('#info').html();

    var infowindow = new google.maps.InfoWindow({
      content: contentString,
      maxWidth: 200
    });

    var marker = new google.maps.Marker({
      position: fernandas,
      map: map,
      title: 'Uluru (Ayers Rock)'
    });

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });

    infowindow.open(map, marker);
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvtrJRPD91DlzlsMCOvy_HGWcgxav2OO4&signed_in=true&callback=initMap"></script>

<?php get_footer(); ?>