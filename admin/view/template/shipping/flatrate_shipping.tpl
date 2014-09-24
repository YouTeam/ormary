<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_name; ?></td>
            <td><input type="text" name="name" value="<?php echo $name; ?>" /></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_countries; ?></td>
            <td>
           		<select name="countries[]" multiple="multiple">
                    <?php
                    foreach($countries_list as $c)
                    {
                        if(in_array($c['country_id'], explode(',', $countries)))
                        {               
                            print '<option value="'.$c['country_id'].'" selected="selected">'.$c['name'].'</option>';                
                        }
                        else
                        {                    
                            print '<option value="'.$c['country_id'].'">'.$c['name'].'</option>';    
                        }	
                    }
                    ?>
                </select>
            </td>
          </tr>
          
          <tr>
            <td><?php echo $entry_order; ?></td>
            <td>
            	<select name="sort_order">
            	<?php
                for($i=0; $i<15; $i++)
                {
                	if($i == $sort_order)
                    {               
            			print '<option value="'.$i.'" selected="selected">'.$i.'</option>';                
               		}
                    else
                    {                    
                   		print '<option value="'.$i.'">'.$i.'</option>';
                   	}	
                }
                ?>
                </select>
            </td>
          </tr>
          
          <tr>
            <td><?php echo $entry_cart_price; ?></td>
            <td><input type="text" name="cart_price" value="<?php echo $cart_price; ?>" /></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_message; ?></td>
            <td><textarea rows="5" cols="100" type="text" name="message"><?php echo $message; ?></textarea></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_price; ?></td>
            <td><input type="text" name="price" value="<?php echo $price; ?>" /></td>
          </tr>

        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 