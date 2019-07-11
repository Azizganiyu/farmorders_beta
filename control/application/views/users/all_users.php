<h4> All Users </h4>
<h6>Displaying all registered users</h6><br/>
<p><a href="<?php echo base_url.'index.php/users/new_user/';?>"><input type="button" class="btn btn-primary btn-sm" value="Add New" /></a></p>
<?php
        $attributes = array('class' => 'user_search_form');
        echo form_open('users/view_all_users/', $attributes);
        ?>
            <input class="search_box" type="text" value="<?php echo $search_key ?>" name="search_key" placeholder="Search">
            <button class="search_btn" type="submit">Search</button>
        </form>
<div class="row">
    <div class="col-12">
        <?php
        echo form_open('users/delete_users/');
        ?>
        <input type="submit" id="delete_checked" class="btn btn-sm btn-secondary" value="Delete">
        
        <table class="table users_table table-responsive table-hover table-striped">
        
            <thead class="">
            <tr>
                <th><input class="check_all checkboxes" type="checkbox"></th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
                <th></th>

            </tr>
            </thead>
            <tbody>
            
                <?php
                foreach($users as $row)
                {
                    echo '<tr>';
                    echo '<td><input class="checkboxes" name="item_delete[]" value="'.$row['ID'].'" type="checkbox"></td>';
                    echo '<td><a href="'.base_url.'index.php/users/view_user/'.$row['ID'].'">'.$row['user_name'].'</a></td>';
                    echo '<td>'.$row['full_name'].'</td>';
                    echo '<td>'.$row['user_email'].'</td>';
                    echo '<td>'.$row['user_role'].'</td>';
                    echo '<td><a href="'.base_url.'index.php/users/view_user/'.$row['ID'].'"><input type="button" class="btn btn-sm btn-link" value="View/Edit"></a></td>';
                    echo '<td><input url="'.base_url.'index.php/users/delete_users/'.$row['ID'].'" id="delete" type="button" class=" delete_btn btn btn-sm btn-link text-danger" value="Delete"></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
            <tfoot class="">
                <tr>
                    <th><input class="check_all checkboxes" type="checkbox"></th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                    <th></th>

                </tr>
            </tfoot>
        </table>
        </form>
    </div>
</div>
<p><?php echo $links; ?></p>

