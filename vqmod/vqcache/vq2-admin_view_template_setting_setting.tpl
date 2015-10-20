<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-store" data-toggle="tab"><?php echo $tab_store; ?></a></li>
            <li><a href="#tab-local" data-toggle="tab"><?php echo $tab_local; ?></a></li>
            <li><a href="#tab-option" data-toggle="tab"><?php echo $tab_option; ?></a></li>
<li><a href="#tab-avalara" data-toggle="tab">Avalara</a></li>
            <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
            <li><a href="#tab-ftp" data-toggle="tab"><?php echo $tab_ftp; ?></a></li>
            <li><a href="#tab-mail" data-toggle="tab"><?php echo $tab_mail; ?></a></li>
            <li><a href="#tab-fraud" data-toggle="tab"><?php echo $tab_fraud; ?></a></li>
            <li><a href="#tab-server" data-toggle="tab"><?php echo $tab_server; ?></a></li>
            <li><a href="#tab-google" data-toggle="tab"><?php echo $tab_google; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_name" id="config_name" value="<?php echo $config_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                  <?php if ($error_name) { ?>
                  <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-owner"><?php echo $entry_owner; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_owner" value="<?php echo $config_owner; ?>" placeholder="<?php echo $entry_owner; ?>" id="input-owner" class="form-control" />
                  <?php if ($error_owner) { ?>
                  <div class="text-danger"><?php echo $error_owner; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address"><?php echo $entry_address; ?></label>
                <div class="col-sm-10">
                  
					<input type="text" name="config_address" id="config_address" class="form-control" value="<?php echo $config_address; ?>" size="40" />
			
                  <?php if ($error_address) { ?>
                  <div class="text-danger"><?php echo $error_address; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geocode"><span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $help_geocode; ?>"><?php echo $entry_geocode; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_geocode" value="<?php echo $config_geocode; ?>" placeholder="<?php echo $entry_geocode; ?>" id="input-geocode" class="form-control" />
                </div>
              </div>

				<div class="form-group">
					<label class="col-sm-2 control-label" for="config_address_line2">Address Line 2</label>
					<div class="col-sm-10">
						<input type="text" name="config_address_line2" value="<?php echo $config_address_line2; ?>" placeholder="Address Line 2" id="config_address_line2" class="form-control" />
					</div>
			    </div>

				<div class="form-group required">
					<label class="col-sm-2 control-label" for="config_city">City:</label>
					<div class="col-sm-10">
						<input type="text" name="config_city" value="<?php echo $config_city; ?>" placeholder="City" id="config_city" class="form-control" />
						<?php if ($error_city) { ?>
						<div class="text-danger"><?php echo $error_city; ?></div>
							<?php } ?>
					</div>
				</div>

			  <div class="form-group">
					<label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
					<div class="col-sm-10">
						<select name="config_country_id" id="input-country" class="form-control">
							<?php foreach ($countries as $country) { ?>
							<?php if ($country['country_id'] == $config_country_id) { ?>
							<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
				<div class="col-sm-10">
					<select name="config_zone_id" id="input-zone" class="form-control">
					</select>
				</div>
			  </div>

			   <div class="form-group required">
					<label class="col-sm-2 control-label" for="config_postal_code">Postal Code:</label>
					<div class="col-sm-10">
						<input type="text" name="config_postal_code" value="<?php echo $config_postal_code; ?>" placeholder="Postal Code" id="config_postal_code" class="form-control" />
						<?php if ($error_postal_code) { ?>
						<div class="text-danger"><?php echo $error_postal_code; ?></div>
						<?php } ?>
					</div>
			  </div>
                        <?php if($config_avatax_tax_address_validation==1)	{?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <input type="button" id="validateAddress" data-loading-text="Loading..." class="btn btn-primary" value="Validate Address"></input>
									<input type='hidden' id='validAddressData' name='validAddressData'>
                                </div>
                           </div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	07/09/2015			                            							*
						 *   Description        :   Instead of windows dialog box, showing address validation message in jquery window   	*
						 *****************************************************************************************************-->

						 <div class="form-group">
							<div class="col-sm-10">
								<div id="AvaTaxStoreAddressValidateDialog" title="<img src='view/image/Ava-logo.jpg'> AvaTax Address Validation" style="display:none;"></div>
							</div>
						</div>
						   <?php }		else	{?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <input type="button" class="btn btn-primary" id="validateaddress_error" value="Validate Address"><span id="validateaddress_error_dialog" title="<img src='view/image/Ava-logo.jpg'>AvaTax Address Validation" style="display:none;margin-left: -10px;">AvaTax or Address Validation Service is not enabled. Please enable it in Avalara Panel.</span></input>
                                </div>
                           </div>
					<?php	}	?>
			
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_email" value="<?php echo $config_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                  <?php if ($error_email) { ?>
                  <div class="text-danger"><?php echo $error_email; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_telephone" value="<?php echo $config_telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
                  <?php if ($error_telephone) { ?>
                  <div class="text-danger"><?php echo $error_telephone; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-fax"><?php echo $entry_fax; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_fax" value="<?php echo $config_fax; ?>" placeholder="<?php echo $entry_fax; ?>" id="input-fax" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="config_image" value="<?php echo $config_image; ?>" id="input-image" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-open"><span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $help_open; ?>"><?php echo $entry_open; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_open" rows="5" placeholder="<?php echo $entry_open; ?>" id="input-open" class="form-control"><?php echo $config_open; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-comment"><span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $help_comment; ?>"><?php echo $entry_comment; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_comment" rows="5" placeholder="<?php echo $entry_comment; ?>" id="input-comment" class="form-control"><?php echo $config_comment; ?></textarea>
                </div>
              </div>
              <?php if ($locations) { ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $help_location; ?>"><?php echo $entry_location; ?></span></label>
                <div class="col-sm-10">
                  <?php foreach ($locations as $location) { ?>
                  <div class="checkbox">
                    <label>
                      <?php if (in_array($location['location_id'], $config_location)) { ?>
                      <input type="checkbox" name="config_location[]" value="<?php echo $location['location_id']; ?>" checked="checked" />
                      <?php echo $location['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="config_location[]" value="<?php echo $location['location_id']; ?>" />
                      <?php echo $location['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="tab-pane" id="tab-store">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-meta-title"><?php echo $entry_meta_title; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_meta_title" value="<?php echo $config_meta_title; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title" class="form-control" />
                  <?php if ($error_meta_title) { ?>
                  <div class="text-danger"><?php echo $error_meta_title; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-meta-description"><?php echo $entry_meta_description; ?></label>
                <div class="col-sm-10">
                  <textarea name="config_meta_description" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description" class="form-control"><?php echo $config_meta_description; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-meta-keyword"><?php echo $entry_meta_keyword; ?></label>
                <div class="col-sm-10">
                  <textarea name="config_meta_keyword" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword" class="form-control"><?php echo $config_meta_keyword; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-template"><?php echo $entry_template; ?></label>
                <div class="col-sm-10">
                  <select name="config_template" id="input-template" class="form-control">
                    <?php foreach ($templates as $template) { ?>
                    <?php if ($template == $config_template) { ?>
                    <option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <br />
                  <img src="" alt="" id="template" class="img-thumbnail" /></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-layout"><?php echo $entry_layout; ?></label>
                <div class="col-sm-10">
                  <select name="config_layout_id" id="input-layout" class="form-control">
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if ($layout['layout_id'] == $config_layout_id) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-local">
              <div class="form-group">
                











              </div>
              <div class="form-group">
                




              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-language"><?php echo $entry_language; ?></label>
                <div class="col-sm-10">
                  <select name="config_language" id="input-language" class="form-control">
                    <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $config_language) { ?>
                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-admin-language"><?php echo $entry_admin_language; ?></label>
                <div class="col-sm-10">
                  <select name="config_admin_language" id="input-admin-language" class="form-control">
                    <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $config_admin_language) { ?>
                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-currency"><span data-toggle="tooltip" title="<?php echo $help_currency; ?>"><?php echo $entry_currency; ?></span></label>
                <div class="col-sm-10">
                  <select name="config_currency" id="input-currency" class="form-control">
                    <?php foreach ($currencies as $currency) { ?>
                    <?php if ($currency['code'] == $config_currency) { ?>
                    <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_currency_auto; ?>"><?php echo $entry_currency_auto; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_currency_auto) { ?>
                    <input type="radio" name="config_currency_auto" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_currency_auto" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_currency_auto) { ?>
                    <input type="radio" name="config_currency_auto" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_currency_auto" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-length-class"><?php echo $entry_length_class; ?></label>
                <div class="col-sm-10">
                  <select name="config_length_class_id" id="input-length-class" class="form-control">
                    <?php foreach ($length_classes as $length_class) { ?>
                    <?php if ($length_class['length_class_id'] == $config_length_class_id) { ?>
                    <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-weight-class"><?php echo $entry_weight_class; ?></label>
                <div class="col-sm-10">
                  <select name="config_weight_class_id" id="input-weight-class" class="form-control">
                    <?php foreach ($weight_classes as $weight_class) { ?>
                    <?php if ($weight_class['weight_class_id'] == $config_weight_class_id) { ?>
                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-option">
              <fieldset>
                <legend><?php echo $text_product; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_product_count; ?>"><?php echo $entry_product_count; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_product_count) { ?>
                      <input type="radio" name="config_product_count" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_product_count" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_product_count) { ?>
                      <input type="radio" name="config_product_count" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_product_count" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-catalog-limit"><span data-toggle="tooltip" title="<?php echo $help_product_limit; ?>"><?php echo $entry_product_limit; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_product_limit" value="<?php echo $config_product_limit; ?>" placeholder="<?php echo $entry_product_limit; ?>" id="input-catalog-limit" class="form-control" />
                    <?php if ($error_product_limit) { ?>
                    <div class="text-danger"><?php echo $error_product_limit; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-list-description-limit"><span data-toggle="tooltip" title="<?php echo $help_product_description_length; ?>"><?php echo $entry_product_description_length; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_product_description_length" value="<?php echo $config_product_description_length; ?>" placeholder="<?php echo $entry_product_description_length; ?>" id="input-list-description-limit" class="form-control" />
                    <?php if ($error_product_description_length) { ?>
                    <div class="text-danger"><?php echo $error_product_description_length; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-admin-limit"><span data-toggle="tooltip" title="<?php echo $help_limit_admin; ?>"><?php echo $entry_limit_admin; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_limit_admin" value="<?php echo $config_limit_admin; ?>" placeholder="<?php echo $entry_limit_admin; ?>" id="input-admin-limit" class="form-control" />
                    <?php if ($error_limit_admin) { ?>
                    <div class="text-danger"><?php echo $error_limit_admin; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_review; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_review; ?>"><?php echo $entry_review; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_review_status) { ?>
                      <input type="radio" name="config_review_status" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_review_status" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_review_status) { ?>
                      <input type="radio" name="config_review_status" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_review_status" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_review_guest; ?>"><?php echo $entry_review_guest; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_review_guest) { ?>
                      <input type="radio" name="config_review_guest" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_review_guest" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_review_guest) { ?>
                      <input type="radio" name="config_review_guest" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_review_guest" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_review_mail; ?>"><?php echo $entry_review_mail; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_review_mail) { ?>
                      <input type="radio" name="config_review_mail" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_review_mail" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_review_mail) { ?>
                      <input type="radio" name="config_review_mail" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_review_mail" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_voucher; ?></legend>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-voucher-min"><span data-toggle="tooltip" title="<?php echo $help_voucher_min; ?>"><?php echo $entry_voucher_min; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_voucher_min" value="<?php echo $config_voucher_min; ?>" placeholder="<?php echo $entry_voucher_min; ?>" id="input-voucher-min" class="form-control" />
                    <?php if ($error_voucher_min) { ?>
                    <div class="text-danger"><?php echo $error_voucher_min; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-voucher-max"><span data-toggle="tooltip" title="<?php echo $help_voucher_max; ?>"><?php echo $entry_voucher_max; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_voucher_max" value="<?php echo $config_voucher_max; ?>" placeholder="<?php echo $entry_voucher_max; ?>" id="input-voucher-max" class="form-control" />
                    <?php if ($error_voucher_max) { ?>
                    <div class="text-danger"><?php echo $error_voucher_max; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_tax; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_tax; ?></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_tax) { ?>
                      <input type="radio" name="config_tax" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_tax" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_tax) { ?>
                      <input type="radio" name="config_tax" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_tax" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-tax-default"><span data-toggle="tooltip" title="<?php echo $help_tax_default; ?>"><?php echo $entry_tax_default; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_tax_default" id="input-tax-default" class="form-control">
                      <option value=""><?php echo $text_none; ?></option>
                      <?php  if ($config_tax_default == 'shipping') { ?>
                      <option value="shipping" selected="selected"><?php echo $text_shipping; ?></option>
                      <?php } else { ?>
                      <option value="shipping"><?php echo $text_shipping; ?></option>
                      <?php } ?>
                      <?php  if ($config_tax_default == 'payment') { ?>
                      <option value="payment" selected="selected"><?php echo $text_payment; ?></option>
                      <?php } else { ?>
                      <option value="payment"><?php echo $text_payment; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-tax-customer"><span data-toggle="tooltip" title="<?php echo $help_tax_customer; ?>"><?php echo $entry_tax_customer; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_tax_customer" id="input-tax-customer" class="form-control">
                      <option value=""><?php echo $text_none; ?></option>
                      <?php  if ($config_tax_customer == 'shipping') { ?>
                      <option value="shipping" selected="selected"><?php echo $text_shipping; ?></option>
                      <?php } else { ?>
                      <option value="shipping"><?php echo $text_shipping; ?></option>
                      <?php } ?>
                      <?php  if ($config_tax_customer == 'payment') { ?>
                      <option value="payment" selected="selected"><?php echo $text_payment; ?></option>
                      <?php } else { ?>
                      <option value="payment"><?php echo $text_payment; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_account; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_customer_online; ?>"><?php echo $entry_customer_online; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_customer_online) { ?>
                      <input type="radio" name="config_customer_online" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_customer_online" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_customer_online) { ?>
                      <input type="radio" name="config_customer_online" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_customer_online" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-customer-group"><span data-toggle="tooltip" title="<?php echo $help_customer_group; ?>"><?php echo $entry_customer_group; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_customer_group_id" id="input-customer-group" class="form-control">
                      <?php foreach ($customer_groups as $customer_group) { ?>
                      <?php if ($customer_group['customer_group_id'] == $config_customer_group_id) { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_customer_group_display; ?>"><?php echo $entry_customer_group_display; ?></span></label>
                  <div class="col-sm-10">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($customer_group['customer_group_id'], $config_customer_group_display)) { ?>
                        <input type="checkbox" name="config_customer_group_display[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                        <?php echo $customer_group['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="config_customer_group_display[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                        <?php echo $customer_group['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                    <?php if ($error_customer_group_display) { ?>
                    <div class="text-danger"><?php echo $error_customer_group_display; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_customer_price; ?>"><?php echo $entry_customer_price; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_customer_price) { ?>
                      <input type="radio" name="config_customer_price" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_customer_price" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_customer_price) { ?>
                      <input type="radio" name="config_customer_price" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_customer_price" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-login-attempts"><span data-toggle="tooltip" title="<?php echo $help_login_attempts; ?>"><?php echo $entry_login_attempts; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_login_attempts" value="<?php echo $config_login_attempts; ?>" placeholder="<?php echo $entry_login_attempts; ?>" id="input-login-attempts" class="form-control" />
                    <?php if ($error_login_attempts) { ?>
                    <div class="text-danger"><?php echo $error_login_attempts; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-account"><span data-toggle="tooltip" title="<?php echo $help_account; ?>"><?php echo $entry_account; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_account_id" id="input-account" class="form-control">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($informations as $information) { ?>
                      <?php if ($information['information_id'] == $config_account_id) { ?>
                      <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_account_mail; ?>"><?php echo $entry_account_mail; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_account_mail) { ?>
                      <input type="radio" name="config_account_mail" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_account_mail" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_account_mail) { ?>
                      <input type="radio" name="config_account_mail" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_account_mail" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_checkout; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-invoice-prefix"><span data-toggle="tooltip" title="<?php echo $help_invoice_prefix; ?>"><?php echo $entry_invoice_prefix; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_invoice_prefix" value="<?php echo $config_invoice_prefix; ?>" placeholder="<?php echo $entry_invoice_prefix; ?>" id="input-invoice-prefix" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-api"><span data-toggle="tooltip" title="<?php echo $help_api; ?>"><?php echo $entry_api; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_api_id" id="input-api" class="form-control">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($apis as $api) { ?>
                      <?php if ($api['api_id'] == $config_api_id) { ?>
                      <option value="<?php echo $api['api_id']; ?>" selected="selected"><?php echo $api['username']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $api['api_id']; ?>"><?php echo $api['username']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_cart_weight; ?>"><?php echo $entry_cart_weight; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_cart_weight) { ?>
                      <input type="radio" name="config_cart_weight" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_cart_weight" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_cart_weight) { ?>
                      <input type="radio" name="config_cart_weight" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_cart_weight" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_checkout_guest; ?>"><?php echo $entry_checkout_guest; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_checkout_guest) { ?>
                      <input type="radio" name="config_checkout_guest" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_checkout_guest" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_checkout_guest) { ?>
                      <input type="radio" name="config_checkout_guest" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_checkout_guest" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-checkout"><span data-toggle="tooltip" title="<?php echo $help_checkout; ?>"><?php echo $entry_checkout; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_checkout_id" id="input-checkout" class="form-control">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($informations as $information) { ?>
                      <?php if ($information['information_id'] == $config_checkout_id) { ?>
                      <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-order-status"><span data-toggle="tooltip" title="<?php echo $help_order_status; ?>"><?php echo $entry_order_status; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_order_status_id" id="input-order-status" class="form-control">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $config_order_status_id) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-process-status"><span data-toggle="tooltip" title="<?php echo $help_processing_status; ?>"><?php echo $entry_processing_status; ?></span></label>
                  <div class="col-sm-10">
                    <div class="well well-sm" style="height: 150px; overflow: auto;">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <div class="checkbox">
                        <label>
                          <?php if (in_array($order_status['order_status_id'], $config_processing_status)) { ?>
                          <input type="checkbox" name="config_processing_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                          <?php echo $order_status['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="config_processing_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                          <?php echo $order_status['name']; ?>
                          <?php } ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                    <?php if ($error_processing_status) { ?>
                    <div class="text-danger"><?php echo $error_processing_status; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-complete-status"><span data-toggle="tooltip" title="<?php echo $help_complete_status; ?>"><?php echo $entry_complete_status; ?></span></label>
                  <div class="col-sm-10">
                    <div class="well well-sm" style="height: 150px; overflow: auto;">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <div class="checkbox">
                        <label>
                          <?php if (in_array($order_status['order_status_id'], $config_complete_status)) { ?>
                          <input type="checkbox" name="config_complete_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                          <?php echo $order_status['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="config_complete_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                          <?php echo $order_status['name']; ?>
                          <?php } ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                    <?php if ($error_complete_status) { ?>
                    <div class="text-danger"><?php echo $error_complete_status; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_order_mail; ?>"><?php echo $entry_order_mail; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_order_mail) { ?>
                      <input type="radio" name="config_order_mail" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_order_mail" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_order_mail) { ?>
                      <input type="radio" name="config_order_mail" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_order_mail" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_stock; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock_display; ?>"><?php echo $entry_stock_display; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_stock_display) { ?>
                      <input type="radio" name="config_stock_display" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_stock_display" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_stock_display) { ?>
                      <input type="radio" name="config_stock_display" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_stock_display" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock_warning; ?>"><?php echo $entry_stock_warning; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_stock_warning) { ?>
                      <input type="radio" name="config_stock_warning" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_stock_warning" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_stock_warning) { ?>
                      <input type="radio" name="config_stock_warning" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_stock_warning" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock_checkout; ?>"><?php echo $entry_stock_checkout; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_stock_checkout) { ?>
                      <input type="radio" name="config_stock_checkout" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_stock_checkout" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_stock_checkout) { ?>
                      <input type="radio" name="config_stock_checkout" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_stock_checkout" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_affiliate; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_affiliate_approval; ?>"><?php echo $entry_affiliate_approval; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_affiliate_approval) { ?>
                      <input type="radio" name="config_affiliate_approval" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_affiliate_approval" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_affiliate_approval) { ?>
                      <input type="radio" name="config_affiliate_approval" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_affiliate_approval" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_affiliate_auto; ?>"><?php echo $entry_affiliate_auto; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_stock_checkout) { ?>
                      <input type="radio" name="config_affiliate_auto" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_affiliate_auto" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_stock_checkout) { ?>
                      <input type="radio" name="config_affiliate_auto" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_affiliate_auto" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-affiliate-commission"><span data-toggle="tooltip" title="<?php echo $help_affiliate_commission; ?>"><?php echo $entry_affiliate_commission; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_affiliate_commission" value="<?php echo $config_affiliate_commission; ?>" placeholder="<?php echo $entry_affiliate_commission; ?>" id="input-affiliate-commission" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-affiliate"><span data-toggle="tooltip" title="<?php echo $help_affiliate; ?>"><?php echo $entry_affiliate; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_affiliate_id" id="input-affiliate" class="form-control">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($informations as $information) { ?>
                      <?php if ($information['information_id'] == $config_affiliate_id) { ?>
                      <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_affiliate_mail; ?>"><?php echo $entry_affiliate_mail; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_affiliate_mail) { ?>
                      <input type="radio" name="config_affiliate_mail" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_affiliate_mail" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_affiliate_mail) { ?>
                      <input type="radio" name="config_affiliate_mail" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_affiliate_mail" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_return; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-return"><span data-toggle="tooltip" title="<?php echo $help_return; ?>"><?php echo $entry_return; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_return_id" id="input-return" class="form-control">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($informations as $information) { ?>
                      <?php if ($information['information_id'] == $config_return_id) { ?>
                      <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-return-status"><span data-toggle="tooltip" title="<?php echo $help_return_status; ?>"><?php echo $entry_return_status; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_return_status_id" id="input-return-status" class="form-control">
                      <?php foreach ($return_statuses as $return_status) { ?>
                      <?php if ($return_status['return_status_id'] == $config_return_status_id) { ?>
                      <option value="<?php echo $return_status['return_status_id']; ?>" selected="selected"><?php echo $return_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $return_status['return_status_id']; ?>"><?php echo $return_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </fieldset>
            </div>

					<div class="tab-pane" id="tab-avalara">
						<fieldset>
						
						<!--********************************************************************************************
						*   Last Updated On		:	08/11/2015			                            					*
						*   Description        	:   Added for self provisioning & Free Trial to create new account 		*
						**********************************************************************************************-->
						
						<div name="config_avatax_main_screen" id="config_avatax_main_screen">
							<div style="margin-bottom:30px;"><font size="3"><strong>Already have an Avalara Account?</strong></font>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" style="width:100px;" id="button_config_avatax_existing_account" onClick="javascript:document.getElementById('tab-avalara-existing-user').style.display = 'block';document.getElementById('tab-avalara-new-user').style.display = 'none';document.getElementById('config_avatax_main_screen').style.display = 'none';" data-loading-text="Loading..." class="btn btn-primary" value="Sign In"></input></div>

							<div><font size="3"><strong>New to Avalara? Let's sign you up!</strong></font> &nbsp;&nbsp;<input type="button" style="width:100px;" id="button_config_avatax_new_account" onClick="javascript:document.getElementById('tab-avalara-existing-user').style.display = 'none';document.getElementById('tab-avalara-new-user').style.display = 'block';document.getElementById('config_avatax_main_screen').style.display = 'none';fillNewAccountForm();" data-loading-text="Loading..." class="btn btn-primary" value="Sign Up"></input><br>30 days free trial. No credit card required.</div>
						</div>

						<?php
						if(isset($config_avatax_account) && ($config_avatax_account <>""))	{	?>
						<script>
						//alert('inside loop');
						//$("#button_config_avatax_existing_account").trigger('click');
						</script>
						<?php	}	?>

						</fieldset>

						<div class="tab-pane" id="tab-avalara-new-user-credentials" style="display:none;">
						<legend>Here Are Your Avalara Credentials</legend>
						<fieldset>
						<div id="avalara-new-user-account-status" style="display:none;"></div>
						</fieldset>
						<fieldset>
						<div id="avalara-new-user-account-credentials" style="display:none;">
						<input type="hidden" name="avalara_new_license_key" id="avalara_new_license_key">
						<input type="hidden" name="avalara_new_account_id" id="avalara_new_account_id">
						</div>
						</div>

						<div class="tab-pane" id="tab-avalara-new-user" style="display:none;">
						<fieldset>
						<legend>Avalara Subscription - Free Trial</legend><br>
						</fieldset>

						<fieldset>
						<legend>Company Profile</legend>
						<p>Please fill below information to create your account.</p>
						<p>Lets' make sure we have the right info to get you quickly setup!</p><br>
						
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_company">Company Name</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_company" placeholder="Company Name" id="config_avatax_newaccount_company" class="form-control" />
								<div id="config_avatax_newaccount_company_error"></div>
							</div>
						</div>
							
						<div class="form-group required">
						<!-- It must have 9 characters -->
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_tin">Business Tax Identification Number (TIN)</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_tin" placeholder="TIN (US Companies)" id="config_avatax_newaccount_tin" class="form-control" />
								<div id="config_avatax_newaccount_tin_error"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_bin">Business Identification Number (BIN)</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_bin" placeholder="BIN (International Companies BIN or VAT #)" id="config_avatax_newaccount_bin" class="form-control" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address">Address</label>
							<div class="col-sm-10"></div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address_line1">Line 1</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_address_line1" placeholder="Address Line 1" id="config_avatax_newaccount_address_line1" class="form-control" />
								<div id="config_avatax_newaccount_address_line1_error"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address_line2">Line 2</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_address_line2" placeholder="Address Line 2" id="config_avatax_newaccount_address_line2" class="form-control" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address_line3">Line 3</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_address_line3" placeholder="Address Line 3" id="config_avatax_newaccount_address_line3" class="form-control" />
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address_city">City</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_address_city" placeholder="City" id="config_avatax_newaccount_address_city" class="form-control" />
								<div id="config_avatax_newaccount_address_city_error"></div>
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address_country">Country</label>
							<div class="col-sm-10">
								<select name="config_avatax_newaccount_address_country" id="config_avatax_newaccount_address_country" class="form-control">
									<?php foreach ($countries as $country) { ?>
										<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
									<?php } ?>
							  </select>
							  <div id="config_avatax_newaccount_address_country_error"></div>
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address_state">Region / State</label>
							<div class="col-sm-10">
								<select name="config_avatax_newaccount_address_state" id="config_avatax_newaccount_address_state" class="form-control">
								</select>
								<div id="config_avatax_newaccount_address_state_error"></div>
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_address_zip">Zip / Postal Code</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_address_zip" placeholder="Zip / Postal Code" id="config_avatax_newaccount_address_zip" class="form-control" />
								<div id="config_avatax_newaccount_address_zip_error"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact">Primary Contact</label>
							<div class="col-sm-10"></div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact_title">Title</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_contact_title" placeholder="Title" id="config_avatax_newaccount_contact_title" class="form-control" />
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact_firstname">First Name</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_contact_firstname" placeholder="First Name" id="config_avatax_newaccount_contact_firstname" class="form-control" />
								<div id="config_avatax_newaccount_contact_firstname_error"></div>
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact_lastname">Last Name</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_contact_lastname" placeholder="Last Name" id="config_avatax_newaccount_contact_lastname" class="form-control" />
								<div id="config_avatax_newaccount_contact_lastname_error"></div>
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact_email">Email Address</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_contact_email" placeholder="Email Address" id="config_avatax_newaccount_contact_email" class="form-control" />
								<div id="config_avatax_newaccount_contact_email_error"></div>
							</div>
						</div>

						<div class="form-group required">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact_phone">Phone Number</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_contact_phone" placeholder="Phone Number" id="config_avatax_newaccount_contact_phone" class="form-control" />
								<div id="config_avatax_newaccount_contact_phone_error"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact_mobile">Mobile Phone Number</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_contact_mobile" placeholder="Mobile Phone Number" id="config_avatax_newaccount_contact_mobile" class="form-control" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_newaccount_contact_fax">Fax</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_newaccount_contact_fax" placeholder="Fax" id="config_avatax_newaccount_contact_fax" class="form-control" />
							</div>
						</div>
						<p>&nbsp;</p>
						</fieldset>
						
						<fieldset>
						<legend>Where Should You Collect Tax?</legend>
						 <div>Looking at your company address, we'll create nexus for you for below address</div>
						 <div class="form-group">

							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10">
								<label class="col-sm-10 control-label" id="config_avatax_account_nexus_country" style="text-align:left">Not Available</label>
							</div>
						 </div>

						 <div class="form-group">
							<label class="col-sm-2 control-label">State / Province</label>
							<div class="col-sm-10">
								<label class="col-sm-10 control-label" id="config_avatax_account_nexus_state" style="text-align:left">Not Available</label>
							</div>
						 </div>
							
							<p><strong>If you need to collect tax in more locations, visit <a href="https://admin-avatax.avalara.net">Avalara Customer Portal</a>.</strong></p>
							<p><div id="avatax-account-error" align="center" class="text-danger" style="display:block;"></div></p>
						</fieldset>
						
						<fieldset>

					<script type="text/javascript">
					//Once the new account cretaion form is ready, this function will fetch the auto filled values from Store & General tab and fill into this form
					function fillNewAccountForm()
					{
						$('#config_avatax_newaccount_company').val($('#config_name').val());
						$('#config_avatax_newaccount_address_line1').val($('#config_address').val());
						$('#config_avatax_newaccount_address_line2').val($('#config_address_line2').val());
						$('#config_avatax_newaccount_address_city').val($('#config_city').val());
						$('#config_avatax_newaccount_address_zip').val($('#config_postal_code').val());

						$('#config_avatax_newaccount_address_country').val($('#input-country option:selected').val());
						$('select[name=\'config_avatax_newaccount_address_country\']').trigger('change');
						//Set time out as jquery takes time to fill values in State drop down after selecting country
						setTimeout(function(){
							//alert($('#input-zone option:selected').val());
							//alert($('#config_avatax_newaccount_address_state option:selected').val());
							$('#config_avatax_newaccount_address_state').val($('#input-zone option:selected').val());
							$('#config_avatax_account_nexus_state').text($('#input-zone option:selected').text());
						}, 2000);

						$('#config_avatax_newaccount_contact_firstname').val($('#input-owner').val());
						$('#config_avatax_newaccount_contact_email').val($('#input-email').val());
						$('#config_avatax_newaccount_contact_fax').val($('#input-fax').val());
					}
					</script>

						<div align="center">
						<input type="button" id="submit-new-account-button" data-loading-text="Loading..." class="btn btn-primary" value="Setup Account"></input>
						<input type="reset" class="btn btn-primary" id="reset" name="reset" value="Reset"></input>
						</div>
	
						</fieldset>
					</div>

					<div class="tab-pane" id="tab-avalara-existing-user" style="display:none;">
						<fieldset>
						<legend>Avalara Avatax Credentials</legend>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   Added account ID option in Avalara tab   								*
						 *****************************************************************************************************-->

						 <div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_account">Account ID:</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_account" value="<?php echo $config_avatax_account; ?>" placeholder="Account ID" id="config_avatax_account" class="form-control" />
								<?php if ($error_avatax_account) { ?>
								<div class="text-danger"><?php echo $error_avatax_account; ?></div>
							<?php } ?>
							<div id="config_avatax_account-error" style="display:none;">Please enter valid Account ID</div>
							</div>
						</div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   Added License Key option in Avalara tab   								*
						 *****************************************************************************************************-->

						 <div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_license_key">License Key:</label>
							<div class="col-sm-10">
								<input type="text" name="config_avatax_license_key" value="<?php echo $config_avatax_license_key; ?>" placeholder="License Key" id="config_avatax_license_key" class="form-control" />
								<?php if ($error_avatax_license_key) { ?>
								<div class="text-danger"><?php echo $error_avatax_license_key; ?></div>
							<?php } ?>
							<div id="config_avatax_license_key-error" style="display:none;">Please enter valid License Key</div>
							</div>
						</div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   Assigned unique client key of connector.    								*
						 *****************************************************************************************************-->

						 <?php $version = "OpenCart ".VERSION."||02.00.02.00";	?>
						<input type="hidden" name="config_avatax_client" value="<?=$version?>" id="config_avatax_client" />

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-country">Service URL:</label>
							<div class="col-sm-10">
								<select name="config_avatax_service_url" id="config_avatax_service_url" class="form-control">
								<?php if($config_avatax_service_url=='https://development.avalara.net')	{	?>
									<option value="https://development.avalara.net" selected="selected">https://development.avalara.net</option>
									<option value="https://avatax.avalara.net">https://avatax.avalara.net</option>
									<?php	}	else	{	?>
									<option value="https://development.avalara.net">https://development.avalara.net</option>
									<option value="https://avatax.avalara.net" selected="selected">https://avatax.avalara.net</option>
								<?php	}	?>
								</select>
								<div id="config_avatax_service_url-error" style="display:none;">Please select Service URL.</div>
							</div>
						</div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   Option added to Avalara tab. Clicking on test connection button, avatax_test_connection.php page will be called to test the connection. Service URL, account ID, license key will be passed to check whether user has enetered proper credentials.      																*
						 *****************************************************************************************************-->

						 <div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_service_url">Make a test call to the AvaTax Service:</label>
							<div class="col-sm-10"><br>
								<a href="javascript:;" id="AvaTaxTestConnection" ><img src="view/image/Avatax_test_connection.png" title="AvaTax Tax - Test Connection" alt="AvaTax Tax - Test Connection" /></a>
							</div>
						</div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   Enter AvaTax admin console company name here. 								*
						 *****************************************************************************************************-->

						<div class="form-group" style="display:block;" id="config_avatax_company_code_div">
							<label class="col-sm-2 control-label" for="config_avatax_company_code">Company Name: &nbsp;&nbsp;<img src="../image/question.jpg" title="Please click on Test Connection button to Fetch Companies for entered Avalara Account Credentials"></label>
							<div class="col-sm-10">
								<select name="config_avatax_company_code" id="config_avatax_company_code" class="form-control">
								<?php
								if(isset($config_avatax_company_code_value_array) && (trim($config_avatax_company_code_value_array)<>""))
								{
									$company_code_array = explode(",",$config_avatax_company_code_value_array);
									foreach($company_code_array as $array_value)
									{
										$company_options_arrray = explode("-",$array_value);
										if($config_avatax_company_code == $company_options_arrray[0] || $company_options_arrray[0] == "")
											$selected = "Selected";
										else
											$selected = "";
									?>
										<option value="<?=$company_options_arrray[0]?>"<?=$selected?>><?=$company_options_arrray[1]?></option>
									<?php	
									}
								}
								?>
								</select>
								<input type="hidden" id="config_avatax_company_code_value" name="config_avatax_company_code_value" value="<?=$config_avatax_company_code?>">
								<input type="hidden" id="config_avatax_company_code_value_array" name="config_avatax_company_code_value_array" value="<?php echo $config_avatax_company_code_value_array; ?>">

								<?php if ($error_avatax_company_code) { ?>
									<div class="text-danger"><?php echo $error_avatax_company_code; ?></div>
								<?php } ?>
								<div id="config_avatax_company_code-error" style="display:none;">Please select Company Name.</div>
							</div>
						</div>

						<div class="form-group">&nbsp;</div>
					</fieldset>

					<fieldset>
						<legend>Tax Calculation Settings</legend>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   If enabled, AvaTax functions will be calculated & tax will be calculated.	*
						 *****************************************************************************************************-->

						 <div class="form-group">
						  <label class="col-sm-2 control-label">Enable AvaTax tax calculation:</label>
						  <div class="col-sm-10">
							<label class="radio-inline">
							  <?php if ($config_avatax_tax_calculation) { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_yes" value="1" checked="checked" />
							  <?php echo $text_yes; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_yes" value="1" />
							  <?php echo $text_yes; ?>

							  <?php } ?>
							</label>
							<label class="radio-inline">
							  <?php if (!$config_avatax_tax_calculation) { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_no" value="0" checked="checked" />
							  <?php echo $text_no; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_no" value="0" />
							  <?php echo $text_no; ?>
							  <?php } ?>
							</label>
						  </div>
						</div>

						<div class="form-group">&nbsp;</div>
						</fieldset>

					<fieldset>
						<legend>Tax Profile Assistant</legend>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   If enabled, AvaTax functions will be calculated & tax will be calculated.	*
						 *****************************************************************************************************-->

						 <div class="form-group">
						  <label class="col-sm-2 control-label">Enable AvaTax tax calculation:</label>
						  <div class="col-sm-10">
							<label class="radio-inline">
							  <?php if ($config_avatax_tax_calculation) { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_yes" value="1" checked="checked" />
							  <?php echo $text_yes; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_yes" value="1" />
							  <?php echo $text_yes; ?>

							  <?php } ?>
							</label>
							<label class="radio-inline">
							  <?php if (!$config_avatax_tax_calculation) { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_no" value="0" checked="checked" />
							  <?php echo $text_no; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_tax_calculation" id="config_avatax_tax_calculation_no" value="0" />
							  <?php echo $text_no; ?>
							  <?php } ?>
							</label>
						  </div>
						</div>

						<div class="form-group">&nbsp;</div>
					</fieldset>
						
					<fieldset>
						<legend>Address Validation Settings</legend>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   If enabled, AddressValidation() service will be called to validate the address. Address validation button will be available on store address & customer address in admin panel					*
						 *****************************************************************************************************-->

						 <div class="form-group">
							<label class="col-sm-2 control-label">Enable AvaTax address validation:</label>
							<div class="col-sm-10">
							<label class="radio-inline">
							  <?php if ($config_avatax_tax_address_validation) { ?>
							  <input type="radio" name="config_avatax_tax_address_validation"  value="1" checked="checked" />
							  <?php echo $text_yes; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_tax_address_validation" value="1" />
							  <?php echo $text_yes; ?>

							  <?php } ?>
							</label>
							<label class="radio-inline">
							  <?php if (!$config_avatax_tax_address_validation) { ?>
							  <input type="radio" name="config_avatax_tax_address_validation" value="0" checked="checked" />
							  <?php echo $text_no; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_tax_address_validation" value="0" />
							  <?php echo $text_no; ?>
							  <?php } ?>
							</label>
							</div>
						</div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	07/13/2015			                            							*
						 *   Description        :   Added an option to return results in upper case.   							*
						 *   AddressValidation() service will return results in Upper case if this option is enabled else deafult case	*
						 *****************************************************************************************************-->

						<div class="form-group">
							<label class="col-sm-2 control-label">Return results in upper case:</label>
							<div class="col-sm-10">
							<label class="radio-inline">
							  <?php if ($config_avatax_return_address_result) { ?>
							  <input type="radio" name="config_avatax_return_address_result"  value="1" checked="checked" />
							  <?php echo $text_yes; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_return_address_result" value="1" />
							  <?php echo $text_yes; ?>

							  <?php } ?>
							</label>
							<label class="radio-inline">
							  <?php if (!$config_avatax_return_address_result) { ?>
							  <input type="radio" name="config_avatax_return_address_result" value="0" checked="checked" />
							  <?php echo $text_no; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_return_address_result" value="0" />
							  <?php echo $text_no; ?>
							  <?php } ?>
							</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-country">Only Validate addresses in:</label>
							<div class="col-sm-10">
							<select name="config_avatax_validate_address_in" class="form-control">
								<?php  if ($config_avatax_validate_address_in == 'US') { ?>
								<option value="US" selected="selected">USA</option>
								<option value="CA">Canada</option>
								<option value="both">Both</option>
								<?php } else if ($config_avatax_validate_address_in == 'CA') { ?>
								<option value="US">USA</option>
								<option value="CA" selected="selected">Canada</option>
								<option value="both">Both</option>
								<?php } else if ($config_avatax_validate_address_in == 'both') { ?>
								<option value="US">USA</option>
								<option value="CA">Canada</option>
								<option value="both" selected="selected">Both</option>
								<?php } else { ?>
								<option value="US">USA</option>
								<option value="CA">Canada</option>
								<option value="both" selected="selected" >Both</option>
								<?php } ?>
							</select>
							</div>
						</div>

						<div class="form-group">&nbsp;</div>
						</fieldset>

						<fieldset>
						<legend>Customer Specific Settings</legend>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   If enabled, entries will be stored on AvaTax admin console. If disabled and tax calculation is enabled, tax will be calculated in checkout page at store front but entries will not be stored on admin console		*
						 *****************************************************************************************************-->

						 <div class="form-group">
							<label class="col-sm-2 control-label">Do you want to save transaction on AvaTax:</label>
							<div class="col-sm-10">
								<label class="radio-inline">
								<?php if ($config_avatax_transaction_calculation) { ?>
								<input type="radio" name="config_avatax_transaction_calculation" id="config_avatax_transaction_calculation" value="1" checked="checked" />
								<?php echo $text_yes; ?>
								<?php } else { ?>
								<input type="radio" name="config_avatax_transaction_calculation" id="config_avatax_transaction_calculation" value="1" />
								<?php echo $text_yes; ?>

								<?php } ?>
								</label>
								<label class="radio-inline">
								<?php if (!$config_avatax_transaction_calculation) { ?>
								<input type="radio" name="config_avatax_transaction_calculation" id="config_avatax_transaction_calculation" value="0" checked="checked" />
								<?php echo $text_no; ?>
								<?php } else { ?>
								<input type="radio" name="config_avatax_transaction_calculation" id="config_avatax_transaction_calculation" value="0" />
								<?php echo $text_no; ?>
								<?php } ?>
								</label>
							</div>
						</div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	06/02/2015			                            							*
						 *   Description        :   If enabled, log files will be genereated for each AvaTax transaction. 		*
													Log files will be stored in system\AvaTax4PHP\classes\ava-logs folder		*
						 *****************************************************************************************************-->
						 <div class="form-group">
							<label class="col-sm-2 control-label">Enable Log:</label>
							<div class="col-sm-10">
								<label class="radio-inline">
								<?php if ($config_avatax_log) { ?>
								<input type="radio" name="config_avatax_log" id="config_avatax_log" value="1" checked="checked" />
								<?php echo $text_yes; ?>
								<?php } else { ?>
								<input type="radio" name="config_avatax_log" id="config_avatax_log" value="1" />
								<?php echo $text_yes; ?>

								<?php } ?>
							</label>
							<label class="radio-inline">
							  <?php if (!$config_avatax_log) { ?>
							  <input type="radio" name="config_avatax_log" id="config_avatax_log" value="0" checked="checked" />
							  <?php echo $text_no; ?>
							  <?php } else { ?>
							  <input type="radio" name="config_avatax_log" id="config_avatax_log" value="0" />
							  <?php echo $text_no; ?>
							  <?php } ?>
							</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Send Model Number/UPC/SKU to AvaTax:</label>
							<div class="col-sm-10">
								<label class="radio-inline">
								<?php if (($config_avatax_product_code<>"UPC") && ($config_avatax_product_code<>"SKU")) { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="Model" checked="checked" />
								<?php echo "Model"; ?>
								<?php } ?>
								<?php if ($config_avatax_product_code=="UPC") { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="Model" />
								<?php echo "Model"; ?>
								<?php } ?>
								<?php if ($config_avatax_product_code=="SKU") { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="Model" />
								<?php echo "Model"; ?>
								<?php } ?>
								</label>
								<label class="radio-inline">
								<?php if ($config_avatax_product_code=="UPC") { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="UPC" checked="checked"/>
								<?php echo "UPC"; ?>
								<?php } ?>
								<?php if (($config_avatax_product_code<>"UPC") && ($config_avatax_product_code<>"SKU")) { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="UPC" />
								<?php echo "UPC"; ?>
								<?php } ?>
								<?php if ($config_avatax_product_code=="SKU") { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="UPC" />
								<?php echo "UPC"; ?>
								<?php } ?>
								</label>
								<label class="radio-inline">
								<?php if ($config_avatax_product_code=="SKU") { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="SKU" checked="checked" />
								<?php echo "SKU"; ?>
								<?php } ?>
								<?php if (($config_avatax_product_code<>"UPC") && ($config_avatax_product_code<>"SKU")) { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="SKU" />
								<?php echo "SKU"; ?>
								<?php } ?>
								<?php if ($config_avatax_product_code=="UPC") { ?>
								<input type="radio" name="config_avatax_product_code" id="config_avatax_product_code" value="SKU" />
								<?php echo "SKU"; ?>
								<?php } ?>
								</label>
								&nbsp;&nbsp;<img src="../image/question.jpg" title="If UPC/SKU is not available then Model Number will be sent to AvaTax by default">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-10">
								<input type="hidden" name="config_avatax_taxcall_flag" id="config_avatax_taxcall_flag" value="0" />
							</div>
						</div>

						 <!--****************************************************************************************************
						 *   Last Updated On	:	07/07/2015			                            							*
						 *   Description        :   Added logo button to test connection window as per ticket - CONNECT-2717.   *
						 *  Called AvaTaxTestConnectionDialog() jquery function on click event to handle dialog box. 			*
						 *****************************************************************************************************-->

						 <div class="form-group">
							<div class="col-sm-10">
								<div id="AvaTaxTestConnectionDialog" title="<img src='view/image/Ava-logo.jpg'> AvaTax Test Connection" style="display:none;"></div>
							</div>
						</div>

						<div><input type="hidden" name="EnableAvaTaxValidation" id="EnableAvaTaxValidation"  /></div>
					</fieldset>

					<fieldset>
					<legend>Avalara Details</legend>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_details">About Avalara:</label>
							<div class="col-sm-10" style="margin-top:10px">Copyright &copy; 2015 Avalara, Inc. All Rights Reserved.
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_details">AvaTax Version:</label>
							<div class="col-sm-10" style="margin-top:10px"><?php echo $version; ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_service_url">Admin Console link:</label>
							<div class="col-sm-10" style="margin-top:10px">
							<a href="https://admin-avatax.avalara.net/login.aspx" id="AvaTax Production Admin Console" target="_blank">Click Here for Admin Console Production Link</a>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="config_avatax_help_link">Help Center:</label>
							<div class="col-sm-10" style="margin-top:10px">
							<a href="https://help.avalara.com/004_AvaTax_Integrations/OpenCart" id="AvaTax Help Link" target="_blank">Click Here for Help Center Link</a>
							</div>
						</div>
						</fieldset>
						</div>
				</div>
			
            <div class="tab-pane" id="tab-image">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-logo"><?php echo $entry_logo; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-logo" data-toggle="image" class="img-thumbnail"><img src="<?php echo $logo; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="config_logo" value="<?php echo $config_logo; ?>" id="input-logo" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-icon"><?php echo $entry_icon; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-icon" data-toggle="image" class="img-thumbnail"><img src="<?php echo $icon; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="config_icon" value="<?php echo $config_icon; ?>" id="input-icon" />
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-category-width"><?php echo $entry_image_category; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_category_width" value="<?php echo $config_image_category_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-category-width" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_category_height" value="<?php echo $config_image_category_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_category) { ?>
                  <div class="text-danger"><?php echo $error_image_category; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-thumb-width"><?php echo $entry_image_thumb; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-thumb-width" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_thumb) { ?>
                  <div class="text-danger"><?php echo $error_image_thumb; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-popup-width"><?php echo $entry_image_popup; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-popup-width" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_popup) { ?>
                  <div class="text-danger"><?php echo $error_image_popup; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-product-width"><?php echo $entry_image_product; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-product-width" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_product) { ?>
                  <div class="text-danger"><?php echo $error_image_product; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-additional-width"><?php echo $entry_image_additional; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-additional-width" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_additional) { ?>
                  <div class="text-danger"><?php echo $error_image_additional; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-related"><?php echo $entry_image_related; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_related_width" value="<?php echo $config_image_related_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-related" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_related_height" value="<?php echo $config_image_related_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_related) { ?>
                  <div class="text-danger"><?php echo $error_image_related; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-compare"><?php echo $entry_image_compare; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_compare_width" value="<?php echo $config_image_compare_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-compare" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_compare_height" value="<?php echo $config_image_compare_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_compare) { ?>
                  <div class="text-danger"><?php echo $error_image_compare; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-wishlist"><?php echo $entry_image_wishlist; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_wishlist_width" value="<?php echo $config_image_wishlist_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-wishlist" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_wishlist_height" value="<?php echo $config_image_wishlist_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_wishlist) { ?>
                  <div class="text-danger"><?php echo $error_image_wishlist; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-cart"><?php echo $entry_image_cart; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_cart_width" value="<?php echo $config_image_cart_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-cart" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_cart_height" value="<?php echo $config_image_cart_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_cart) { ?>
                  <div class="text-danger"><?php echo $error_image_cart; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-location"><?php echo $entry_image_location; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_location_width" value="<?php echo $config_image_location_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-location" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_location_height" value="<?php echo $config_image_location_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_location) { ?>
                  <div class="text-danger"><?php echo $error_image_location; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-ftp">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ftp-host"><?php echo $entry_ftp_hostname; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_ftp_hostname" value="<?php echo $config_ftp_hostname; ?>" placeholder="<?php echo $entry_ftp_hostname; ?>" id="input-ftp-host" class="form-control" />
                  <?php if ($error_ftp_hostname) { ?>
                  <div class="text-danger"><?php echo $error_ftp_hostname; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ftp-port"><?php echo $entry_ftp_port; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_ftp_port" value="<?php echo $config_ftp_port; ?>" placeholder="<?php echo $entry_ftp_port; ?>" id="input-ftp-port" class="form-control" />
                  <?php if ($error_ftp_port) { ?>
                  <div class="text-danger"><?php echo $error_ftp_port; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ftp-username"><?php echo $entry_ftp_username; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_ftp_username" value="<?php echo $config_ftp_username; ?>" placeholder="<?php echo $entry_ftp_username; ?>" id="input-ftp-username" class="form-control" />
                  <?php if ($error_ftp_username) { ?>
                  <div class="text-danger"><?php echo $error_ftp_username; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ftp-password"><?php echo $entry_ftp_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_ftp_password" value="<?php echo $config_ftp_password; ?>" placeholder="<?php echo $entry_ftp_password; ?>" id="input-ftp-password" class="form-control" />
                  <?php if ($error_ftp_password) { ?>
                  <div class="text-danger"><?php echo $error_ftp_password; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ftp-root"><span data-toggle="tooltip" data-html="true" title="<?php echo htmlspecialchars($help_ftp_root); ?>"><?php echo $entry_ftp_root; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_ftp_root" value="<?php echo $config_ftp_root; ?>" placeholder="<?php echo $entry_ftp_root; ?>" id="input-ftp-root" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_ftp_status; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_ftp_status) { ?>
                    <input type="radio" name="config_ftp_status" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_ftp_status" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_ftp_status) { ?>
                    <input type="radio" name="config_ftp_status" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_ftp_status" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-mail">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-protocol"><span data-toggle="tooltip" title="<?php echo $help_mail_protocol; ?>"><?php echo $entry_mail_protocol; ?></span></label>
                <div class="col-sm-10">
                  <select name="config_mail_protocol" id="input-mail-protocol" class="form-control">
                    <?php if ($config_mail_protocol == 'mail') { ?>
                    <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
                    <?php } else { ?>
                    <option value="mail"><?php echo $text_mail; ?></option>
                    <?php } ?>
                    <?php if ($config_mail_protocol == 'smtp') { ?>
                    <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
                    <?php } else { ?>
                    <option value="smtp"><?php echo $text_smtp; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-parameter"><span data-toggle="tooltip" title="<?php echo $help_mail_parameter; ?>"><?php echo $entry_mail_parameter; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_parameter" value="<?php echo $config_mail_parameter; ?>" placeholder="<?php echo $entry_mail_parameter; ?>" id="input-mail-parameter" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-hostname"><span data-toggle="tooltip" title="<?php echo $help_mail_smtp_hostname; ?>"><?php echo $entry_mail_smtp_hostname; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_hostname" value="<?php echo $config_mail_smtp_hostname; ?>" placeholder="<?php echo $entry_mail_smtp_hostname; ?>" id="input-mail-smtp-hostname" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-username"><?php echo $entry_mail_smtp_username; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_username" value="<?php echo $config_mail_smtp_username; ?>" placeholder="<?php echo $entry_mail_smtp_username; ?>" id="input-mail-smtp-username" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-password"><?php echo $entry_mail_smtp_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_password" value="<?php echo $config_mail_smtp_password; ?>" placeholder="<?php echo $entry_mail_smtp_password; ?>" id="input-mail-smtp-password" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-port"><?php echo $entry_mail_smtp_port; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_port" value="<?php echo $config_mail_smtp_port; ?>" placeholder="<?php echo $entry_mail_smtp_port; ?>" id="input-mail-smtp-port" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-timeout"><?php echo $entry_mail_smtp_timeout; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_timeout" value="<?php echo $config_mail_smtp_timeout; ?>" placeholder="<?php echo $entry_mail_smtp_timeout; ?>" id="input-mail-smtp-timeout" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-alert-email"><span data-toggle="tooltip" title="<?php echo $help_mail_alert; ?>"><?php echo $entry_mail_alert; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_mail_alert" rows="5" placeholder="<?php echo $entry_mail_alert; ?>" id="input-alert-email" class="form-control"><?php echo $config_mail_alert; ?></textarea>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-fraud">
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($help_fraud_detection); ?>"><?php echo $entry_fraud_detection; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_fraud_detection) { ?>
                    <input type="radio" name="config_fraud_detection" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_fraud_detection" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_fraud_detection) { ?>
                    <input type="radio" name="config_fraud_detection" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_fraud_detection" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-fraud-key"><?php echo $entry_fraud_key; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_fraud_key" value="<?php echo $config_fraud_key; ?>" placeholder="<?php echo $entry_fraud_key; ?>" id="input-fraud-key" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-fraud-score"><span data-toggle="tooltip" title="<?php echo $help_fraud_score; ?>"><?php echo $entry_fraud_score; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_fraud_score" value="<?php echo $config_fraud_score; ?>" placeholder="<?php echo $entry_fraud_score; ?>" id="input-fraud-score" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-fraud-status"><span data-toggle="tooltip" title="<?php echo $help_fraud_status; ?>"><?php echo $entry_fraud_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="config_fraud_status_id" id="input-fraud-status" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $config_fraud_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-server">
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_secure; ?>"><?php echo $entry_secure; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_secure) { ?>
                    <input type="radio" name="config_secure" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_secure" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_secure) { ?>
                    <input type="radio" name="config_secure" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_secure" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_shared; ?>"><?php echo $entry_shared; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_shared) { ?>
                    <input type="radio" name="config_shared" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_shared" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_shared) { ?>
                    <input type="radio" name="config_shared" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_shared" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-robots"><span data-toggle="tooltip" title="<?php echo $help_robots; ?>"><?php echo $entry_robots; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_robots" rows="5" placeholder="<?php echo $entry_robots; ?>" id="input-robots" class="form-control"><?php echo $config_robots; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_seo_url; ?>"><?php echo $entry_seo_url; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_seo_url) { ?>
                    <input type="radio" name="config_seo_url" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_seo_url" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_seo_url) { ?>
                    <input type="radio" name="config_seo_url" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_seo_url" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-file-max-size"><span data-toggle="tooltip" title="<?php echo $help_file_max_size; ?>"><?php echo $entry_file_max_size; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_file_max_size" value="<?php echo $config_file_max_size; ?>" placeholder="<?php echo $entry_file_max_size; ?>" id="input-file-max-size" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-file-ext-allowed"><span data-toggle="tooltip" title="<?php echo $help_file_ext_allowed; ?>"><?php echo $entry_file_ext_allowed; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_file_ext_allowed" rows="5" placeholder="<?php echo $entry_file_ext_allowed; ?>" id="input-file-ext-allowed" class="form-control"><?php echo $config_file_ext_allowed; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-file-mime-allowed"><span data-toggle="tooltip" title="<?php echo $help_file_mime_allowed; ?>"><?php echo $entry_file_mime_allowed; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_file_mime_allowed" cols="60" rows="5" placeholder="<?php echo $entry_file_mime_allowed; ?>" id="input-file-mime-allowed" class="form-control"><?php echo $config_file_mime_allowed; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_maintenance; ?>"><?php echo $entry_maintenance; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_maintenance) { ?>
                    <input type="radio" name="config_maintenance" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_maintenance" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_maintenance) { ?>
                    <input type="radio" name="config_maintenance" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_maintenance" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_password; ?>"><?php echo $entry_password; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_password) { ?>
                    <input type="radio" name="config_password" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_password" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_password) { ?>
                    <input type="radio" name="config_password" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_password" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-encryption"><span data-toggle="tooltip" title="<?php echo $help_encryption; ?>"><?php echo $entry_encryption; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" placeholder="<?php echo $entry_encryption; ?>" id="input-encryption" class="form-control" />
                  <?php if ($error_encryption) { ?>
                  <div class="text-danger"><?php echo $error_encryption; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-compression"><span data-toggle="tooltip" title="<?php echo $help_compression; ?>"><?php echo $entry_compression; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_compression" value="<?php echo $config_compression; ?>" placeholder="<?php echo $entry_compression; ?>" id="input-compression" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_error_display; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_error_display) { ?>
                    <input type="radio" name="config_error_display" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_display" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_error_display) { ?>
                    <input type="radio" name="config_error_display" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_display" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_error_log; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_error_log) { ?>
                    <input type="radio" name="config_error_log" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_log" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_error_log) { ?>
                    <input type="radio" name="config_error_log" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_log" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-error-filename"><?php echo $entry_error_filename; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" placeholder="<?php echo $entry_error_filename; ?>" id="input-error-filename" class="form-control" />
                  <?php if ($error_error_filename) { ?>
                  <div class="text-danger"><?php echo $error_error_filename; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-google">
              <fieldset>
                <legend><?php echo $text_google_analytics; ?></legend>
                <div class="alert alert-info"><?php echo $help_google_analytics; ?></div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-google-analytics"><?php echo $entry_google_analytics; ?></label>
                  <div class="col-sm-10">
                    <textarea name="config_google_analytics" rows="5" placeholder="<?php echo $entry_google_analytics; ?>" id="input-google-analytics" class="form-control"><?php echo $config_google_analytics; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-google-analytics-status"><?php echo $entry_status; ?></label>
                  <div class="col-sm-10">
                    <select name="config_google_analytics_status" id="input-google-analytics-status" class="form-control">
                      <?php if ($config_google_analytics_status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_google_captcha; ?></legend>
                <div class="alert alert-info"><?php echo $help_google_captcha; ?></div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-google-captcha-public"><?php echo $entry_google_captcha_public; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_google_captcha_public" value="<?php echo $config_google_captcha_public; ?>" placeholder="<?php echo $entry_google_captcha_public; ?>" id="input-google-captcha-public" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-google-captcha-secret"><?php echo $entry_google_captcha_secret; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_google_captcha_secret" value="<?php echo $config_google_captcha_secret; ?>" placeholder="<?php echo $entry_google_captcha_secret; ?>" id="input-google-captcha-secret" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-google-captcha-status"><?php echo $entry_status; ?></label>
                  <div class="col-sm-10">
                    <select name="config_google_captcha_status" id="input-google-captcha-status" class="form-control">
                      <?php if ($config_google_captcha_status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('select[name=\'config_template\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent(this.value),
		dataType: 'html',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(html) {
			$('#template').attr('src', html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'config_template\']').trigger('change');
//--></script> 
  <script type="text/javascript"><!--
$('select[name=\'config_country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=setting/setting/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'config_country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
          			html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $config_zone_id; ?>') {
            			html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('select[name=\'config_zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});


			$('select[name=\'config_avatax_newaccount_address_country\']').on('change', function() {
			$.ajax({
				url: 'index.php?route=setting/setting/country&token=<?php echo $token; ?>&country_id=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					$('select[name=\'config_avatax_newaccount_address_country\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
				},
				complete: function() {
					$('.fa-spin').remove();
				},
				success: function(json) {
			  $('.fa-spin').remove();

					html = '<option value=""><?php echo $text_select; ?></option>';

					if (json['zone'] != '') {
						for (i = 0; i < json['zone'].length; i++) {
				  html += '<option value="' + json['zone'][i]['zone_id'] + '"';

							if (json['zone'][i]['zone_id'] == '<?php echo $config_avatax_newaccount_address_state; ?>') {
					html += ' selected="selected"';
				  }

				  html += '>' + json['zone'][i]['name'] + '</option>';
						}
					} else {
						html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
					}

					$('select[name=\'config_avatax_newaccount_address_state\']').html(html);
					$('#config_avatax_account_nexus_country').text($('#config_avatax_newaccount_address_country option:selected').text());
					$('#config_avatax_account_nexus_state').text("");
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$("#config_avatax_newaccount_address_state").change(function () {
			$('#config_avatax_account_nexus_state').text($('#config_avatax_newaccount_address_state option:selected').text());
		});
		//$('select[name=\'config_avatax_newaccount_address_country\']').trigger('change');
		
$('select[name=\'config_country_id\']').trigger('change');
//--></script></div>

					<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
					<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

					<script type="text/javascript">
					var jQuery_1_8_16 = $.noConflict(true);
					</script>

					<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />

					<script type="text/javascript"><!--
					$('#validateaddress_error').click(function() {
						$(function() {
							jQuery_1_8_16("#validateaddress_error_dialog").dialog({
								modal: true,
								buttons: {
									OK: function() {
										jQuery_1_8_16( this ).dialog( "close" );
									}
								}
							});
						});
					});

					$('#validateAddress').click(function() {
						$.ajax({
							url: '../system/AvaTax4PHP/avatax_address_validation.php',
							type: 'post',
							data:'postalcode='+$('#config_postal_code').val()+'&line1='+$('#config_address').val()+'&line2='+$('#config_address_line2').val()+'&line3=&city='+$('#config_city').val()+'&region='+$('#input-zone').val()+'&account='+$('#config_avatax_account').val()+'&license='+$('#config_avatax_license_key').val()+'&service_url='+$('#config_avatax_service_url').val()+'&client='+$('#config_avatax_client').val()+'&log='+$('input[name=config_avatax_log]:checked').val()+'&text_case='+$('input[name=config_avatax_return_address_result]:checked').val(),
							beforeSend: function() {
								$('#validateAddress').button('loading');
							},		complete: function() {
								$('#validateAddress').button('reset');
							},
							success:function(data)	{
								var json = JSON.parse(data);
								if(json.address!=""){
									var validaddress=JSON.parse(json.address);
									//document.getElementById('validAddressData').value=json.address;
									validatedAddress = "<p>Do you want to update this address?</p><p><div style='align:left; float:left;'>Current Address - <br><strong>Line 1 </strong>-  "+$('#config_address').val()+"<br><strong>Line 2 </strong>- "+$('#config_address_line2').val()+"<br><strong>City </strong>- "+$('#config_city').val()+"<br><strong>Postal Code </strong>-  "+$('#config_postal_code').val()+"<br><strong>Region </strong>- "+$('#input-zone option:selected').text()+"<br><strong>Country </strong>- "+$('#input-country option:selected').text()+"<br><br></div><div style='align:right; float:right;margin-left:40px;'>Validated Address - <br><strong>Line 1 </strong>-  "+validaddress.Line1+"<br><strong>Line 2 </strong>- "+validaddress.Line2+"<br><strong>City </strong>- "+validaddress.City+"<br><strong>Postal Code </strong>-  "+validaddress.PostalCode+"<br><strong>Region </strong>- "+validaddress.Region_name+"<br><strong>Country </strong>- "+validaddress.Country_name+"<br><br></div></p>";

									jQuery_1_8_16("#AvaTaxStoreAddressValidateDialog").html(validatedAddress).dialog({
										title: "<img src='view/image/Ava-logo.jpg'> AvaTax Address Validation",
										resizable: true,
										modal: true,
										width: 'auto',
										buttons: {
											"Apply": function()
											{
												$('#config_address').val(validaddress.Line1);
												$('#config_address_line2').val(validaddress.Line2);
												$('#config_city').val(validaddress.City);
												$('#config_postal_code').val(validaddress.PostalCode);
												$('#input-country').val(validaddress.Country);
												$('#input-zone').val(validaddress.Region);
												//jQuery_1_8_16('#AvaTaxStoreAddressValidateDialog').dialog('close');
												jQuery_1_8_16( this ).dialog( "close" );
											},
											"Cancel": function()
											{
												jQuery_1_8_16( this ).dialog( "close" );
											}
										}
									});
								}
								else
								{
									invalidStoreAddress = "<p><div>Current Address - <br><strong>Line 1 </strong>-  "+$('#config_address').val()+"<br><strong>Line 2 </strong>- "+$('#config_address_line2').val()+"<br><strong>City </strong>- "+$('#config_city').val()+"<br><strong>Postal Code </strong>-  "+$('#config_postal_code').val()+"<br><strong>Region </strong>- "+$('#input-zone option:selected').text()+"<br><strong>Country </strong>- "+$('#input-country option:selected').text()+"</div>";

									jQuery_1_8_16("<div></div>").html(invalidStoreAddress+"<br>"+json.msg).dialog({
										title: "<img src='view/image/Ava-logo.jpg'> AvaTax Address Validation",
										resizable: true,
										modal: true,
										buttons: {
												"OK": function()
											{
												jQuery_1_8_16( this ).dialog( "close" );
											}
										}
									});
								}
							}
						});
					});

					//Added for Onboarding API & Free Trial
					function avatax_get_started_account()	{
						$("#tab-avalara-existing-user").show();
						$("#tab-avalara-new-user").hide();
						$("#config_avatax_main_screen").hide();
						$("#tab-avalara-new-user-credentials").hide();
						$("#config_avatax_account").val($("#avalara_new_account_id").val());
						$("#config_avatax_license_key").val($("#avalara_new_license_key").val());
					}

					$('#submit-new-account-button').click(function() {
						var errorFlag = 0;

						var validation = {
						isEmailAddress:function(str) {
						   var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
						   return pattern.test($("#"+str+"").val());
						   // returns a boolean
						},
						isNotEmpty:function (str) {
						   var pattern =/\S+/;
						   return pattern.test($("#"+str+"").val());
						   // returns a boolean
						},
						isNumber:function(str) {
							var pattern = /^\d+$/;
							return pattern.test($("#"+str+"").val());
							// returns a boolean
						},
						isName:function(str) {
							var pattern = /^[A-Za-z ]+$/;
							return pattern.test($("#"+str+"").val());
							// returns a boolean
						},
						addError:function(str) {
							$("#"+str+"").parent().parent().addClass("has-error");
							$("#"+str+"_error").addClass("text-danger");
						},
						removeError:function(str) {
							$("#"+str+"").parent().parent().removeClass("has-error");
							$("#"+str+"_error").removeClass("text-danger");
							$("#"+str+"_error").text("");
						},
						isSame:function(str1,str2){
						  return str1 === str2;
						}};

						if(!validation.isNotEmpty("config_avatax_newaccount_company"))	{
							validation.addError("config_avatax_newaccount_company");
							$("#config_avatax_newaccount_company_error").text("Please enter your Company Name");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_company");
						}
						
						if(!validation.isNotEmpty("config_avatax_newaccount_tin"))	{
							validation.addError("config_avatax_newaccount_tin");
							$("#config_avatax_newaccount_tin_error").text("Please enter your TIN Number");
							errorFlag = 1;
						}
						else if(!validation.isNumber("config_avatax_newaccount_tin"))	{
							validation.addError("config_avatax_newaccount_tin");
							$("#config_avatax_newaccount_tin_error").text("Please enter numbers only in TIN");
							errorFlag = 1;
						}
						else if($('#config_avatax_newaccount_tin').val().length!=9)	{
							validation.addError("config_avatax_newaccount_tin");
							$("#config_avatax_newaccount_tin_error").text("TIN length should be of 9 characters.");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_tin");
						}

						if(!validation.isNotEmpty("config_avatax_newaccount_address_line1"))	{
							validation.addError("config_avatax_newaccount_address_line1");
							$("#config_avatax_newaccount_address_line1_error").text("Please enter your Address details");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_address_line1");
						}

						if(!validation.isNotEmpty("config_avatax_newaccount_address_city"))	{
							validation.addError("config_avatax_newaccount_address_city");
							$("#config_avatax_newaccount_address_city_error").text("Please enter your City");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_address_city");
						}

						if($('#config_avatax_newaccount_address_country option:selected').text()=="")	{
							validation.addError("config_avatax_newaccount_address_country");
							$("#config_avatax_newaccount_address_country_error").text("Please enter your Country");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_address_country");
						}

						if($('#config_avatax_newaccount_address_state option:selected').text()==" --- Please Select --- ")	{
							validation.addError("config_avatax_newaccount_address_state");
							$("#config_avatax_newaccount_address_state_error").text("Please enter your State");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_address_state");
						}

						if(!validation.isNotEmpty("config_avatax_newaccount_address_zip"))	{
							validation.addError("config_avatax_newaccount_address_zip");
							$("#config_avatax_newaccount_address_zip_error").text("Please enter your Zip Code");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_address_zip");
						}

						if(!validation.isNotEmpty("config_avatax_newaccount_contact_firstname"))	{
							validation.addError("config_avatax_newaccount_contact_firstname");
							$("#config_avatax_newaccount_contact_firstname_error").text("Please enter your First Name");
							errorFlag = 1;
						}
						else if(!validation.isName("config_avatax_newaccount_contact_firstname"))	{
							validation.addError("config_avatax_newaccount_contact_firstname");
							$("#config_avatax_newaccount_contact_firstname_error").text("Please enter characters only in First Name");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_contact_firstname");
						}

						if(!validation.isNotEmpty("config_avatax_newaccount_contact_lastname"))	{
							validation.addError("config_avatax_newaccount_contact_lastname");
							$("#config_avatax_newaccount_contact_lastname_error").text("Please enter your Last Name");
							errorFlag = 1;
						}
						else if(!validation.isName("config_avatax_newaccount_contact_lastname"))	{
							validation.addError("config_avatax_newaccount_contact_lastname");
							$("#config_avatax_newaccount_contact_lastname_error").text("Please enter characters only in Last Name");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_contact_lastname");
						}

						if(!validation.isNotEmpty("config_avatax_newaccount_contact_email"))	{
							validation.addError("config_avatax_newaccount_contact_email");
							$("#config_avatax_newaccount_contact_email_error").text("Please enter your Email Address");
							errorFlag = 1;
						}
						else if(!validation.isEmailAddress("config_avatax_newaccount_contact_email"))	{
							validation.addError("config_avatax_newaccount_contact_email");
							$("#config_avatax_newaccount_contact_email_error").text("Please enter proper Email Address");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_contact_email");
						}

						if(!validation.isNotEmpty("config_avatax_newaccount_contact_phone"))	{
							validation.addError("config_avatax_newaccount_contact_phone");
							$("#config_avatax_newaccount_contact_phone_error").text("Please enter your Phone Number");
							errorFlag = 1;
						}
						else	{
							validation.removeError("config_avatax_newaccount_contact_phone");
						}

						if (errorFlag == 1) {
							$("#avatax-account-error").show();
							$("#avatax-account-error").html("<strong>Please Fill Required Fields!!!</strong>");
						} else {
							//alert("information is correct");
							//return false;
							$.ajax({
								url: '../system/AvaTax4PHP/avatax_create_account.php',
								type: 'post',
								data:'company='+$('#config_avatax_newaccount_company').val()+'&line1='+$('#config_avatax_newaccount_address_line1').val()+'&line2='+$('#config_avatax_newaccount_address_line2').val()+'&line3='+$('#config_avatax_newaccount_address_line3').val()+'&city='+$('#config_avatax_newaccount_address_city').val()+'&state='+$('#config_avatax_newaccount_address_state option:selected').text()+'&country='+$('#config_avatax_newaccount_address_country option:selected').text()+'&zip='+$('#config_avatax_newaccount_address_zip').val()+'&contact_title='+$('#config_avatax_newaccount_contact_title').val()+'&firstname='+$('#config_avatax_newaccount_contact_firstname').val()+'&lastname='+$('#config_avatax_newaccount_contact_lastname').val()+'&email='+$('#config_avatax_newaccount_contact_email').val()+'&phone='+$('#config_avatax_newaccount_contact_phone').val()+'&mobile='+$('#config_avatax_newaccount_contact_mobile').val()+'&fax='+$('#config_avatax_newaccount_contact_fax').val()+'&tin='+$('#config_avatax_newaccount_tin').val()+'&bin='+$('#config_avatax_newaccount_bin').val(),
								beforeSend: function() {
									$('#submit-new-account-button').button('loading');
								},
								complete: function() {
									//alert('complete');
									$('#submit-new-account-button').button('reset');
								},
								success:function(data)	{
									var json = JSON.parse(data);
									//alert(json['Status']);
									if(json['Status']=='Success')
									{
										var jsonMessage = json['Message'].slice(0,-1);
										var avataxArr = jsonMessage.split('\u000a\u000d');
										var jsonResult = json['Result'];
										var accountID = jsonResult['AccountId'];
										var licenseKey = jsonResult['LicenseKey'];

										$("#avalara_new_account_id").val(accountID);
										$("#avalara_new_license_key").val(licenseKey);
										//alert(accountID+' - '+licenseKey);
										//alert('in success');
										$("#tab-avalara-new-user").hide();
										$("#tab-avalara-new-user-credentials").show();

										//$("#tab-avalara-new-user-credentials").html("<strong>"+json['Result']+" - "+json['Message']+"!!!</strong>");
										
										$("#avalara-new-user-account-status").show().append("<ul>");
										$.each( avataxArr, function( key, value ) {
											$("#avalara-new-user-account-status").append("<li class='everything something' style='margin-left: 2em;'><strong>"+value+"</strong></li>");
										});

										var timeOuts = new Array();
											var eT=800;
											function myFadeIn(jqObj) {
												jqObj.fadeIn('slow');
											}
											function clearAllTimeouts() {
												for (key in timeOuts) {
													clearTimeout(timeOuts[key]);
												}
											}
											$('.everything').hide().each(function(index) {
												timeOuts[index] = setTimeout(myFadeIn, index*eT, $(this));
											});
											clearAllTimeouts();
											$('.everything').stop(true,true).hide();
											$('.something').each(function(index) {
											timeOuts[index] = setTimeout(myFadeIn, index*eT, $(this));
										});
										$("#avalara-new-user-account-status").append("</ul><p>&nbsp;</p>");
										
										setTimeout(function(){
											$("#avalara-new-user-account-credentials").show().append("<p>Here are your login credentials for Avalara Account,</p>");
											$("#avalara-new-user-account-credentials").append("<p><strong>Account ID: </strong>"+jsonResult['AccountId']+"<br><strong>License Key: </strong>"+jsonResult['LicenseKey']+"</p><p><strong>User ID: </strong>"+jsonResult['User']['UserName']+"<br><strong>Temporary Password: </strong>"+jsonResult['User']['TempPwd']+"</p>");

											$("#avalara-new-user-account-credentials").append("<p>&nbsp;</p><p>AvaTax Customer Portal URL: <a href='https://avatax.avalara.net'>https://avatax.avalara.net</a></p>");

											$("#avalara-new-user-account-credentials").append("<p><strong>Please Note: </strong>Updates to your Admin Console password and profile can be made from Settings > Manage my Information. Upon logging into the Admin Console, you will be prompted to change your temporary password</p><p>&nbsp;</p><p>Best Regards,<br>Avalara Customer Care Team<br>Email:<a href='mailto:support@avalara.com'>support@avalara.com</a><br>Phone: 1-877-780-4848<br></p><p>By clicking get started you are indicating you have read and agree to our tems of services.</p>");
											
											$("#avalara-new-user-account-credentials").append("<p><input type='button' id='button_avatax_page' data-loading-text='Loading...' onClick='javascript:avatax_get_started_account();' class='btn btn-primary' value='Get Started'></input></p></fieldset>");
										}, 4000);
									}
									else
									{
										//alert('in Error');
										$("#avatax-account-error").show();
										$("#avatax-account-error").html("<strong>"+json['Result']+" - "+json['Message']+"!!!</strong>");
									}
								}
							});
						}
					});

					$('#config_avatax_tax_calculation_yes').click(function() {
							$('#config_avatax_account-error').hide().removeClass("text-danger");
							$('#config_avatax_license_key-error').hide().removeClass("text-danger");
							$('#config_avatax_service_url-error').hide().removeClass("text-danger");
							$('#config_avatax_company_code-error').hide().removeClass("text-danger");

						if($("#config_avatax_account").val()=="") {
								$('#config_avatax_account-error').show().addClass("text-danger");
							$("#config_avatax_tax_calculation_no").prop("checked", true);
							$("#config_avatax_account").focus();
						}
						else if($("#config_avatax_license_key").val()=="") {
								$('#config_avatax_license_key-error').show().addClass("text-danger");
							$("#config_avatax_tax_calculation_no").prop("checked", true);
							$("#config_avatax_license_key").focus();
						}
						else if($("#config_avatax_service_url").val()=="") {
								$('#config_avatax_service_url-error').show().addClass("text-danger");
							$("#config_avatax_tax_calculation_no").prop("checked", true);
							$("#config_avatax_service_url").focus();
						}
						else if($("#config_avatax_company_code").val()=="") {
								$('#config_avatax_company_code-error').show().addClass("text-danger");
							$("#config_avatax_tax_calculation_no").prop("checked", true);
							$("#config_avatax_company_code").focus();
						}
						if(($("#config_address").val()=="") || ($("#config_city").val()=="") ||($("#config_country_id").val()=="") ||($("#config_zone_id").val()=="") ||($("#config_postal_code").val()==""))
						{
							alert("Store Address Line 1, City, Country, Region and Postal Code are required!\n\n Without these values we are not enable the AvaTax Tax Calculation.\n\n So, Please make sure above mentioned fields are filled on the General Tab section.");
							//$('#EnableAvaTaxValidation').html('Store Address Line 1, City, Country, Region and Postal Code are required!<br/> Without these values we are not enable the AvaTax Tax Calculation.<br/> So, Please make sure above mentioned fields are filled on the General Tab section.');
							//$('#EnableAvaTaxValidation').dialog();
							$("#config_avatax_tax_calculation_no").prop("checked", true);
						}
					});

					function closeTestConnection()
					{
						jQuery_1_8_16('#AvaTaxTestConnectionDialog').dialog('close');
					}

						//To remove all Company code drop down values when user makes any changes in Account ID, License Key or Service URL
						$('#config_avatax_account').on('input', function() {
							$('#config_avatax_company_code').empty();
							$("#config_avatax_company_code_value_array").val("-Select One");
							$("#config_avatax_company_code").append('<option value="" selected>Select One</option>');
						});

						$('#config_avatax_license_key').on('input', function() {
							$('#config_avatax_company_code').empty();
							$("#config_avatax_company_code_value_array").val("-Select One");
							$("#config_avatax_company_code").append('<option value="" selected>Select One</option>');
						});

						$('#config_avatax_service_url').on('change', function() {
							$('#config_avatax_company_code').empty();
							$("#config_avatax_company_code_value_array").val("-Select One");
							$("#config_avatax_company_code").append('<option value="" selected>Select One</option>');
						});

					$('#AvaTaxTestConnection').click(function() {
							$('#config_avatax_account-error').hide().removeClass("text-danger");
							$('#config_avatax_license_key-error').hide().removeClass("text-danger");
							$('#config_avatax_service_url-error').hide().removeClass("text-danger");

						if($("#config_avatax_account").val()=="") {
								$('#config_avatax_account-error').show().addClass("text-danger");
							$("#config_avatax_account").focus();
						}
						else if($("#config_avatax_license_key").val()=="") {
								$('#config_avatax_license_key-error').show().addClass("text-danger");
							$("#config_avatax_license_key").focus();
						}
						else if($("#config_avatax_service_url").val()=="") {
								$('#config_avatax_service_url-error').show().addClass("text-danger");
							$("#config_avatax_service_url").focus();
						}
						else
						{
							jQuery_1_8_16('#AvaTaxTestConnectionDialog').html('<div style="text-align:center;padding-top:10px;"><img src="view/image/loading2.gif" border="0" alt="Work In Progress..." ><br/>Work In Progress...</div>');

							jQuery_1_8_16('#AvaTaxTestConnectionDialog').dialog();

							var accountVal = $("#config_avatax_account").val();
							var licenseVal = $("#config_avatax_license_key").val();
							var serviceURLVal = $("#config_avatax_service_url").val();
							var environment = "Development";
							var client = '<?="OpenCart ".VERSION."||02.00.02.00";?>';
							var log = $('input[name=config_avatax_log]:checked').val();

							if($("#config_avatax_service_url").val()=="https://development.avalara.net")
								environment = "Development";
							else
								environment = "Production";

							/****************************************************************************************************
							*   Last Updated On	:	07/27/2015			                            							*
							* 	 Ticket - https://avalara.atlassian.net/browse/CONNECT-2717
							*   Description        :   Removed service URL to be passed from query string. When we pass URL with https, customer is not able to get success/fail message in test connection dialog box.
							*****************************************************************************************************/

							/**/$.post("<?php if ($config_secure) {echo str_replace("admin/","system/AvaTax4PHP/", HTTPS_SERVER);} else {echo str_replace("admin/","system/AvaTax4PHP/", HTTP_SERVER);}?>avatax_test_connection.php?from=AvaTaxConnectionTest&acc="+accountVal+"&license="+licenseVal+"&environment="+ environment+"&client="+ client, {q: ""}, function(data){

							$("#config_avatax_company_code").empty();
									//$("#config_avatax_company_code").append('<option value="" selected>Select One</option>');
									
								if(data.length >0) {
									jQuery_1_8_16('#AvaTaxTestConnectionDialog').html(data);

									if(data.indexOf("Success")>0)
									{
										$('#config_avatax_company_code_div').show();

										/**/$.post("<?php if ($config_secure) {echo str_replace("admin/","system/AvaTax4PHP/", HTTPS_SERVER);} else {echo str_replace("admin/","system/AvaTax4PHP/", HTTP_SERVER);}?>avatax_accounts.php?from=AvaTaxFetchCompanies&acc="+accountVal+"&license="+licenseVal+"&environment="+ environment+"&log="+ log+"&client="+ client, {q: ""}, function(data){
											if(data.length >0) {
												var accountsData = JSON.parse(data);
												var _select = $('<select>');
													var companyArray = "-Select One";
													_select.append('<option value="">Select One</option>');
												$.each(accountsData, function(index, value) {
													_select.append(
															$('<option></option>').val(index).html(value)
														);
														companyArray = companyArray+","+index+"-"+value;
												});

												$('#config_avatax_company_code').append(_select.html());
												var company_code = document.getElementById("config_avatax_company_code_value").value;
												$("#config_avatax_company_code").val(company_code);
												$("#config_avatax_company_code_value_array").val(companyArray);
													$("#config_avatax_company_code").val("");
											}
										});
									}
									else
									{
											$("#config_avatax_company_code_value_array").val("-Select One");
											$("#config_avatax_company_code").append('<option value="" selected>Select One</option>');

											$('#config_avatax_account-error').show().addClass("text-danger");
											$('#config_avatax_license_key-error').show().addClass("text-danger");
									}
								}
							});

						}
					});
				//--></script>
				
<?php echo $footer; ?>