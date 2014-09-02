

<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
<?php echo $content_top; ?>

    <div class="container content my_ormary_profile_page" style="margin-top:130px;">
        
            <div class="top_panel_margin"><h4><?php echo $heading_title; ?></h4></div>
        <div class="col-md-12 clearfix nopadding about">
            <p>
                To return an item to us, please complete the form below and we will arrange a collection at a time to suit you.
            </p>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <h2 class="account-header">Your Return Request</h2>
                <div class="content">
                    <div class="left">

                        <div class='twocol-formelement'>
                            <span class="required">*</span> <?php echo $entry_firstname; ?><br />
                            <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="large-field" />

                            <?php if ($error_firstname) { ?>
                            <div class="required-error"><?php echo $error_firstname; ?></div>
                            <?php } ?>
                        </div>

                        <div class='twocol-formelement last'>
                        <span class="required">*</span> <?php echo $entry_lastname; ?><br />
                        <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="large-field" />
                   
                        <?php if ($error_lastname) { ?>
                        <span class="required-error"><?php echo $error_lastname; ?></span>
                        <?php } ?>
</div>
                        
                        
                        <div class='twocol-formelement'>
                        <span class="required">*</span> <?php echo $entry_email; ?><br />
                        <input type="text" name="email" value="<?php echo $email; ?>" class="large-field" />
       
                        <?php if ($error_email) { ?>
                        <span class="required-error"><?php echo $error_email; ?></span>
                        <?php } ?>
       </div>
                        
                 <div class='twocol-formelement last    '>       
                        <span class="required">*</span> <?php echo $entry_telephone; ?><br />
                        <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="large-field" />
                    
                        <?php if ($error_telephone) { ?>
                        <span class="required-error"><?php echo $error_telephone; ?></span>
                        <?php } ?>
         </div>
                    <div class='twocol-formelement '>
                    <span class="required">*</span> <?php echo $entry_order_id; ?><br />

                        <select name="order_id"  class="large-field" id="select-order-id">
                            <option value='' >-- Order Id --</option>
                            <?php 

                            foreach ($my_orders as $o) {
                            $oid = $o['order_id'] ;

                            echo  '<option value="'.$oid.'">'.$oid.'</option>';

                            }              
                            ?>


                        </select>
                        <!--      
                            <input type="text" name="order_id" value="<?php echo $order_id; ?>" class="large-field" />
                            
                        -->
          
                        <?php if ($error_order_id) { ?>
                        <span class="required-error"><?php echo $error_order_id; ?></span>
                        <?php } ?>
                        <br />
                        </div>
                  
                        <input type="hidden" name="date_ordered" value="<?php echo $date_ordered; ?>" class="large-field date" />



