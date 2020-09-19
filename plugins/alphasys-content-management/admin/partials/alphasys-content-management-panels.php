<?php
$allavailablepanels = ASCM_Panels_Helper::get_allavailablepanels();
$allavailablepages = ASCM_Panels_Helper::get_allavailablepages();

$sortedpages = [];

foreach ($allavailablepages as $key => $value) {
    $posttype = $value['post_type'];

    if ( ! isset( $sortedpages[$posttype] ) || ! is_array( $sortedpages[$posttype] ) ) {
        $sortedpages[$posttype] = array();
    }

    $sortedpages[$posttype][] = $value;
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<div id="ascm-mod-settings-main-cont-panels" class="ascm-mod-settings-main-cont">
	<div id="ascm-mod-settings-sub-cont-panels" class="ascm-mod-settings-sub-cont">

		<div class="ascm-panels-availablepanels-intro-cont">
            <label><?php _e( 'Available Panels', 'ascm' ); ?></label><br>
            <small><i><?php _e( 'Below are icons that represents a panel type base on the capability of the panel created.', 'ascm' ); ?></i></small><br><br>
            <div class="ascm-panels-availablepanels-legends-cont">
                <div class=" ascm-field-col s12 m12 l6">
                    <div><i class="fas fa-align-left"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Panel as Content', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fa-universal-access"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Parent Panel', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fa-clipboard"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Default', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fas fa-address-card"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Half Image', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fa-th"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Post Category', 'ascm' ); ?></b></small></div>
                </div>
                <div class="ascm-field-col s12 m12 l6">
                    <div><i class="fas fa-newspaper"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Recent Posts', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fa-th-large"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Tile Menu', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fa-film"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Video', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fa-images"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'With Image', 'ascm' ); ?></b></small></div>
                    <div><i class="fas fa-mortar-pestle"></i><small style="margin-left: 10px;"><b style="color: #fe9876;"><?php _e( 'Custom Panel', 'ascm' ); ?></b></small></div>
                </div>
                <div class="ascm-panels-availablepanels-viewpanels-btn-cont ascm-field-col s12 m12 l12">
                    <span id="ascm-panels-availablepanels-viewpanels-btn" class="ascm-panels-availablepanels-viewpanels-btn"><?php _e( 'View Available Panels', 'ascm' ); ?></span>
                </div>
            </div>

            <!-- Panels On Pages Available Pages -->
	        <div id="ascm-panels-availablepanels-main-cont" class="ascm-panels-availablepanels-main-cont ascm_panels_hide animated fadeInLeft faster">
	            <div class="ascm-panels-availablepanels-header-cont"><label><?php _e( 'Available Panels.', 'ascm' ); ?></label><span id="ascm-panels-availablepanels-closepanels-btn"><i class="fas fa-times"></i></span></div>
	            <div class="ascm-panels-availablepanels-info-cont">
	                <small><i><label><?php _e( 'Choose panels here and drag to any part of the page entity then drop the desired panel to a page body part.', 'ascm' ); ?></i></small><br><br>
	            </div>
	            <div class="ascm-panels-availablepanels-sub-cont">
	                <div id="ascm_panels_availablepanels_items_cont" class="list-group col">
				        <?php foreach ($allavailablepanels as $key => $value) :
	                        $fontawesomeicon = isset($value['fontawesomeicon']) ? $value['fontawesomeicon'] : '';
	                        $title = isset($value['title']) ? $value['title'] : '';
	                        $edit_url = isset($value['edit_url']) ? $value['edit_url'] : '';
	                    ?>
	                        <div data-id="<?php echo '[ascm-panels id='.$key.']'; ?>" class="ascm-panels-panel-item list-group-item">
	                            <span><?php echo $fontawesomeicon; ?></span>
	                            <span style="margin-left: 15px;">
									<?php echo $title; ?>
								</span>
	                            <span class="js-edit">
	                                <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
	                            </span>
	                            <span class="js-remove"><i class="fas fa-trash"></i></span>
	                        </div>
				        <?php endforeach; ?>
	                </div>
	            </div>
	        </div>
	        <!-- Panels On Pages Available Pages -->		        
        </div>

        <!-- Panels On Pages -->
		<div id="ascm-mod-settings-fields-cont-panels" class="ascm-mod-settings-fields-cont">
			<div class="ascm-mod-settings-section-title"><?php _e( 'Panels on Pages', 'ascm' ); ?></div>

			<div class="ascm-mod-settings-field-cont ascm-field-col s12 m12 l12">
				<div class="ascm-panels-availablepages_cont">
					<div style="margin-bottom: 10px;">
						<label><?php _e( 'Available Pages', 'ascm' ); ?></label><br>
						<small><i><?php _e( 'Select the desired page here to toggle the page entity available below.', 'ascm' ); ?></i></small><br>
						<select id="ascm_panels_availablepages" style="width: 100%;">
                            <?php foreach ( $sortedpages as $key => $pages ) : ?>
                                <optgroup label="<?php echo ucwords( $key ); ?>" style="color:#32373c;">
                                    <?php foreach ( $pages as $key => $value ) : ?>
                                        <option value="<?php echo $value['post_id'] ;?>"><?php echo $value['title']; ?></option>
                                    <?php endforeach; ?>    
                                </optgroup>
                            <?php endforeach; ?>
						</select>
					</div>


                    <?php if(has_action('genesis_init') == false): ?>

                        <small><b>Note: </b><i> <?php _e( 'Below is the entity which represents the page overview of a page body. The entity consist the standard body parts of a web page. Only four body parts can be filled with panels. This body parts are "After Header", "Before Content", "After Content" and "Before Content".', 'ascm' ); ?></i></small><br><br>

                        <!-- Render Standard Element -->
                        <?php foreach ($allavailablepages as $key => $value) : ?>
                        <div id="<?php echo 'ascm_panels_page_'.$key.'_cont'; ?>" class="ascm_panels_pagepanel_cont">
                            <label><?php echo $value['title']; ?></label>

                            <div class="ascm-panels-entity-cont">HEADER</div>

                            <div class="ascm-panels-availablepages_items_label">After Header</div>
                            <div id="<?php echo 'ascm_panels_page_'.$key.'_afterheader'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

                                <?php
                                $allavailablepages_afterheader = isset($value['afterheader']) ? $value['afterheader'] : array();
                                $allavailablepages_afterheader = is_array($allavailablepages_afterheader) ? $allavailablepages_afterheader : array();
                                foreach ($allavailablepages_afterheader as $afterheader_value) :
                                $afterheader_value = str_replace('[ascm-panels id=','', $afterheader_value);
                                $afterheader_value = str_replace(']','', $afterheader_value);

                                $fontawesomeicon = isset($allavailablepanels[$afterheader_value]['fontawesomeicon']) ? $allavailablepanels[$afterheader_value]['fontawesomeicon'] : '';
                                $title = isset($allavailablepanels[$afterheader_value]['title']) ? $allavailablepanels[$afterheader_value]['title'] : '';
                                $edit_url = isset($allavailablepanels[$afterheader_value]['edit_url']) ? $allavailablepanels[$afterheader_value]['edit_url'] : '';
                                ?>

                                <div data-id="<?php echo '[ascm-panels id='.$afterheader_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                    <span><?php echo $fontawesomeicon; ?></span>
                                    <span style="margin-left: 15px;">
                                        <?php echo $title; ?>
                                    </span>
                                    <span class="js-edit">
                                        <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                    </span>
                                    <span class="js-remove"><i class="fas fa-trash"></i></span>
                                </div>

                                <?php endforeach; ?>

                            </div>

                            <div style="display: flex;">

                                <span style="width: 600px; display: block;">

                                    <div class="ascm-panels-availablepages_items_label">Before Content</div>
                                    <div id="<?php echo 'ascm_panels_page_'.$key.'_beforecontent'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

                                        <?php
                                        $allavailablepages_beforecontent = isset($value['beforecontent']) ? $value['beforecontent'] : array();
                                        $allavailablepages_beforecontent = is_array($allavailablepages_beforecontent) ? $allavailablepages_beforecontent : array();
                                        foreach ($allavailablepages_beforecontent as $beforecontent_value) :
                                        $beforecontent_value = str_replace('[ascm-panels id=','', $beforecontent_value);
                                        $beforecontent_value = str_replace(']','', $beforecontent_value);

                                        $fontawesomeicon = isset($allavailablepanels[$beforecontent_value]['fontawesomeicon']) ? $allavailablepanels[$beforecontent_value]['fontawesomeicon'] : '';
                                        $title = isset($allavailablepanels[$beforecontent_value]['title']) ? $allavailablepanels[$beforecontent_value]['title'] : '';
                                        $edit_url = isset($allavailablepanels[$beforecontent_value]['edit_url']) ? $allavailablepanels[$beforecontent_value]['edit_url'] : '';
                                        ?>

                                        <div data-id="<?php echo '[ascm-panels id='.$beforecontent_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                            <span><?php echo $fontawesomeicon; ?></span>
                                            <span style="margin-left: 15px;">
                                                <?php echo $title; ?>
                                            </span>
                                            <span class="js-edit">
                                                <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                            </span>
                                            <span class="js-remove"><i class="fas fa-trash"></i></span>
                                        </div>

                                        <?php endforeach; ?>

                                    </div>

                                    <div class="ascm-panels-entity-cont">CONTENT</div>

                                    <div class="ascm-panels-availablepages_items_label">After Content</div>
                                    <div id="<?php echo 'ascm_panels_page_'.$key.'_aftercontent'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

                                        <?php
                                        $allavailablepages_aftercontent = isset($value['aftercontent']) ? $value['aftercontent'] : array();
                                        $allavailablepages_aftercontent = is_array($allavailablepages_aftercontent) ? $allavailablepages_aftercontent : array();
                                        foreach ($allavailablepages_aftercontent as $aftercontent_value) :
                                        $aftercontent_value = str_replace('[ascm-panels id=','', $aftercontent_value);
                                        $aftercontent_value = str_replace(']','', $aftercontent_value);

                                        $fontawesomeicon = isset($allavailablepanels[$aftercontent_value]['fontawesomeicon']) ? $allavailablepanels[$aftercontent_value]['fontawesomeicon'] : '';
                                        $title = isset($allavailablepanels[$aftercontent_value]['title']) ? $allavailablepanels[$aftercontent_value]['title'] : '';
                                        $edit_url = isset($allavailablepanels[$aftercontent_value]['edit_url']) ? $allavailablepanels[$aftercontent_value]['edit_url'] : '';
                                        ?>

                                        <div data-id="<?php echo '[ascm-panels id='.$aftercontent_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                            <span><?php echo $fontawesomeicon; ?></span>
                                            <span style="margin-left: 15px;">
                                                <?php echo $title; ?>
                                            </span>
                                            <span class="js-edit">
                                                <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                            </span>
                                            <span class="js-remove"><i class="fas fa-trash"></i></span>
                                        </div>

                                        <?php endforeach; ?>

                                    </div>

                                </span>

                                <span style="width: 165px; display: block; margin-left: 20px;">
                                    <div class="ascm-panels-entity-cont" style="height: 90%;">SIDEBAR</div>
                                </span>

                            </div>



                            <div class="ascm-panels-availablepages_items_label">Before Footer</div>
                            <div id="<?php echo 'ascm_panels_page_'.$key.'_beforefooter'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

                                <?php
                                $allavailablepages_beforefooter = isset($value['beforefooter']) ? $value['beforefooter'] : array();
                                $allavailablepages_beforefooter = is_array($allavailablepages_beforefooter) ? $allavailablepages_beforefooter : array();
                                foreach ($allavailablepages_beforefooter as $beforefooter_value) :
                                $beforefooter_value = str_replace('[ascm-panels id=','', $beforefooter_value);
                                $beforefooter_value = str_replace(']','', $beforefooter_value);

                                $fontawesomeicon = isset($allavailablepanels[$beforefooter_value]['fontawesomeicon']) ? $allavailablepanels[$beforefooter_value]['fontawesomeicon'] : '';
                                $title = isset($allavailablepanels[$beforefooter_value]['title']) ? $allavailablepanels[$beforefooter_value]['title'] : '';
                                $edit_url = isset($allavailablepanels[$beforefooter_value]['edit_url']) ? $allavailablepanels[$beforefooter_value]['edit_url'] : '';
                                ?>

                                <div data-id="<?php echo '[ascm-panels id='.$beforefooter_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                    <span><?php echo $fontawesomeicon; ?></span>
                                    <span style="margin-left: 15px;">
                                        <?php echo $title; ?>
                                    </span>
                                    <span class="js-edit">
                                        <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                    </span>
                                    <span class="js-remove"><i class="fas fa-trash"></i></span>
                                </div>

                                <?php endforeach; ?>

                            </div>

                            <div class="ascm-panels-entity-cont">FOOTER</div>

                        </div>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <small><b>Note: </b><i>The plugin has detected that the site is using Genesis Theme and below is the entity which represents the page overview of a page body base on the Genesis page layout set on every page.</i></small><br><br>


                        <!-- Render Genesis Element -->
                        <?php foreach ($allavailablepages as $key => $value) : ?>
                        <div id="<?php echo 'ascm_panels_page_'.$key.'_cont'; ?>" class="ascm_panels_pagepanel_cont">
                            <label><?php echo $value['title']; ?>
                                <div><small>(Genesis Theme Page Layout)</small></div>
                            </label>
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/genesis-icon-white-200x200.png'; ?>">

                            <div class="ascm-panels-availablepages_items_label">Genesis Before Header (genesis_before_header)</div>
                            <div id="<?php echo 'ascm_panels_page_'.$key.'_genesisbeforeheader'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

		                        <?php
		                        $allavailablepages_genesisbeforeheader = isset($value['genesisbeforeheader']) ? $value['genesisbeforeheader'] : array();
		                        $allavailablepages_genesisbeforeheader = is_array($allavailablepages_genesisbeforeheader) ? $allavailablepages_genesisbeforeheader : array();
		                        foreach ($allavailablepages_genesisbeforeheader as $genesisbeforeheader_value) :
			                        $genesisbeforeheader_value = str_replace('[ascm-panels id=','', $genesisbeforeheader_value);
			                        $genesisbeforeheader_value = str_replace(']','', $genesisbeforeheader_value);

			                        $fontawesomeicon = isset($allavailablepanels[$genesisbeforeheader_value]['fontawesomeicon']) ? $allavailablepanels[$genesisbeforeheader_value]['fontawesomeicon'] : '';
			                        $title = isset($allavailablepanels[$genesisbeforeheader_value]['title']) ? $allavailablepanels[$genesisbeforeheader_value]['title'] : '';
			                        $edit_url = isset($allavailablepanels[$genesisbeforeheader_value]['edit_url']) ? $allavailablepanels[$genesisbeforeheader_value]['edit_url'] : '';
			                        ?>

                                    <div data-id="<?php echo '[ascm-panels id='.$genesisbeforeheader_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                        <span><?php echo $fontawesomeicon; ?></span>
                                        <span style="margin-left: 15px;">
                                            <?php echo $title; ?>
                                        </span>
                                        <span class="js-edit">
                                            <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                        </span>
                                        <span class="js-remove"><i class="fas fa-trash"></i></span>
                                    </div>

		                        <?php endforeach; ?>

                            </div>

                            <div class="ascm-panels-entity-cont">Navigation</div>
                            <div class="ascm-panels-entity-cont">HEADER</div>

                            <div class="ascm-panels-availablepages_items_label">Genesis After Header (genesis_after_header)</div>
                            <div id="<?php echo 'ascm_panels_page_'.$key.'_genesisafterheader'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

		                        <?php
		                        $allavailablepages_genesisafterheader = isset($value['genesisafterheader']) ? $value['genesisafterheader'] : array();
		                        $allavailablepages_genesisafterheader = is_array($allavailablepages_genesisafterheader) ? $allavailablepages_genesisafterheader : array();
		                        foreach ($allavailablepages_genesisafterheader as $genesisafterheader_value) :
			                        $genesisafterheader_value = str_replace('[ascm-panels id=','', $genesisafterheader_value);
			                        $genesisafterheader_value = str_replace(']','', $genesisafterheader_value);

			                        $fontawesomeicon = isset($allavailablepanels[$genesisafterheader_value]['fontawesomeicon']) ? $allavailablepanels[$genesisafterheader_value]['fontawesomeicon'] : '';
			                        $title = isset($allavailablepanels[$genesisafterheader_value]['title']) ? $allavailablepanels[$genesisafterheader_value]['title'] : '';
			                        $edit_url = isset($allavailablepanels[$genesisafterheader_value]['edit_url']) ? $allavailablepanels[$genesisafterheader_value]['edit_url'] : '';
			                        ?>

                                    <div data-id="<?php echo '[ascm-panels id='.$genesisafterheader_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                        <span><?php echo $fontawesomeicon; ?></span>
                                        <span style="margin-left: 15px;">
                                            <?php echo $title; ?>
                                        </span>
                                        <span class="js-edit">
                                            <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                        </span>
                                        <span class="js-remove"><i class="fas fa-trash"></i></span>
                                    </div>

		                        <?php endforeach; ?>

                            </div>

                            <div style="display: flex;">

	                            <?php if($value['genesispagelayout'] == 'sidebar-content') :?>
                                    <span style="width: 165px; display: block; margin-right: 20px;">
                                    <div class="ascm-panels-entity-cont" style="height: 90%;">SIDEBAR</div>
                                </span>
	                            <?php endif; ?>

	                            <?php if($value['genesispagelayout'] == 'full-width-content') :?>
                                <span style="width: 100%; display: block;">
                                <?php else: ?>
                                <span style="width: 600px; display: block;">
                                <?php endif; ?>

                                    <div class="ascm-panels-availablepages_items_label">Genesis Before Entry (genesis_before_entry)</div>
                                    <div id="<?php echo 'ascm_panels_page_'.$key.'_genesisbeforeentry'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

                                        <?php
                                        $allavailablepages_genesisbeforeentry = isset($value['genesisbeforeentry']) ? $value['genesisbeforeentry'] : array();
                                        $allavailablepages_genesisbeforeentry = is_array($allavailablepages_genesisbeforeentry) ? $allavailablepages_genesisbeforeentry : array();
                                        foreach ($allavailablepages_genesisbeforeentry as $genesisbeforeentry_value) :
	                                        $genesisbeforeentry_value = str_replace('[ascm-panels id=','', $genesisbeforeentry_value);
	                                        $genesisbeforeentry_value = str_replace(']','', $genesisbeforeentry_value);

	                                        $fontawesomeicon = isset($allavailablepanels[$genesisbeforeentry_value]['fontawesomeicon']) ? $allavailablepanels[$genesisbeforeentry_value]['fontawesomeicon'] : '';
	                                        $title = isset($allavailablepanels[$genesisbeforeentry_value]['title']) ? $allavailablepanels[$genesisbeforeentry_value]['title'] : '';
	                                        $edit_url = isset($allavailablepanels[$genesisbeforeentry_value]['edit_url']) ? $allavailablepanels[$genesisbeforeentry_value]['edit_url'] : '';
	                                        ?>

                                            <div data-id="<?php echo '[ascm-panels id='.$genesisbeforeentry_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                            <span><?php echo $fontawesomeicon; ?></span>
                                            <span style="margin-left: 15px;">
                                                <?php echo $title; ?>
                                            </span>
                                            <span class="js-edit">
                                                <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                            </span>
                                            <span class="js-remove"><i class="fas fa-trash"></i></span>
                                        </div>

                                        <?php endforeach; ?>

                                    </div>

                                    <div class="ascm-panels-entity-cont">CONTENT</div>

                                    <div class="ascm-panels-availablepages_items_label">Genesis After Entry (genesis_after_entry)</div>
                                    <div id="<?php echo 'ascm_panels_page_'.$key.'_genesisafterentry'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

                                        <?php
                                        $allavailablepages_genesisafterentry = isset($value['genesisafterentry']) ? $value['genesisafterentry'] : array();
                                        $allavailablepages_genesisafterentry = is_array($allavailablepages_genesisafterentry) ? $allavailablepages_genesisafterentry : array();
                                        foreach ($allavailablepages_genesisafterentry as $genesisafterentry_value) :
	                                        $genesisafterentry_value = str_replace('[ascm-panels id=','', $genesisafterentry_value);
	                                        $genesisafterentry_value = str_replace(']','', $genesisafterentry_value);

	                                        $fontawesomeicon = isset($allavailablepanels[$genesisafterentry_value]['fontawesomeicon']) ? $allavailablepanels[$genesisafterentry_value]['fontawesomeicon'] : '';
	                                        $title = isset($allavailablepanels[$genesisafterentry_value]['title']) ? $allavailablepanels[$genesisafterentry_value]['title'] : '';
	                                        $edit_url = isset($allavailablepanels[$genesisafterentry_value]['edit_url']) ? $allavailablepanels[$genesisafterentry_value]['edit_url'] : '';
	                                        ?>

                                            <div data-id="<?php echo '[ascm-panels id='.$genesisafterentry_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                            <span><?php echo $fontawesomeicon; ?></span>
                                            <span style="margin-left: 15px;">
                                                <?php echo $title; ?>
                                            </span>
                                            <span class="js-edit">
                                                <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                            </span>
                                            <span class="js-remove"><i class="fas fa-trash"></i></span>
                                        </div>

                                        <?php endforeach; ?>
                                    </div>

                                </span>

                                <?php if($value['genesispagelayout'] == 'content-sidebar') :?>
                                <span style="width: 165px; display: block; margin-left: 20px;">
                                    <div class="ascm-panels-entity-cont" style="height: 90%;">SIDEBAR</div>
                                </span>
                                <?php endif; ?>

                            </div>


                            <div class="ascm-panels-availablepages_items_label">Genesis Before Footer (genesis_before_footer)</div>
                            <div id="<?php echo 'ascm_panels_page_'.$key.'_genesisbeforefooter'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

		                        <?php
		                        $allavailablepages_genesisbeforefooter = isset($value['genesisbeforefooter']) ? $value['genesisbeforefooter'] : array();
		                        $allavailablepages_genesisbeforefooter = is_array($allavailablepages_genesisbeforefooter) ? $allavailablepages_genesisbeforefooter : array();
		                        foreach ($allavailablepages_genesisbeforefooter as $genesisbeforefooter_value) :
			                        $genesisbeforefooter_value = str_replace('[ascm-panels id=','', $genesisbeforefooter_value);
			                        $genesisbeforefooter_value = str_replace(']','', $genesisbeforefooter_value);

			                        $fontawesomeicon = isset($allavailablepanels[$genesisbeforefooter_value]['fontawesomeicon']) ? $allavailablepanels[$genesisbeforefooter_value]['fontawesomeicon'] : '';
			                        $title = isset($allavailablepanels[$genesisbeforefooter_value]['title']) ? $allavailablepanels[$genesisbeforefooter_value]['title'] : '';
			                        $edit_url = isset($allavailablepanels[$genesisbeforefooter_value]['edit_url']) ? $allavailablepanels[$genesisbeforefooter_value]['edit_url'] : '';
			                        ?>

                                    <div data-id="<?php echo '[ascm-panels id='.$genesisbeforefooter_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                        <span><?php echo $fontawesomeicon; ?></span>
                                        <span style="margin-left: 15px;">
                                            <?php echo $title; ?>
                                        </span>
                                        <span class="js-edit">
                                            <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                        </span>
                                        <span class="js-remove"><i class="fas fa-trash"></i></span>
                                    </div>

		                        <?php endforeach; ?>

                            </div>

                            <div class="ascm-panels-entity-cont">FOOTER</div>

                            <div class="ascm-panels-availablepages_items_label">Genesis After Footer (genesis_after_footer)</div>
                            <div id="<?php echo 'ascm_panels_page_'.$key.'_genesisafterfooter'; ?>" class="list-group col ascm-panels-availablepages_items_cont">

		                        <?php
		                        $allavailablepages_genesisafterfooter = isset($value['genesisafterfooter']) ? $value['genesisafterfooter'] : array();
		                        $allavailablepages_genesisafterfooter = is_array($allavailablepages_genesisafterfooter) ? $allavailablepages_genesisafterfooter : array();
		                        foreach ($allavailablepages_genesisafterfooter as $genesisafterfooter_value) :
			                        $genesisafterfooter_value = str_replace('[ascm-panels id=','', $genesisafterfooter_value);
			                        $genesisafterfooter_value = str_replace(']','', $genesisafterfooter_value);

			                        $fontawesomeicon = isset($allavailablepanels[$genesisafterfooter_value]['fontawesomeicon']) ? $allavailablepanels[$genesisafterfooter_value]['fontawesomeicon'] : '';
			                        $title = isset($allavailablepanels[$genesisafterfooter_value]['title']) ? $allavailablepanels[$genesisafterfooter_value]['title'] : '';
			                        $edit_url = isset($allavailablepanels[$genesisafterfooter_value]['edit_url']) ? $allavailablepanels[$genesisafterfooter_value]['edit_url'] : '';
			                        ?>

                                        <div data-id="<?php echo '[ascm-panels id='.$genesisafterfooter_value.']'; ?>" class="ascm-panels-panel-item list-group-item">
                                            <span><?php echo $fontawesomeicon; ?></span>
                                            <span style="margin-left: 15px;">
                                                <?php echo $title; ?>
                                            </span>
                                            <span class="js-edit">
                                                <a href="<?php echo esc_html($edit_url); ?>" target="_blank"><i class="fas fa-edit"></i></a>
                                            </span>
                                            <span class="js-remove"><i class="fas fa-trash"></i></span>
                                    </div>

		                        <?php endforeach; ?>

                            </div>

                        </div>
                        <?php endforeach; ?>

                    <?php endif; ?>
				</div>

			</div>
		</div>
        <!-- Panels On Pages -->

		<div class="ascm-field-col s12 m12 l12">
			<div id="ascm-mod-settings-loading-cont-panels" class="ascm-mod-settings-loading-cont ascm-hidden">
				<i class="fa fa fa-spinner fa-spin fa-2x"></i>
				<span style="padding: 5px;"><?php _e( 'Saving', 'ascm' ); ?> . . . . . </span>
			</div>
			<div class="ascm-mod-settings-btn-cont">
				<span id="ascm-mod-settings-save-btn-panels" class="ascm-mod-settings-save-btn"><?php _e( 'Save', 'ascm' ); ?></span>
				<span id="ascm-mod-settings-cancel-btn-panels" class="ascm-mod-settings-cancel-btn"><?php _e( 'Cancel', 'ascm' ); ?></span>
			</div>
		</div>
	</div>
</div>	
