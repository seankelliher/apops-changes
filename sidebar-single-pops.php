<div id="secondary" class="sidebar" role="complementary">

    <!--Site Plans Widget-->
    <aside class="widget">

        <!--<h3 class="widget-title">Site Plan</h3>-->

        <div id="site-plan-thumbs">

            <figure class="site-plan">

                <img src="<?php sitePlan (); ?>" alt="thumbnail of site plan for pops" />

                <figcaption><a href="<?php sitePlan (); ?>" target="_blank">Enlarge</a></figcaption>

            </figure>

        </div> <!--close #site-plan-thumbs-->

    </aside>

    <!--General Information Widget-->
    <aside class="widget">

        <h3 class="widget-title">General Information</h3>

        <ul id="details-list" class="details-list">

            <li class="detail accordion-item"><strong class="accordion-trigger">Space Type:</strong> <?php typeOfSpace (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Required Size:</strong> <?php requiredSize (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Building Location:</strong> <?php buildingLocation (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Building Name:</strong> <?php buildingName (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Year Completed:</strong> <?php yearCompleted (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Space Designer:</strong> <?php spaceDesigner (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Building Architect:</strong> <?php buildingArchitect (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Building Owner:</strong> <?php buildingOwner (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Managing Agent:</strong> <?php managingAgent (); ?></li>
            <li class="detail accordion-item"><strong class="accordion-trigger">Access For Disabled:</strong> <?php accessForDisabled (); ?></li>
            
        </ul>

    </aside>

    <!--Hours of Access Widget-->
    <aside class="widget">

        <h3 class="widget-title">Hours of Access</h3>

        <ul id="details-list" class="details-list">

            <?php hoursOfAccess (); ?>
            <?php closingForEvents (); ?>
            
        </ul>

    </aside>

    <!--Required Amenities Widget-->
    <aside class="widget">

        <h3 class="widget-title">Required Amenities</h3>

        <ul id="details-list" class="details-list">

            <?php requiredAmenitiesVertical (); ?>
            
        </ul>

    </aside>

    <!--Permitted Amenities Widget-->
    <aside class="widget">

        <h3 class="widget-title">Permitted Amenities</h3>

        <ul id="details-list" class="details-list">

            <?php permittedAmenitiesVertical (); ?>
            
        </ul>

    </aside>

    <!--Updated On This Date Widget-->
    <?php if (get_option('pops_updated_date')): ?>

      <p class="updated-note">Note: <?php echo get_option('pops_updated_date'); ?></p>
      <hr />
      
    <?php endif; ?>

  </div> <!-- /.side-bar -->
