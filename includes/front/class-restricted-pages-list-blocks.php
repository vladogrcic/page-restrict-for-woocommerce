<?php
/**
 * Showing a list of pages that the current user purchased products for in order to access them.
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Front
 */
namespace PageRestrictForWooCommerce\Includes\Front;
use PageRestrictForWooCommerce\Includes\Common\Helpers;
use PageRestrictForWooCommerce\Includes\Common\User_Restrict_Data;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
/**
 * Showing a list of pages that the current user purchased products for in order to access them.
 *
 * @package    PageRestrictForWooCommerce\Includes\Front
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Restricted_Pages_List_Blocks
{
    /**
     * @since    1.1.0
     * @access   public
     * @var      class      $helpers    Initialize Helpers class.
     */
    public $helpers;
    /**
     * @since    1.1.0
     * @access   public
     * @var      int      $user_id    Current user id.
     */
    public $user_id;
    /**
     * @since    1.1.0
     * @access   public
     * @var      array      $restrict_data    Get user restrict data.
     */
    public $restrict_data;
    /**
     * @since    1.1.0
     * @access   public
     * @var      string      $date_format    Default WordPress date format.
     */
    public $date_format;
    /**
     * @since    1.1.0
     * @access   public
     * @var      string      $time_format    Default WordPress time format.
     */
    public $time_format;
    /**
     * @since    1.1.0
     * @access   public
     * @var      class      $page_options_class    Page options class.
     */
    public $page_options_class;
    /**
     * @since    1.1.0
     * @access   public
     * @var      bool      $disable_table_class    List of possible metabox page options.
     */
    public $disable_table_class;

    /**
	 * Initialize class instances and other variables.
     * 
	 * @since    1.1.0
	 */

    public $user_restrict_data;
    public function __construct()
    {
        $this->helpers = new Helpers();
        $this->user_restrict_data = new User_Restrict_Data();
        $this->page_options_class = new Page_Plugin_Options();
        $this->user_id = get_current_user_id();
        $this->date_format = get_option('date_format');
        $this->time_format = get_option('time_format');

        $this->restrict_data = $this->user_restrict_data->return_data(true, $this->user_id);
        $this->disable_table_class = $this->page_options_class->get_general_options('prwc_my_account_rp_page_disable_plugin_designed_table');
    }
    /**
     * The users list of restricted pages they bought products for in order to access. 
     * Choose which table to show.
     *
     * @since      1.1.0
     * @param      array     $attr       Attributes passed for processing.
     * @return     string
     */
    public function process_restricted_pages_list( array $attr )
    {
        if(!is_user_logged_in()){
            return;
        }
        $print = '';
        if(!$attr['disable_table_class']){
            $disable_table_class = $this->disable_table_class;
        }
        else{
            $disable_table_class = $attr['disable_table_class'];
        }
        if($attr['time']){
            $print = $this->process_restricted_pages_list_time( $disable_table_class );
        }
        if($attr['view']){
            $print = $this->process_restricted_pages_list_view( $disable_table_class );
        }
        return $print;
    }
    /**
     * The users list of restricted pages they bought products for in order to access. 
     * Shows time as expiration timeout.
     *
     * @since      1.1.0
     * @param      bool     $disable_table_class       Remove table classes.
     * @return     string
     */
    public function process_restricted_pages_list_time( $disable_table_class=false )
    {
        $helpers = $this->helpers;
        $user_id = $this->user_id;
        $date_format = $this->date_format;
        $time_format = $this->time_format;
        $restrict_data = $this->restrict_data;
        if(!$disable_table_class){
            $disable_table_class = $this->disable_table_class;
        }
        ob_start();
        ?>
        <table <?php if(!(int)$disable_table_class){ ?>class="timeout_table time"<?php } ?>>
            <tr>
                <th><?php echo esc_html_e( 'Page', 'page_restrict_domain' ); ?></th>
                <th><?php echo esc_html_e( 'Time until Expiration', 'page_restrict_domain' ); ?></th>
                <th><?php echo esc_html_e( 'Date and Time of Expiration', 'page_restrict_domain' ); ?></th>
            </tr>
            <?php
            if( $restrict_data['time_data'] ):
                foreach ($restrict_data['time_data'] as $page):
                    // if(!isset($page['time_compare'])){
                    //     continue;
                    // }
                    if(isset($page['time_compare']) && isset($page['time_elapsed'])){
                        $expiration = $page['time_compare'] - $page['time_elapsed'];
                    }
                    else {
                        $expiration = 0;
                    }
                    ?>
                    <tr>
                        <td><a href="<?php echo get_permalink($page['post']->ID); ?>"><?php echo $page['post']->post_title; ?></a></td>
                        <td><?php if(isset($page['time_compare']) && $page['time_compare']) echo $helpers->seconds_to_dhms($expiration); else echo esc_html_e( 'No Expiration', 'page_restrict_domain' ); ?></td>
                        <td><?php if(isset($page['time_compare']) && $page['time_compare']) echo date($date_format . " " . $time_format, $expiration + time()); else echo esc_html_e( 'No Expiration', 'page_restrict_domain' ); ?></td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
        </table>
        <?php
        return ob_get_clean();
    }
    /**
     * The users list of restricted pages they bought products for in order to access. 
     * Shows view as expiration timeout.
     *
     * @since      1.1.0
     * @param      bool     $disable_table_class       Remove table classes.
     * @return     string
     */
    public function process_restricted_pages_list_view( $disable_table_class=false )
    {
        $helpers = $this->helpers;
        $user_id = $this->user_id;
        $date_format = $this->date_format;
        $time_format = $this->time_format;
        $restrict_data = $this->restrict_data;
        if(!$disable_table_class){
            $disable_table_class = $this->disable_table_class;
        }
        ob_start();
        ?>
        <table <?php if(!(int)$disable_table_class){ ?>class="timeout_table view"<?php } ?>>
            <tr>
                <th><?php echo esc_html_e( 'Page', 'page_restrict_domain' ); ?></th>
                <th><?php echo esc_html_e( 'Views', 'page_restrict_domain' ); ?></th>
                <th><?php echo esc_html_e( 'Views Left', 'page_restrict_domain' ); ?></th>
                <th><?php echo esc_html_e( 'Views Total', 'page_restrict_domain' ); ?></th>
            </tr>
            <?php
            if( $restrict_data['view_data'] ):
                foreach ($restrict_data['view_data'] as $page_id => $page):
                    $expiration = abs((int)$page['view_expiration_num'] - (int)$page['views']);
                    ?>
                    <tr>
                        <td><a href="<?php echo get_permalink($page['post']->ID); ?>"><?php echo $page['post']->post_title; ?></a></td>
                        <td><?php echo $page['views']?$page['views']:0; ?></td>
                        <td><?php echo $expiration; ?></td>
                        <td><?php echo $page['view_expiration_num']; ?></td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
        </table>
        <?php
        return ob_get_clean();
    }
}