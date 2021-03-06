<?php echo $header; ?>
<?php echo $column_left; ?><?php echo $column_right; ?>

  
  
	<div class="container content all_designers_page">
    <?php echo $content_top; ?>
        <h4>All Designers</h4>
        <span href="#" class="sort_by">Sort by</span>
        <div class="col-md-3 clearfix aside clothing_aside">
        	<form action="" id="orm_des_filter">
        		<fieldset>
<!--        			<div class="tabs">
        				<a href="#" class="womens_tab active">Womens</a>
        				<a href="#" class="mens_tab">Mens</a>
        			</div>-->
                    <ul class="filter-clothing filter-clothing-womens">
                    
                    <?php
                   	
                    foreach($categories as $cid => $cat)
                    {
                    	if(in_array($cid, $selected_categories))
                        {
                        	$checked = 'activelabel';
                            $list_style = 'display:block';
                        }
                        else
                        {
                        	$checked = '';
                            $list_style ='';
                        }
                        print '<li class="light_font">

                            <label class="filter-label '.$checked.'" for="w'.strtolower($cat['name']).'" id="c'.$cid.'">
                                '.$cat['name'].'
                            </label>';
                         $checked = '';
                        if(isset($cat['subcategories']))
                        {
                        	print '<ul class="sub_filter-clothing" style="'.$list_style.'">';
                            foreach($cat['subcategories'] as $scid => $scat)
                    		{
                            	if(in_array($scid, $selected_categories))
                                {
                                    $checked = 'activelabel';
                                }
                                else
                                {
                                    $checked = '';
                                }
                                print '<li class="light_font">
                                <label class="filter-label '.$checked.'" for="w'.strtolower($scat['name']).'"  id="c'.$scid.'">
                                  '.$scat['name'].'
                                </label>
                                </li>';
                            }   
        					print '</ul>';
                       
                       	}
   
                        print '</li>';
                   	}
                    
                    ?>
        			</ul>
        		</fieldset>
        	</form>
        </div>
        
        <div class="col-md-9 clearfix nopadding">
            <div class="row">
                <form id="designer_search" action="">
                    <div class="designer-search-wrap">
                        <input name="designer_name" type="text" placeholder="Type designer name or first letters">
                    </div>
                </form>
            </div>
            <div id="designers-byname-list-wrap"></div>
            <div id="designers-list-wrap">
                <?php 
                if(isset($manufacturers_numbers))
                {
                ?>
                    <div class="row">
                        <div class="all_des_caption"><?php print $manufacturers_numbers['letter']; ?></div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <ul>
                                <?php
                                foreach($manufacturers_numbers['manufacturers'] as $m)
                                {
                                    print '<li><a href="index.php?route=product/manufacturer/info&manufacturer_id='.$m['manufacturer_id'].'">'.$m['name'].'</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php 
                }
    			
                if(isset($manufacturers_list))
                {
                 	foreach($manufacturers_list as $m)
                	{
                    	if(isset($m['manufacturers']))
                		{
                        	$count = count($m['manufacturers']);
               				print '<div class="row">';
                        	print '<div class="all_des_caption">'.implode('-', $m['header']).'</div>';
                            print '<div class="col-md-4 col-sm-4 col-xs-6"><ul>';
                            for($i=0; $i<ceil($count/3); $i++)
                            {
                            	print '<li><a href="index.php?route=product/manufacturer/info&manufacturer_id='.$m['manufacturers'][$i]['manufacturer_id'].'">'.$m['manufacturers'][$i]['name'].'</a></li>';
                            }
	                     	print '</ul></div>';
                            
							if($count > 1)
                            {
                     			print '<div class="col-md-4 col-sm-4 col-xs-6"><ul>';
                                for($i= ceil($count/3); $i<ceil(2*$count/3); $i++)
                                {
                                    print '<li><a href="index.php?route=product/manufacturer/info&manufacturer_id='.$m['manufacturers'][$i]['manufacturer_id'].'">'.$m['manufacturers'][$i]['name'].'</a></li>';
                                }
	                     		print '</ul></div>';
                            }
                            
                            if($count > 2)
                            {
                            	print '<div class="col-md-4 col-sm-4 col-xs-6"><ul>';
                                for($i=ceil(2*$count/3); $i<$count; $i++)
                                {
                                    print '<li><a href="index.php?route=product/manufacturer/info&manufacturer_id='.$m['manufacturers'][$i]['manufacturer_id'].'">'.$m['manufacturers'][$i]['name'].'</a></li>';
                                }
	                     		print '</ul></div>';
                           	}
                      		print '</div>';      
                        }
                	}
				}
                ?>
        	</div>    
        </div>
	</div>
</div>
  
  
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>