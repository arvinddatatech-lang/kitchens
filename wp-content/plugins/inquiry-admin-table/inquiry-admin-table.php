
<?php
/*
Plugin Name:  Prd Inq Admin Table
Description: It displays a table with custom data
Author: SupportHost
Author URI: https://supporthost.com/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: supporthost-admin-table
Version: 1.0
*/
// Source - https://stackoverflow.com/a
// Posted by JsonKnight, modified by community. See post 'Timeline' for change history
// Retrieved 2025-12-16, License - CC BY-SA 4.0

if (is_admin()) {
    new Paulund_Wp_List_Table();
}

/**
 * Paulund_Wp_List_Table class will create the page to load the table
 */
class Paulund_Wp_List_Table
{
    /**
     * Constructor will create the menu item
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_menu_example_list_table_page'));
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_example_list_table_page()
    {
        add_menu_page('Product Inquiry Lists', 'Product Inquiry List', 'manage_options', 'example-list-table.php', array($this, 'list_table_page'));
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
        $exampleListTable = new Example_List_Table();
        $exampleListTable->prepare_items();
        ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>Product Inquiry List</h2>
            <div class="wrap">
                <div id="app"></div>
                <strong>                    
                        <?php
                       // $exampleListTable->search_box('search', 'search_id');                       
                        $exampleListTable->display(); ?>
                </strong>                
            </div>
        </div>
        
        <?php
    }
}
// WP_List_Table is not loaded automatically so we need to load it in our application
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
class Example_List_Table extends WP_List_Table
{
    
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $data = $this->table_data();
        usort($data, array(&$this, 'sort_data'));
        $perPage = 5;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page' => $perPage
        ));
        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }
    // function column_title($item)
    // {
    //     $actions = array(
    //         'edit' => sprintf('<a href="?page=%s&action=%s& hotel=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
    //         'delete' => sprintf('<a href="?page=%s&action=%s&hotel=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
    //     );
    //     return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions));
    // }

        public function get_columns()
    {        
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'subject' =>'Subject',
            'Action' => 'Action' 
        );       
        return $columns;
    }
    public function get_hidden_columns()
    {
        return array();
    }
   
    // public function get_sortable_columns()
    // {
    //     return array('name' => array('name', false));
    // }
private function table_data(  )
    {
$data = array();
global $wpdb;
$orderby = $order = '';
$orderby = isset($_GET['orderby']) ? trim($_GET['orderby']) : '';
$order = isset($_GET['order']) ? trim($_GET['order']) :'';
$search = isset($_POST['s']) ? trim($_POST['s']) :''; 
if( !empty($orderby) && !empty($order) ){
 $data = $wpdb->get_results(  "SELECT * from {$wpdb->prefix}cf7_entries ORDER BY $orderby $order", ARRAY_A );
}elseif(!empty($search)){
 $data = $wpdb->get_results( "SELECT * from {$wpdb->prefix}cf7_entries WHERE id Like '%{$search}%' OR title Like '%{$search}%' OR description Like '%{$search}%' OR director Like '%{$search}%'",  ARRAY_A  );
}else{
 $data = $wpdb->get_results(  "SELECT * from {$wpdb->prefix}cf7_entries",   ARRAY_A );  
    }

$dataFinal =array();
foreach($data as $key => $value) { 
$msgval = json_decode($value['data'] , associative: true);
//print_r($msgval);
// print_r($msgval['your-name']);
// print_r($msgval['your-email']);
// print_r($msgval['your-subject']);
// print_r($msgval['your-message']);
// print_r($msgval['page-url']);
$dataFinal[] = array('id' => $value['id'] , 'name' => $msgval['your-name'] , 'email' => $msgval['your-email'] , 'subject' => $msgval['your-subject']  );
}
//  echo '<pre>';
//  print_r($dataFinal);
// exit;

return $dataFinal;
    }
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />',
            $item['id']
        );
    }
    // function column_name($item)
    // {
    //     $actions = array(
    //         'edit' => sprintf('<a href="?page=%s&action=%s& hotel=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
    //         'delete' => sprintf('<a href="?page=%s&action=%s&hotel=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
    //     );
    //     return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions));
    // }
  public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'name':
            case 'email':
           // case 'data':
            case 'subject':
                // case 'id':
                return $item[$column_name];
            default:
                // echo "<pre>";
                // print_r($item);
                return sprintf('<button class="user_like" id="11" name="22" value="'.$item['id'].'" >View All Inquery Data</button>', $item['id'], 'view', $item['id']).
                sprintf('<a href="/?TB_inline&width=600&height=550&inlineId=my-modal-id&id=%s" class="thickbox"  >Open Modal Window</a>', $item['id']);
              //return  sprintf('<a href="/?TB_inline&width=600&height=550&inlineId=my-modal-id&id=%s" id="my-button" class="thickbox" onclick="return  f12(this)"   >Open Modal Window</a>', $item['id']);
                
        }
    }
    // To show bulk action dropdown
    // function get_bulk_actions()
    // {
    //     $actions = array(
    //         'delete_all' => __('Delete', 'supporthost-admin-table'),
    //         'draft_all' => __('Move to Draft', 'supporthost-admin-table')
    //     );
    //     return $actions;
    // }
}
?>
<?php
$likes = 0;
$link = admin_url('admin-ajax.php?action=my_user_like&post_id=1');

add_action("wp_ajax_my_user_like", "my_user_like");
add_action("wp_ajax_nopriv_my_user_like", "please_login");

function my_user_like() {  
$search = json_encode($_REQUEST['post_id'] );
$data = array();
global $wpdb;
$query = "SELECT * from {$wpdb->prefix}cf7_entries WHERE id = $search LIMIT 1 ";
$data = $wpdb->get_results( $query,  ARRAY_A  )[0];

//$msgval = json_decode($data, associative: true);

$dataFinal =array();
$msgval = json_decode($data['data'] , associative: true);
$dataFinal[] = array( 'id' => $data['id'] , 'form_id' => $data['form_id'] , 'submission_time' => $data['submission_time'] , 'ip_data' => $data['ip_data'] , 'name' => $msgval['your-name'] , 'email' => $msgval['your-email'] , 'phone' => $msgval['your-phone'] , 'subject' => $msgval['your-subject'] , 'your-message' => $msgval['your-message'] , 'page-url' => $msgval['page-url']  );
$results = json_encode($dataFinal );
      echo $results;
//print_r($dataFinal );
exit;
//print_r($msgval);
// print_r($msgval['your-name']);
// print_r($msgval['your-email']);
// print_r($msgval['your-subject']);
// print_r($msgval['your-message']);
// print_r($msgval['page-url']);




      
      exit;  
    print_r($_REQUEST['post_id']);exit;
    
//     exit(print_r($_REQUEST['post_id']));
// $result = array('aaa' => 1 , 'bb' => 33  ); 
// $results = json_encode($result);
//       echo $results;
//          die();
// $results = json_encode($_REQUEST);
//       echo $results;
   die();
}

function please_login() {
   echo "You must log in to like";
   die();
}

add_action( 'init', 'script_enqueuer' );

function script_enqueuer() {   
   wp_register_script( "liker_script", plugin_dir_url(__FILE__).'liker_script.js', array('jquery') );   
   wp_localize_script( 'liker_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'liker_script' );
}
?>
<?php add_thickbox(); ?>