<div class='twocol-formelement last'>
                <div id="return-product">
                    <div class="content">
                        <div class="return-product">
                            
                            
                        
                            <div class="return-name"><span class="required">*</span> <b><?php echo $entry_product; ?></b><br />

                                <div id="select-product-name"><input type="text" name="product" value="<?php echo $product; ?>" disabled /></div>
                                
                                </div>
                            
                                   <div id="select-product-model"><input type="hidden" name="model" value="<?php echo $model; ?>" /></div>


                                    <?php 

                                    foreach ($my_orders as $o) {
                                    ?>
                                    <div class="screen-offset order_products" id="order-products-<?php echo $o['order_id'] ?>">

                                        <?php if (count($o['order_products']) == 1) { ?>

                                        <div class="screen-offset">
                                            <span class="order-products-name">
                                                <input type="text" name="product" value="<?php echo $o['order_products'][0]['name']; ?>" data-model="<?php echo $o['order_products'][0]['model']; ?>"/>
                                            </span>

                                        </div>
                                        <?php } else { ?>




                                        <div class="screen-offset">
                                            <span class="order-products-name">
                                                <select  name="product">
                                                    <option value="">--Choose Product--</option>
                                                    <?php foreach($o['order_products'] as $p) { ?>

                                                    <option   value="<?php echo $p['name']; ?>"  data-model="<?php echo $p['model']; ?>"><?php echo $p['name']; ?></option>


                                                    <?php } ?>
                                                </select>
                                        </div>

                                        <?php } ?>

                                    </div>

                                    <?php
                                    }              
                                    ?>


                
                                </div>
                                
                                </div>
                               
                                    <input type="hidden" name="quantity" value="<?php echo $quantity; ?>" />
                              </div>             </div>
                                          <div class='twocol-formelement '>
                            <div class="return-detail">
                                <div class="return-reason"><span class="required">*</span> <b><?php echo $entry_reason; ?></b><br />
                                    <table>
                                        <?php foreach ($return_reasons as $return_reason) { ?>
                                        <?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
                                        <tr>
                                            <td width="20"><input type="radio" name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" id="return-reason-id<?php echo $return_reason['return_reason_id']; ?>" checked="checked" /></td>
                                            <td><label for="return-reason-id<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></label></td>
                                        </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <td width="20"><input type="radio" name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" id="return-reason-id<?php echo $return_reason['return_reason_id']; ?>" /></td>
                                            <td><label for="return-reason-id<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></label></td>
                                        </tr>
                                        <?php  } ?>
                                        <?php  } ?>
                                    </table>
                                    <?php if ($error_reason) { ?>
                                    <span class="required-error"><?php echo $error_reason; ?></span>
                                    <?php } ?>
                                </div>    </div>
                                <div class="return-opened ">
                                    <div class=screen-offset>
                                    <?php if ($opened) { ?>
                                    <input type="radio" name="opened" value="1" id="opened" checked="checked" />
                                    <?php } else { ?>
                                    <input type="radio" name="opened" value="1" id="opened" />
                                    <?php } ?>
                                    <label for="opened"><?php echo $text_yes; ?></label>
                                    <?php if (!$opened) { ?>
                                    <input type="radio" name="opened" value="0" id="unopened" checked="checked" />
                                    <?php } else { ?>
                                    <input type="radio" name="opened" value="0" id="unopened" />
                                    <?php } ?>
                                    <label for="unopened"><?php echo $text_no; ?></label>
                                    </div>
                                    <br>
                                    OTHER DETAILS?<br />
                                    <textarea name="comment" cols="100" rows="6"><?php echo $comment; ?></textarea>
                                </div>
                          
                            </div>
                        </div>
                    </div>
                    <?php if ($text_agree) { ?>
                                            <div class='twocol-formelement'>
                                                
                    <div class="buttons">
                       
                        <div class="right"><?php echo $text_agree; ?>
                            <?php if ($agree) { ?>
                            <input type="checkbox" name="agree" value="1" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="agree" value="1" />
                            <?php } ?>
                            
                            <input type="submit" value="Request Return" class="button" />
                            <div class=clearfix></div>
                             <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
                        </div>
                    </div>
                                                </div>
                    <?php } else { ?>
                            <div class='twocol-formelement'>
                    <div class="buttons">
     
                        <div class="right">
                            <input type="submit" value="Request Return" class="button" />
                        </div>
                                                 <div class=clearfix></div>
                             <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
                    </div>        </div>
                    <?php } ?>
            </form></div></div>     </div>
    <?php echo $content_bottom; ?></div></div>

<script type="text/javascript"><!--



    $(document).ready(function() {
        $('#select-order-id').change(function() {
            var _this = $(this);
            var oid = _this.val();
            var order_products_names = $("#order-products-" + oid + " .order-products-name").clone().html();
            $('#select-product-name').html(order_products_names)


            if ($('#select-product-name').find('select').length > 0) {

                $('#select-product-name select').change(function() {

                    var _this = $(this);
                    var modelid = _this.find('option:selected').attr('data-model');
                    $('#select-product-model input').val(modelid);



                });
            } else {
                var modelid = $('#select-product-name').find('input').attr('data-model');
                console.log(modelid);
                $('#select-product-model input').val(modelid);
            }

        });





    });
    //--></script> 
<div class=clearfix></div>

<?php echo $footer; ?>


