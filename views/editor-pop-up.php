<script>
function CC_insert_product_shortcode(){
    var product_id = jQuery('#product_id').val();
    var display_type = jQuery("#display_type").val();
    var display_quantity = jQuery("#display_quantity").is(":checked") ? 'true' : 'false';
    var display_price = jQuery("#display_price").is(":checked") ? 'true' : 'false';
    if(product_id == "0" || product_id == ""){
        alert("<?php _e("Please select a product", "cart66") ?>");
        return;
    }
    window.send_to_editor("[cc_product sku=\"" + product_id + "\" display=\"" + display_type + "\" quantity=\"" + display_quantity + "\" price=\"" + display_price + "\"]");
}
</script>

<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $("select#product_id").chosen({
                width:'100%',
                disable_search: true,
                search_contains: true,
                placeholder_text_single: 'Select a Product'

            });
            var original_products = $("#product_id").html();
            $("#cc_product_search").keyup(function(){
                if($("#cc_product_search").val().length <2){
                    if( $("#cc_product_search").val() == ''){
                        $("#product_id").html(original_products);
                    }
                    else{
                        return;
                    }
                }
                var data = {
                    'action': 'cc_product_search',
                    'q': $("#cc_product_search").val()
                };

                $("#product_list_loading").show();

                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                $.post(ajaxurl, data, function(response) {
                    console.log(response);
                    $("#product_id").html('<option></option>');
                    response.forEach(function(item) {
                        //console.log(item);
                        $("#product_id").append('<option value="'+item.sku+'">'+item.name+' (sku: '+item.sku+')</option>');
                    });
                    $("#product_id").trigger("chosen:updated");
                    $("#product_list_loading").hide();
                    $("#product_id").trigger('chosen:open');
                }, 'json');

            })
        })
    })(jQuery);
</script>

<style type="text/css">
    #cart66_pop_up .form-table tbody tr th {
        text-align: right;
        width: 150px !important;
    }

    #cart66_pop_up .form-table .description {
        width: 312px;
    }
    #cc_product_search {
        width:90%;
        -webkit-border-radius: 5px 5px 0px 0px;
        -moz-border-radius: 5px 5px 0px 0px;
        border-radius: 5px 5px 0px 0px;
        border:1px solid #cecece;
    }
    #product_list_loading{
        width:9%;
        display:none;
    }
    #product_list_loading img{
        vertical-align:text-top;
    }
</style>

<div id="cc_editor_pop_up" style="display:none;">
    <div id="cart66_pop_up" class="wrap">
        <div>
            <div style="padding:15px 15px 0 15px;">
                <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;"><?php _e("Insert A Product", "cart66"); ?></h3>
                <span><?php _e("Select a product below to add it to your post or page.", "cart66"); ?></span>
            </div>

            <div style="padding:15px 15px 0 15px;">
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="product_id">Products</label></th>
                            <td>
                                <input id="cc_product_search" autocomplete="off" placeholder="Search for product by name or sku">
                                <span id="product_list_loading"><img src="<?php echo CC_URL; ?>resources/images/arrow-load.gif" alt="Loading..." ></span><br>

                                <select name="product_id" id="product_id" data-placeholder="Select A Product">
                                    <option></option>
                                    <?php foreach($product_data as $p): ?>
                                        <option value="<?php echo $p['sku']; ?>"><?php echo $p['name']; ?> (sku: <?php echo $p['sku']; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="display_type">Display mode</label></th>
                            <td>
                                <select name="display_type" id="display_type">
                                    <option value="inline">inline</option>
                                    <option value="vertical">vertical</option>
                                    <option value="horizontal">horizontal</option>
                                </select>
                                <p class="description"><?php _e('If the product has no options, we recommend choosing the "inline" display mode.', 'cart66'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="display_type">Show quantity field</label></th>
                            <td>
                                <input type="checkbox" id="display_quantity" checked='checked' /> <label for="display_quantity"><?php _e("Yes", "cart66"); ?></label>
                                &nbsp;&nbsp;&nbsp;
                                <p class="description"><?php _e('Allow the buyer to set the quanity when adding to cart', 'cart66'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="display_type">Show product price</label></th>
                            <td>
                                <input type="checkbox" id="display_price" checked='checked' /> <label for="display_price"><?php _e("Yes", "cart66"); ?></label>
                                &nbsp;&nbsp;&nbsp;
                                <p class="description"><?php _e('Do you want to show the price of the product?', 'cart66'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="padding:15px;">
                <input type="button" class="button-primary" value="Insert Product" onclick="CC_insert_product_shortcode();"/>
                &nbsp;&nbsp;&nbsp;
                <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "cart66"); ?></a>
            </div>
        </div>
    </div>
</div>
