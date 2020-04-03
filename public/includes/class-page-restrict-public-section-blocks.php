<?php
/**
 * Processing content for entire entire pages or section in order to restrict access according to views, time or any other way.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 */

/**
 * Processing content for entire entire pages or section in order to restrict access according to views, time or any other way.
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Page_Restrict_Wc_Section_Blocks
{
    /**
     * Page_Restrict_Wc_Products_Bought class instance.
     *
     * @since    1.0.0
     * @access   protected
     * @var      class    $products_bought    The current version of the plugin.
     */
    protected $products_bought;
    /**
     * Page_Restrict_Wc_Restrict_Types class instance.
     *
     * @since    1.0.0
     * @access   protected
     * @var      class      $restrict    The current version of the plugin.
     */
    protected $restrict;
    /**
     * User ID.
     *
     * @since    1.0.0
     * @access   public
     * @var      int      $user_id    User ID.
     */
    public $user_id;
    /**
     * Post ID.
     *
     * @since    1.0.0
     * @access   public
     * @var      int      $post_id    Post ID.
     */
    public $post_id;
    /**
     * Page_Restrict_Wc_Page_Plugin_Options class instance.
     *
     * @since    1.0.0
     * @access   public
     * @var      class      $page_options    Get page options from the database like the products that the page is limited with and the time till timeout.
     */
    public $page_options;
    /**
     * Array of products.
     *
     * @since    1.0.0
     * @access   public
     * @var      array      $products    Products which restrict the page.
     */
    public $products;
    /**
     * General option if there isn't one set per page which is used to show if product wasnt bought or was bought but it expired.
     *
     * @since    1.0.0
     * @access   public
     * @var      int      $general_not_bought_page    A general option ID of the page which is used to show if product wasn't bought or was bought but it expired.
     */
    public $general_not_bought_page;
    /**
     * General option if there isn't one set per page if the user isn't logged in.
     *
     * @since    1.0.0
     * @access   public
     * @var      int      $general_login_page    A general option ID of the page which is used to show if the user isn't logged in.
     */
    public $general_login_page;
    /**
     * ID of the page used to show if product wasnt bought or was bought but it expired.
     *
     * @since    1.0.0
     * @access   public
     * @var      int      $not_bought    ID of the page used to show if product wasn't bought or was bought but it expired.
     */
    public $not_bought;
    /**
     * ID of the page used to show if product wasn't bought or was bought but it expired.
     *
     * @since    1.0.0
     * @access   public
     * @var      int      $not_logged_in    ID of the page used to show if product wasn't bought or was bought but it expired.
     */
    public $not_logged_in;
    /**
     * General option if one isn't set per page used to choose whether to redirect or show the page into the content of the chosen page ID before if the user didn't buy the product or it expired.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool      $redirect_general_not_bought    General option if one isn't set per page used to choose whether to redirect or show the page into the content of the chosen page ID before if the user didn't buy the product or it expired.
     */
    public $redirect_general_not_bought;
    /**
     * General option if one isn't set per page used to choose whether to redirect or show the page into the content of the chosen page ID before if the user isn't logged in.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool      $redirect_general_login    General option if one isn't set per page used to choose whether to redirect or show the page into the content of the chosen page ID before if the user isn't logged in.
     */
    public $redirect_general_login;    
    /**
     * Number of days until restriction timeout.
     * 
     * @since    1.0.0
     * @access   public
     * @var      int      $days    Number of days until restriction timeout.
     */
    public $days;
    /**
     * Number of hours until restriction timeout.
     * 
     * @since    1.0.0
     * @access   public
     * @var      int      $hours    Number of hours until restriction timeout.
     */
    public $hours;
    /**
     * Number of minutes until restriction timeout.
     * 
     * @since    1.0.0
     * @access   public
     * @var      int      $minutes    Number of minutes until restriction timeout.
     */
    public $minutes;
    /**
     * Number of seconds until restriction timeout.
     * 
     * @since    1.0.0
     * @access   public
     * @var      int      $seconds    Number of seconds until restriction timeout.
     */
    public $seconds;
    /**
     * Number of views until restriction timeout.
     * 
     * @since    1.0.0
     * @access   public
     * @var      int      $views    Number of views until restriction timeout.
     */
    public $views;

    /**
	 * Initialize class instances and other variables.
	 *
	 * @since    1.0.0
	 */
    public function __construct()
    {
		$this->user_id = get_current_user_id();
		$this->post_id = get_the_ID();
        $this->restrict         = new Page_Restrict_Wc_Restrict_Types();
        $this->products_bought  = new Page_Restrict_Wc_Products_Bought();
        $this->page_options     = new Page_Restrict_Wc_Page_Plugin_Options();
    
        $this->products     =   $this->page_options->get_page_options($this->post_id, 'prwc_products');
        $this->days         =   $this->page_options->get_page_options($this->post_id, 'prwc_timeout_days');
        $this->hours        =   $this->page_options->get_page_options($this->post_id, 'prwc_timeout_hours');
        $this->minutes      =   $this->page_options->get_page_options($this->post_id, 'prwc_timeout_minutes');
        $this->seconds      =   $this->page_options->get_page_options($this->post_id, 'prwc_timeout_seconds');
        $this->views        =   $this->page_options->get_page_options($this->post_id, 'prwc_timeout_views');

        $this->not_bought               = $this->page_options->get_page_options($this->post_id, 'prwc_not_bought_page');
        $this->redirect_not_bought      = $this->page_options->get_page_options($this->post_id, 'prwc_redirect_not_bought');
        $this->not_logged_in            = $this->page_options->get_page_options($this->post_id, 'prwc_not_logged_in_page');
        $this->redirect_not_logged_in   = $this->page_options->get_page_options($this->post_id, 'prwc_redirect_not_logged_in');

        $this->general_not_bought_page          = $this->page_options->get_general_options('prwc_general_not_bought_page');
        $this->general_login_page               = $this->page_options->get_general_options('prwc_general_login_page');
        $this->redirect_general_not_bought      = $this->page_options->get_general_options('prwc_general_redirect_not_bought');
        $this->redirect_general_login           = $this->page_options->get_general_options('prwc_general_redirect_login');
    }
    /**
     * Processing content for specific blocks like gutengerg blocks and shortcodes for frontend display.
     *
     * @since      1.0.0
     * @param      array     $atts       Attributes passed for processing.
     * @param      string    $content    Page content passed.
     * @return     string
     */
    public function process_section(array $atts, string $content)
    {
        $a = shortcode_atts(array(
            'products' => false,
            'days' => 0,
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'views' => false,
            'redirect' => false,
            'inverse' => false,
            'defRestrictMessage' => false,
        ), $atts);
        
        $overflow_error = false;
        $post_id = get_the_ID();
        $user_id = get_current_user_id();
        $inverse = (int)$a['inverse'];
        if (strlen(trim($inverse)) > 1) {
            trigger_error('Warning: Inverse attribute reached character limit.');
        }
        if(is_array($a['products'])){
            $products       = array_map('sanitize_text_field', $a['products']);
        }        
        else{
            $products       = array_map('sanitize_text_field', explode(',', $a['products']));
        }
        if (array_sum(array_map('strlen', $products)) > 20*count($products)) {
            trigger_error('Warning: Lock by Products attribute reached character limit.');
        }
        $views          = (int)sanitize_key($a['views']);        
        if (strlen(trim($views)) > 20) {
            trigger_error('Warning: Views attribute reached character limit.');
        }
        $days           = (int)sanitize_key($a['days']);
        if (strlen(trim($days)) > 20) {
            trigger_error('Warning: Days attribute reached character limit.');
        }
        $hours          = (int)sanitize_key($a['hours']);
        if (strlen(trim($hours)) > 20) {
            trigger_error('Warning: Hours attribute reached character limit.');
        }
        $minutes        = (int)sanitize_key($a['minutes']);
        if (strlen(trim($minutes)) > 20) {
            trigger_error('Warning: Minutes attribute reached character limit.');
        }
        $seconds        = (int)sanitize_key($a['seconds']);
        if (strlen(trim($seconds)) > 20) {
            trigger_error('Warning: Seconds attribute reached character limit.');
        }
        $show_products_needed = (int)sanitize_key($a['defRestrictMessage']);
        if (strlen(trim($show_products_needed)) > 1) {
            trigger_error('Warning: Default Restrict Message attribute reached character limit.');
        }
        $timeout_sec    = 0;
        
        if (gettype($products) == "string") {
            $products_arr = array_map(function ($item) {
                return (int)trim($item);
            }, explode(",", $products));
        } elseif (gettype($products) == "array") {
            $products_arr = $products;
        }
        if(!$products){
            return do_shortcode($content);
        }
        if (is_user_logged_in()) {
            $timeout_sec = $seconds+($minutes*60)+($hours*3600)+($days*86400);
            $purchased_products = $this->products_bought->get_purchased_products_by_ids(
                $user_id,
                $products_arr
            );
            $check_final = $this->restrict->check_final_all_types(
                $user_id,
                $post_id,
                $purchased_products,
                $products_arr,
                $views,
                $timeout_sec
            );
            if ($inverse) {
                $check_final = !$check_final;
            }
            if($check_final){
                return do_shortcode($content);
            } 
            else {
                if($show_products_needed){
                    $product_urls = "";
                    $prod_count = count($products);
                    for ($i=0; $i < $prod_count; $i++) { 
                        $product = wc_get_product($products[$i]);
                        $url = get_permalink( $products[$i] );
                        if(count($products)-1===$i){
                            $multi_sep = '';
                        }
                        else{
                            $multi_sep = ', ';
                        }
                        $product_urls .= "<a href='$url'>".$product->get_title()."</a>".$multi_sep;
                    }
                    return '<p class="restrict-message"><span>'.esc_html__("Your access to this page expired or you haven't bought products needed to access this page. Buy", 'page_restrict_domain')." $product_urls ".esc_html__('in order to access this section!', 'page_restrict_domain').'</span></p>';
                }
                else{
                    return;
                }
            }
        }
        else{
            return;
        }
    }
    /**
     * Processing content for the entire page for frontend display.
     *
     * @since      1.0.0
     * @param      string    $content    Page content passed.
     * @return     string
     */
    public function process_page(string $content)
    {
        global $post;
        if (!isset($post)) {
            return do_shortcode($content);
        }
        $user_id = $this->user_id;
        $post_id = $this->post_id;

        $general_not_bought_page     = $this->general_not_bought_page;
        $general_login_page          = $this->general_login_page;
        $not_bought                  = $this->not_bought;
        $not_logged_in               = $this->not_logged_in;

        $products   = $this->products;
        $days       = $this->days;
        $hours      = $this->hours;
        $minutes    = $this->minutes;
        $seconds    = $this->seconds;
        $views      = $this->views;
        if(
            $post_id === $not_bought ||
            $post_id === $not_logged_in ||
            $post_id === $general_not_bought_page ||
            $post_id === $general_login_page
        ){
            return do_shortcode($content);
        }
        if(!$products){
            return do_shortcode($content);
        }
        if (is_user_logged_in()){
            if (gettype($products) == "string") {
                $products_arr = array_map(function ($item) {
                    return (int)trim($item);
                }, explode(",", $products));
            } elseif (gettype($products) == "array") {
                $products_arr = $products;
            }
            $timeout_sec = abs($seconds+($minutes*60)+($hours*3600)+($days*86400));
            $purchased_products = $this->products_bought->get_purchased_products_by_ids(
                $user_id,
                $products_arr
            );
            $check_final = $this->restrict->check_final_all_types(
                $user_id,
                $post_id,
                $purchased_products,
                $products_arr,
                $views,
                $timeout_sec
            );
            if($check_final){
                return do_shortcode($content);
            }
            else{
                if($not_bought){
                    return do_shortcode(get_post_field('post_content', $not_bought));
                }else{
                    // * If there is no bought page on the page being restricted.
                    if($general_not_bought_page){
                        return do_shortcode(get_post_field('post_content', $general_not_bought_page));
                    }
                    else{
                        $product_urls = "";
                        $prod_count = count($products);
                        for ($i=0; $i < $prod_count; $i++) { 
                            $product = wc_get_product($products[$i]);
                            $url = get_permalink( $products[$i] );
                            if(count($products)-1===$i){
                                $multi_sep = '';
                            }
                            else{
                                $multi_sep = ', ';
                            }
                            $product_urls .= "<a href='$url'>".$product->get_title()."</a>".$multi_sep;
                        }
                        return '<p><span class="restrict-message">'.esc_html__("Your access to this page expired or you haven't bought products needed to access this page. Buy", 'page_restrict_domain')." $product_urls ".esc_html__('in order to access this page!', 'page_restrict_domain').'</span></p>';
                    }
                }
            }
        } else {
            if($not_logged_in){
                return do_shortcode(get_post_field('post_content', $not_logged_in));
            }
            else{
                if($general_login_page){
                    return do_shortcode(get_post_field('post_content', $general_login_page));
                }
                else{
                    $login_link = '<a href="'.esc_url( wp_login_url() ).'">'.esc_html__( 'logged in', 'page_restrict_domain' ).'</a>';
                    return '<p class="restrict-message">'.esc_html__( 'You need to be', 'page_restrict_domain' )." $login_link ".esc_html__( 'in order to access this page!', 'page_restrict_domain' ).'</p>';
                }
            }
        }
    }
    /**
     * Processing redirect for the page for frontend display.
     *
     * @since      1.0.0
     * @return     void
     */
    public function process_page_redirect()
    {
        global $post;
        if (!isset($post)) {
            return;
        }
        $user_id = $this->user_id;
        $post_id = $this->post_id;

        $general_not_bought_page 	 = $this->general_not_bought_page;
        $general_login_page 		 = $this->general_login_page;
        $redirect_general_not_bought     = $this->redirect_general_not_bought;
        $redirect_general_login 	     = $this->redirect_general_login;
        
        $not_bought                  = $this->not_bought;
        $not_logged_in               = $this->not_logged_in;
		$redirect_not_bought 		 = $this->redirect_not_bought;
		$redirect_not_logged_in 	 = $this->redirect_not_logged_in;

        $products   = $this->products;
        $days       = $this->days;
        $hours      = $this->hours;
        $minutes    = $this->minutes;
        $seconds    = $this->seconds;
        $views      = $this->views;

        if(
            $post_id === $not_bought ||
            $post_id === $not_logged_in ||
            $post_id === $general_not_bought_page ||
            $post_id === $general_login_page
        ){
            return;
        }
        
        if(!$products){
            return;
        }
		if (is_user_logged_in()) {
            if (gettype($products) == "string") {
                $products_arr = array_map(function ($item) {
                    return (int)trim($item);
                }, explode(",", $products));
            } elseif (gettype($products) == "array") {
                $products_arr = $products;
            }
            $timeout_sec = $seconds+($minutes*60)+($hours*3600)+($days*86400);
            $purchased_products = $this->products_bought->get_purchased_products_by_ids(
                $user_id,
                $products_arr
            );
            $check_final = $this->restrict->check_final_all_types(
                $user_id,
                $post_id,
                $purchased_products,
                $products_arr,
                $views,
                $timeout_sec
            );
            if($check_final){
                return;
            }
			if($not_bought){
				if($redirect_not_bought){
					wp_redirect(get_permalink($not_bought));
				}
			}else{
				// * If there is no bought page on the page being restricted.
				if($general_not_bought_page){
					if($redirect_general_not_bought){
						wp_redirect(get_permalink($general_not_bought_page));
					}
				}
				else{
					return;
				}
			}
		}
		else{
			if($not_logged_in){
				if($redirect_not_logged_in && $products){ 
					wp_redirect(  get_permalink($not_logged_in) );
				}
			}
			else{
				if($general_login_page){
                    if($general_login_page !== $post_id){
                        if($redirect_general_login){
                            wp_redirect( get_permalink($general_login_page) );
                        }
                    }
				}
				else{
                    $login_link = '<a href="'.esc_url( wp_login_url() ).'">'.esc_html__( 'logged in', 'page_restrict_domain' ).'</a>';
                    return esc_html__( 'You need to be', 'page_restrict_domain' )." $login_link ".esc_html__( 'in order to access this page!', 'page_restrict_domain' );
				}
			}
		}
    }
}