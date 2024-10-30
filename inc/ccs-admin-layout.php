<div class="wrap">
    <div id="icon-options-general" class="icon32"></div>
    <h1>
        <?php esc_html_e($this->name, 'cc-status-plugin'); ?>
    </h1>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox ccs-container">
                        <h2><span>
                                <i class="genericond genericon genericon-cog"></i>
                                <?php esc_html_e('Settings', 'cc-status-plugin'); ?>
                            </span>
                        </h2>
                        <div class="inside">
                            <form method="post" action="options.php">
                                <?php settings_fields($this->section); ?>
                                <p><strong>Add <code>[current-currency-status]</code> shortcode for use.</strong></p>
                                <table class="form-table ccs-table">
                                    <tr valign="top">
                                        <td scope="row">
                                            <label for="tablecell">
                                                <?php esc_html_e('Add openexchangerates App IDs', 'cc-status-plugin'); ?>
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text" value="<?php esc_attr_e(get_option('ccStatus_apikey')); ?>" name="ccStatus_apikey" class="regular-text" /><br>
                                        </td>
                                    </tr>                
                                </table>
                                <?php submit_button(); ?>
                                <input class="button-secondary" id="ccgetcurrency" type="button" value="<?php esc_attr_e('Currency'); ?>" />
                            </form>
                            <br class="clear" />
                        </div>
                        <!-- .inside -->
                    </div>
                    <!-- .postbox -->
                </div>
                <!-- .meta-box-sortables .ui-sortable -->
            </div>
            <!-- post-body-content -->

            <!-- sidebar -->
            <div id="postbox-container-1" class="postbox-container">
                <div class="meta-box-sortables">
                    <div class="postbox">
                        <h2><span>
                                <?php
                                esc_html_e(
                                        'Open Exchange Rates Help', 'cc-status-plugin'
                                );
                                ?>
                            </span>
                        </h2>
                        <div class="inside">
                            <p>
                                <?php
                                esc_html_e(
                                        'Use Open Exchange Rates to get all current curency status. You can use premiume account or free account to use Current Currency Status.', 'cc-status-plugin'
                                );
                                ?>
                            </p>
                            <p>
                                <?php
                                esc_html_e(
                                        'Open Exchange Rates give 1,000 requests/month. in free account', 'cc-status-plugin'
                                );
                                ?>
                            </p>
                            <a href="https://openexchangerates.org/signup/free" target="_blank"><?php esc_html_e('Signup for free', 'cc-status-plugin'); ?></a>
                            <br class="clear">
                            <a href="https://openexchangerates.org/signup" target="_blank"><?php esc_html_e('Pricing', 'cc-status-plugin'); ?></a>
                            <br class="clear">
                            <a href="https://openexchangerates.org/login" target="_blank"><?php esc_html_e('Login to account', 'cc-status-plugin'); ?></a>
                            <br class="clear">
                            <a href="https://openexchangerates.org/account/app-ids" target="_blank"><?php esc_html_e('Your API Key', 'cc-status-plugin'); ?></a>
                            <br class="clear">
                            <a href="https://openexchangerates.org/account/usage" target="_blank"><?php esc_html_e('Account Usage', 'cc-status-plugin'); ?></a>
                        </div>
                        <!-- .inside -->
                    </div>
                    <!-- .postbox -->
                </div>
                <!-- .meta-box-sortables -->
            </div>
            <!-- #postbox-container-1 .postbox-container -->
        </div>
        <!-- #post-body .metabox-holder .columns-2 -->
        <br class="clear">
    </div>
    <!-- #poststuff -->
</div> <!-- .wrap -->