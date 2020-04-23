<?php
/**
 * Adding a page to the WooCommerce My Account page.
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/public/includes
 */

/**
 * Adding a page to the WooCommerce My Account page.
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/public/includes
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Page_Restrict_Wc_My_Account
{
    /**
     * @since    1.1.0
     * @access   public
     * @var      bool      $load_endpoints    Choose to load endpoints.
     */
    public $load_endpoints;
    /**
	 * Initialize class instances and other variables.
     * 
     * @param    bool     $load_endpoints    Should the endpoint load.
	 * @since    1.1.0
	 */
    public function __construct( $load_endpoints=true ){
        $this->load_endpoints = $load_endpoints;
        if($load_endpoints){
            add_action( 'init', array($this, 'add_my_account_endpoint') );
        }
    }
    /**
     * Adding page name to menu.
     *
     * @since      1.1.0
     * @param      array     $items       Menu data.
     * @return     array
     */
    public function account_menu_items( $items ) {
        if($this->load_endpoints){
            $items['restrict-pages-overview'] = __( 'Restricted Pages', 'page_restrict_domain' );
        }
        return $items;
    }
    /**
     * Adding page endpoint.
     *
     * @since      1.1.0
     * @return     void
     */
    public function add_my_account_endpoint() {
        if($this->load_endpoints){
            add_rewrite_endpoint( 'restrict-pages-overview', EP_PAGES );
        }
        else{
            flush_rewrite_rules();
        }
    }
    /**
     * Frontend for restrict page data for this specific user.
     *
     * @since      1.1.0
     * @param      bool     $hide_time                   Hide the time table.
     * @param      bool     $hide_view                   Hide the view table.
     * @param      bool     $disable_table_class         Remove table class.
     * @return     void
     */
    public function restrict_pages_overview_endpoint_content($hide_time=false, $hide_view=false, $disable_table_class=false) {
        $Restricted_Pages_List = new Page_Restrict_Wc_Restricted_Pages_List_Blocks();
        ?>
        <div class="restrict-pages-overview-wrapper">
            <h3 class="page-title"><?php echo esc_html_e( 'Restricted Pages List', 'page_restrict_domain' ); ?></h3>
            <div class="description">
                <p><?php echo esc_html_e( 'Lists restricted pages for which you have already bought products.', 'page_restrict_domain' ); ?></p>
            </div>
            <?php
            if( !$hide_time ):
            ?>
                <h4 class="timeout_title time"><?php echo esc_html_e( 'Time', 'page_restrict_domain' ); ?></h4>
            <?php
                echo $Restricted_Pages_List->process_restricted_pages_list_time( $disable_table_class );
            endif;
            // $restrict_data['view_data'] = [];
            if( !$hide_view ):
            ?>
                <h4 class="timeout_title view"><?php echo esc_html_e( 'View', 'page_restrict_domain' ); ?></h4>
            <?php
                echo $Restricted_Pages_List->process_restricted_pages_list_view( $disable_table_class );
            endif;
            ?>
        </div>
        <?php
    }
}
$page_options = new Page_Restrict_Wc_Page_Plugin_Options();
$prwc_my_account_rp_page_disable_endpoint = $page_options->get_general_options('prwc_my_account_rp_page_disable_endpoint');
new Page_Restrict_Wc_My_Account( !$prwc_my_account_rp_page_disable_endpoint );