<!--Body Starts Here-->
        <?php 
            if(isset($_GET['id']))
            {
                $faculty_id=$_GET['id'];
                //Getting VAlues fro the datadabase
                $tbl_name="tbl_faculty";
                $where="faculty_id=$faculty_id";
                $query=$obj->select_data($tbl_name,$where);
                $res=$obj->execute_query($conn,$query);
                $count_rows=$obj->num_rows($res);
                if($count_rows==1)
                {
                    $row=$obj->fetch_data($res);
                    $faculty_name=$row['faculty_name'];
                    $time_duration=$row['time_duration'];
                    $qns_per_page=$row['qns_per_set'];
                    $parol=$row['parol'];
                    $is_active=$row['is_active'];
                }
                else
                {
                    header('location:'.SITEURL.'admin/index.php?page=faculties');
                }
            }
            else
            {
                header('location:'.SITEURL.'admin/index.php?page=faculties');
            }
        ?>
        <div class="main">
            <div class="content">
                <div class="report">
                    
                    <form method="post" action="" class="forms">
                        <h2>Imtihonni yangilash</h2>
                        <?php 
                            if(isset($_SESSION['update']))
                            {
                                echo $_SESSION['update'];
                                unset($_SESSION['update']);
                            }
                        ?>
                        <span class="name">Nomi</span> 
                        <input type="text" name="faculty_name" value="<?php echo $faculty_name; ?>" required="true" /> <br />
                        
                        <span class="name">Davomiyligi</span>
                        <input type="number" name="time_duration" value="<?php echo $time_duration; ?>" required="true" /><br />
                        
                        <span class="name">Savollar</span>
                        <input type="number" name="qns_per_page" value="<?php echo $qns_per_page; ?>" required="true" /><br />

                        <span class="name">Parol</span>
                        <input type="tel" name="parol" placeholder="12345678" pattern="[0-9]{8}" value="<?php echo $parol; ?>" required /><br />
                        
                        <!-- <span class="name">Total English Qns</span>
                        <input type="number" name="total_english_qns" value="<?php echo $total_english; ?>" required="true" /><br />
                        
                        <span class="name">Total Math Qns</span>
                        <input type="number" name="total_math_qns" value="<?php echo $total_math; ?>" /><br /> -->
                        
                        <span class="name">Aktivmi?</span>
                        <input <?php if($is_active=="yes"){echo "checked='checked'";} ?> type="radio" name="is_active" value="yes" /> Xa 
                        <input <?php if($is_active=="no"){echo "checked='checked'";} ?> type="radio" name="is_active" value="no" /> Yo'q
                        <br />
                        
                        <input type="submit" name="submit" value="Yangilash" class="btn-update" style="margin-left: 15%;" />
                        <a href="<?php echo SITEURL; ?>admin/index.php?page=faculties"><button type="button" class="btn-delete">Bekor qilish</button></a>
                    </form>
                    <?php 
                        if(isset($_POST['submit']))
                        {
                            //echo "Clcked";
                            //Getting all the values from the forms
                            $faculty_name=$obj->sanitize($conn,$_POST['faculty_name']);
                            $parol=$obj->sanitize($conn,$_POST['parol']);
                            $time_duration=$obj->sanitize($conn,$_POST['time_duration']);
                            $qns_per_page=$obj->sanitize($conn,$_POST['qns_per_page']);
                            $is_active=$obj->sanitize($conn,$_POST['is_active']);
                            $updated_date=date('Y-m-d');
                            
                            $tbl_name='tbl_faculty';
                            $data="parol='$parol',
                                    faculty_name='$faculty_name',
                                    time_duration='$time_duration',
                                    qns_per_set='$qns_per_page',
                                    is_active='$is_active',
                                    updated_date='$updated_date'";
                            $where="faculty_id='$faculty_id'";
                            $query=$obj->update_data($tbl_name,$data,$where);
                            $res=$obj->execute_query($conn,$query);
                            if($res===true)
                            {
                                $_SESSION['update']="<div class='success'>Imtihon yangilandi.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=faculties');
                            }
                            else
                            {
                                $_SESSION['update']="<div class='error'>Yangilashda xatolik.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=update_faculty&id='.$faculty_id);
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!--Body Ends Here-->