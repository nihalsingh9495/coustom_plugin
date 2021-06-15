<?php
/**
 * Plugin Name: WP Manage Labels
 * Plugin URI: https://civilityscorecard.com/
 * Description: This plugin is used to manage labels.
 * Version: 1.0
 * Author: Amandeep
 * Author URI: https://civilityscorecard.com/
*/

function custom_label_tbl(){
    global $wpdb;
    $tablename =$wpdb->prefix ."manage_labels"; 
    if($wpdb->get_var("SHOW TABLES LIKE '$tablename'") != $tablename) {
        //if it does not exists we create the table
        $sql="CREATE TABLE `$tablename`(
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `value` varchar(500) DEFAULT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        );";
        //wordpress function for updating the table
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

register_activation_hook( __FILE__, 'custom_label_tbl');

function manage_label_name(){
   add_menu_page('Manage Labels', 'Manage Labels', 'add_users', 'manage_labels', 'wp_manage_label_save', '', 6);  
}
add_action('admin_menu', 'manage_label_name');

function wp_manage_label_save(){ 
    global $wpdb; 
    $tablename = $wpdb->prefix ."manage_labels"; 
    if(isset($_POST['manage_label_submit']))
    {
        $all_labels_array       = [
                                    'manage_speakers_label' => $_POST['manage_speakers_label'],
                                    'manage_speakers_placeholder' => $_POST['manage_speakers_placeholder'],
                                    'speakers_label' => $_POST['speakers_label'],
                                    'speakers_placeholder' => $_POST['speakers_placeholder'],
                                    'manage_speakers_button' => $_POST['manage_speakers_button'],
                                    'speach_label'  => $_POST['speach_label'],
                                    'speech_type'   => $_POST['speech_type'],
                                    'speach_date'  => $_POST['speach_label'],
                                ];
        $wpdb->query("INSERT INTO $tablename(`value`) VALUES ('".json_encode($all_labels_array)."')");
    }else if(isset($_POST['manage_label_update'])){
        $all_labels_array       = [
                                    'manage_speakers_label' => $_POST['manage_speakers_label'],
                                    'manage_speakers_placeholder' => $_POST['manage_speakers_placeholder'],
                                    'speakers_label' => $_POST['speakers_label'],
                                    'speakers_placeholder' => $_POST['speakers_placeholder'],
                                    'manage_speakers_button' => $_POST['manage_speakers_button'],
                                    'speech_label'  => $_POST['speech_label'],
                                    'speech_type'   => $_POST['speech_type'],
                                    'speach_date'   => $_POST['speach_date'],
                                ];
        $wpdb->query("UPDATE $tablename SET `value` ='".json_encode($all_labels_array)."' where id=1");
    }
    $label_data = $wpdb->get_row("SELECT * FROM $tablename where id=1");
    $lable_json = json_decode($label_data->value,true);
    $manage_speakers_label = $lable_json['manage_speakers_label'];
    $manage_speakers_placeholder = $lable_json['manage_speakers_placeholder'];
    $speakers_label = $lable_json['speakers_label'];
    $speakers_placeholder = $lable_json['speakers_placeholder'];
    $manage_speakers_button = $lable_json['manage_speakers_button'];
    $speech_label = $lable_json['speech_label'];
    $speech_type = $lable_json['speech_type'];
    ?>
    <div class="row">
       <div class="col-sm-12">
          <center><h2>Manage Labels</h2></center>    
          <hr>
       </div>
    </div>
    <div class="row">
       <div class="col-sm-12">
        <form method="POST" action="#">
            <div class="form-group">
                <label for="manage-speakers-label">Manage Speakers Label</label>
                <input type="text" class="form-control" id="manage-speakers-label" aria-describedby="manage-speakers-label" name="manage_speakers_label" placeholder="Enter lable of the manage speakers" value="<?php if(isset($manage_speakers_label)){ echo $manage_speakers_label; }?>">
            </div> 
            <div class="form-group">
                <label for="manage-speakers-placeholder">Manage Speakers Placehoder</label>
                <input type="text" class="form-control" id="manage-speakers-placeholder" aria-describedby="manage-speakers-placeholder" name="manage_speakers_placeholder" placeholder="Enter placeholder of the manage speakers" value="<?php if(isset($manage_speakers_placeholder)){ echo $manage_speakers_placeholder; }?>" required>
            </div>
            <div class="form-group">
                <label for="speakers-label">Speakers Label</label>
                <input type="text" class="form-control" id="speakers-label" aria-describedby="speakers-label" name="speakers_label" placeholder="Enter label of the speakers" value="<?php if(isset($speakers_label)){ echo $speakers_label; }?>" required>
            </div>
            <div class="form-group">
                <label for="speakers-placeholder">Speakers Placehoder</label>
                <input type="text" class="form-control" id="speakers-placeholder" aria-describedby="speakers-placeholder" name="speakers_placeholder" placeholder="Enter Placehoder of the speakers" value="<?php if(isset($speakers_placeholder)){ echo $speakers_placeholder; }?>" required>
            </div>
            <div class="form-group">
                <label for="manage-speakers-button">Manage Speakers Button</label>
                <input type="text" class="form-control" id="manage-speakers-button" aria-describedby="manage-speakers-button" name="manage_speakers_button" placeholder="Enter button text of the manage speakers" value="<?php if(isset($manage_speakers_button)){ echo $manage_speakers_button; }?>" required>
            </div>
            <div class="form-group">
                <label for="speech-label">Speech Label</label>
                <input type="text" class="form-control" id="speech-label" aria-describedby="speech-label" name="speech_label" placeholder="Enter Speech Label" value="<?php if(isset($speech_label)){ echo $speech_label; }?>" required>
            </div>
             <div class="form-group">
                <label for="speech-type">Speech Type</label>
                <input type="text" class="form-control" id="speech-type" aria-describedby="speech-type" name="speech_type" placeholder="Enter Speech Type" value="<?php if(isset($speech_type)){ echo $speech_type; }?>" required>
            </div>
             <div class="form-group">
                <label for="speech-date">Speech Date</label>
                <input type="text" class="form-control" id="speech-date" aria-describedby="speech-date" name="speech_date" placeholder="Enter Speech Date Label" value="<?php if(isset($speech_date)){ echo $speech_date; }?>" required>
            </div>
            <?php if(empty($label_data)){?>
                <button type="submit" class="button button-primary button-large" name="manage_label_submit">Submit</button>
            <?php } else{?>
                <button type="submit" class="button button-primary button-large" name="manage_label_update">Update</button>
                <?php
                }
            ?>
        </form>
       </div>
    </div>
<?php }
