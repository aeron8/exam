<!--Body Starts Here-->
<?php 
    if(isset($_GET['student_id']))
    {
        $student_id=$_GET['student_id'];
        $tbl_name='tbl_student';
        $where="student_id=$student_id";
        $query=$obj->select_data($tbl_name,$where);
        $res=$obj->execute_query($conn,$query);
        $count_rows=$obj->num_rows($res);
        if($count_rows==1)
        {
            $row=$obj->fetch_data($res);
            $first_name=$row['first_name'];
            $middle_name=$row['middle_name'];
            $last_name=$row['last_name'];
            $email=$row['email'];
            $username=$row['username'];
            $password=$row['password'];
            $contact=$row['contact'];
            $contact2=$row['contact2'];
            $gender=$row['gender'];
            $faculty=$row['faculty'];
            $is_active=$row['is_active'];
        }
        else
        {
            header('location:'.SITEURL.'admin/index.php?page=students');
        }
    }
    else
    {
        header('location:'.SITEURL.'admin/index.php?page=students');
    }
?>
        <div class="main">
            <div class="content">
                <div class="report">
                    
                    <form method="post" action="" class="forms">
                        <h2>Yangilash</h2>
                        <?php 
                            if(isset($_SESSION['validation']))
                            {
                                echo $_SESSION['validation'];
                                unset($_SESSION['validation']);
                            }
                            if(isset($_SESSION['update']))
                            {
                                echo $_SESSION['update'];
                                unset($_SESSION['update']);
                            }
                        ?>
                        <span class="name">Ismi</span> 
                        <input type="text" name="first_name" value="<?php echo $first_name; ?>" required="true" /> <br />
                        
                        <span class="name">Otasining ismi</span>
                        <input type="text" name="middle_name" value="<?php echo $middle_name; ?>" required="true" /><br />

                        <span class="name">Familiya</span>
                        <input type="text" name="last_name" value="<?php echo $last_name; ?>" required="true" /><br />
                        
                        <!-- <span class="name">Email</span> -->
                        <input type="hidden" name="email" value="<?php echo $email; ?>" required="true" />
                        
                        <!-- <span class="name">Username</span> -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>" required="true" />
                        
                        <!-- <span class="name">Password</span> -->
                        <input type="hidden" name="password" value="<?php echo $password; ?>" required="true" />
                        
                        <span class="name">Tel. raqami</span>
                        <input type="tel" name="contact" value="<?php echo $contact; ?>" /><br />
                        
                        <span class="name">Ota-ona tel.</span>
                        <input type="tel" name="contact2" value="<?php echo $contact2; ?>" /><br />

                        <span class="name">Jinsi</span>
                        <input <?php if($gender=='male'){echo "checked='checked'";} ?> type="radio" name="gender" value="male" /> Erkak
                        <input <?php if($gender=='female'){echo "checked='checked'";} ?> type="radio" name="gender" value="female" /> Ayol 
                        <!-- <input <?php if($gender=='other'){echo "checked='checked'";} ?> type="radio" name="gender" value="other" /> Other -->
                        <br />
                        
                        <span class="name">Imtihon</span>
                        <select name="faculty">
                            <?php 
                                //Get Faculties from database
                                $tbl_name="tbl_faculty";
                                $query=$obj->select_data($tbl_name);
                                $res=$obj->execute_query($conn,$query);
                                $count_rows=$obj->num_rows($res);
                                if($count_rows>0)
                                {
                                    while($row=$obj->fetch_data($res))
                                    {
                                        $faculty_id=$row['faculty_id'];
                                        $faculty_name=$row['faculty_name'];
                                        ?>
                                        <option <?php if($faculty==$faculty_id){echo"selected='selected'";} ?> value="<?php echo $faculty_id; ?>"><?php echo $faculty_name; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <option value="0">Uncategorized</option>
                                    <?php
                                }
                            ?>
                        </select>
                        <br />
                        
                        <span class="name">Aktivmi?</span>
                        <input <?php if($is_active=='yes'){echo "checked='checked'";} ?> type="radio" name="is_active" value="yes" /> Xa
                        <input <?php if($is_active=='no'){echo "checked='checked'";} ?> type="radio" name="is_active" value="no" /> Yo'q
                        <br />
                        
                        <input type="submit" name="submit" value="Yangilash" class="btn-update" style="margin-left: 15%;" />
                        <a href="<?php echo SITEURL; ?>admin/index.php?page=students"><button type="button" class="btn-delete">Bekor qilish</button></a>
                    </form>
                    
                    <?php 
                        if(isset($_POST['submit']))
                        {
                            //echo "Clicked";
                            $first_name=$obj->sanitize($conn,$_POST['first_name']);
                            $last_name=$obj->sanitize($conn,$_POST['last_name']);
                            $middle_name=$obj->sanitize($conn,$_POST['middle_name']);
                            // $email=$obj->sanitize($conn,$_POST['email']);
                            // $username=$obj->sanitize($conn,$_POST['username']);
                            // $password=$obj->sanitize($conn,$_POST['password']);
                            $contact=$obj->sanitize($conn,$_POST['contact']);
                            $contact2=$obj->sanitize($conn,$_POST['contact2']);
                            if(isset($_POST['gender']))
                            {
                                $gender=$_POST['gender'];
                            }
                            $faculty=$_POST['faculty'];
                            if(isset($_POST['is_active']))
                            {
                                $is_active=$_POST['is_active'];
                            }
                            $updated_date=date('Y-m-d');
                            
                            //Normal Validation
                            if(($first_name||$last_name||$email||$username||$password)==null)
                            {
                                //SET SSESSION Message
                                $_SESSION['validation']="<div class='error'>First Name or Last Name, or Email or Username or Password is Empty.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=update_student&student_id='.$student_id);
                            }
                            //Set Table name to update
                            $tbl_name='tbl_student';
                            //SEt New Data to Change
                            $data="first_name='$first_name',
                                    last_name='$last_name',
                                    middle_name='$middle_name',
                                    email='$email',
                                    username='$username',
                                    password='$password',
                                    contact='$contact',
                                    contact2='$contact2',
                                    gender='$gender',
                                    faculty='$faculty',
                                    is_active='$is_active',
                                    updated_date='$updated_date'
                                    ";
                            $where="student_id=$student_id";
                            $query=$obj->update_data($tbl_name,$data,$where);
                            $res=$obj->execute_query($conn,$query);
                            if($res===true)
                            {
                                $_SESSION['update']="<div class='success'>Student detail successfully updated.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=students');
                            }
                            else
                            {
                                $_SESSION['update']="<div class='error'>Failed to update student details.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=update_student&student_id='.$student_id);
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!--Body Ends Here-->