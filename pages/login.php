<!--Body Starts Here-->
<div class="main">
    <div class="content">
        <div class="report">
        <?php
            $tbl_name="tbl_faculty";
            $where="is_active='yes'";
            $query=$obj->select_data($tbl_name,$where);
            $res=$obj->execute_query($conn,$query);
            $count_rows=$obj->num_rows($res);
            if($count_rows>0)
            {?>
            <form method="post" action="" class="forms">
                <h2>Registratsiya</h2>
                <?php 
                    if(isset($_SESSION['validation']))
                    {
                        echo $_SESSION['validation'];
                        unset($_SESSION['validation']);
                    }
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                ?> 
                <span class="name">Ism</span> 
                <input type="text" name="first_name" placeholder="Ism" required="true" /> <br />

                <span class="name">Otasining ismi</span> 
                <input type="text" name="middle_name" placeholder="Otasining ismi" required="true" /> <br />
                
                <span class="name">Familiya</span>
                <input type="text" name="last_name" placeholder="Familiya" required="true" /><br />
                
                <!-- <span class="name">Email</span>
                <input type="email" name="email" placeholder="Email Address" required="true" /><br />
                
                <span class="name">Username</span>
                <input type="text" name="username" placeholder="Username" required="true" /><br />
                
                <span class="name">Password</span>
                <input type="text" name="password" placeholder="Password" required="true" /><br /> -->
                
                <span class="name">Tel. raqami</span>
                <input type="tel" name="contact" placeholder="991234567" pattern="[0-9]{9}" required /><br />
                
                <span class="name">Ota-ona tel. raqami</span>
                <input type="tel" name="contact2" placeholder="991234567" pattern="[0-9]{9}" required /><br />

                <span class="name">Jinsi</span>
                <input type="radio" name="gender" value="male" /> Erkak
                <input type="radio" name="gender" value="female" /> Ayol
                <!-- <input type="radio" name="gender" value="other" /> Other -->
                <br />
                
                <span class="name">Imtihon</span>
                <select name="faculty">
                    <?php 
                        //Get Faculty from database
                        $tbl_name="tbl_faculty";
                        $where="is_active='yes'";
                        $query=$obj->select_data($tbl_name,$where);
                        $res=$obj->execute_query($conn,$query);
                        $count_rows=$obj->num_rows($res);
                        if($count_rows>0)
                        {
                            while($row=$obj->fetch_data($res))
                            {
                                $faculty_id=$row['faculty_id'];
                                $faculty_name=$row['faculty_name'];
                                ?>
                                <option value="<?php echo $faculty_id; ?>"><?php echo $faculty_name; ?></option>
                                <?php
                            }
                        }
                        else
                        {
                            echo("<option value='none'>NONE</option>");
                        }
                    ?>
                </select>
                <br />
                
                <!-- <span class="name">Is Active?</span>
                <input type="radio" name="is_active" value="yes" /> Yes 
                <input type="radio" name="is_active" value="no" /> No
                <br /> -->
                
                <input type="submit" name="submit" value="Register" class="btn-add" style="margin-left: 15%;" />
                <a href="http://maab.uz/"><button type="button" class="btn-delete">Cancel</button></a>
            </form>
                <?php
                    }
                else {
                    echo("<div class='wait-container'><h1 style='padding: 20% 0'>Hali imtihon boshlanmadi...</h1></div>");
                }
            ?>
            
           
            <?php 
                if(isset($_POST['submit']))
                {
                    //Getting Values from the form
                    $contactX=$obj->sanitize($conn,$_POST['contact']);
                    //  $password_db=md5($obj->sanitize($conn,$_POST['password']));
                    
                    //  if(($username=="")or($password=""))
                    //  {
                    //      $_SESSION['validation']="<div class='error'>Username or Password is Empty</div>";
                    //      header('location:'.SITEURL.'admin/login.php');
                    //  }
                    $tbl_nameX="tbl_student";
                    $whereX="contact='$contactX'";
                    $queryX=$obj->select_data($tbl_nameX,$whereX);
                    $resX=$obj->execute_query($conn,$queryX);
                    $count_rowsX=$obj->num_rows($resX);
                    if($count_rowsX>=1)
                    {
                        $_SESSION['validation']="<div class='error'>Ushbu foydalanuvchi allaqachon ro'yhatdan o'tgan.</div>";
                        header('location:'.SITEURL.'index.php?page=login'); 
                    }
                    else
                    {
                        //Getting Values from the form
                        $first_name=$obj->sanitize($conn,$_POST['first_name']);
                        $last_name=$obj->sanitize($conn,$_POST['last_name']);
                        $email=$obj->sanitize($conn,$_POST['contact']);
                        $username=$obj->sanitize($conn,$_POST['contact']);
                        $password=$obj->sanitize($conn,$_POST['contact']);
                        $middle_name=$obj->sanitize($conn,$_POST['middle_name']);
                        $contact=$obj->sanitize($conn,$_POST['contact']);
                        $contact2=$obj->sanitize($conn,$_POST['contact2']);
                        if(isset($_POST['gender']))
                        {
                            $gender=$obj->sanitize($conn,$_POST['gender']);
                        }
                        else
                        {
                            $gender='male';
                        }
                    
                        $faculty=$obj->sanitize($conn,$_POST['faculty']);
                        if(isset($_POST['is_active']))
                        {
                            $is_active=$_POST['is_active'];
                        }
                        else
                        {
                            $is_active='yes';
                        }
                        $added_date=date('Y-m-d');
                        
                        //Backend Validation, Checking whether the input fields are empty or not
                        if(($first_name||$last_name||$email||$username||$password||$middle_name||$contact2)==null)
                        {
                            //SET SSESSION Message
                            $_SESSION['validation']="<div class='error'>First Name or Last Name, or Email or Username or Password is Empty.</div>";
                            header('location:'.SITEURL.'admin/index.php?page=add_student');
                        }
                        
                        //Addding to the database
                        $tbl_name='tbl_student';
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
                                added_date='$added_date',
                                updated_date='2020-12-02'";
                        $query=$obj->insert_data($tbl_name,$data);
                        $res=$obj->execute_query($conn,$query);
                        if($res===true)
                        {
                            $_SESSION['student']=$username;
                            $_SESSION['add']="<div class='success'>Muvaffaqiyatli registratsiya qilindi</div>";
                            header('location:'.SITEURL.'index.php?page=welcome');
                        }
                        else
                        {
                            $_SESSION['add']="<div class='error'>Registratsiya qilishda xatolik</div>";
                            header('location:'.SITEURL.'index.php?page=login');
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>
<!--Body Ends Here-->