<!--Body Starts Here-->
        <div class="main">
            <div class="content">
                <div class="report">
                    
                    <form method="post" action="" class="forms">
                        <h2>Imtihon qo'shish</h2>
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
                        <span class="name">Nomi</span> 
                        <input type="text" name="faculty_name" placeholder="Nomi..." required="true" /> <br />
                        
                        <span class="name">Davomiyligi</span>
                        <input type="number" name="time_duration" placeholder="Imtihon davomiyligi (minut)..." required="true" /><br />
                        
                        <span class="name">Savollar soni</span>
                        <input type="number" name="qns_per_page" placeholder="Umumiy savollar soni..." required="true" /><br />

                        <span class="name">Parol</span>
                        <input type="tel" name="parol" placeholder="12345678" pattern="[0-9]{8}" required /><br />
                        
                        <!-- <span class="name">Mantiqiy savollar</span>
                        <input type="number" name="total_english_qns" placeholder="Mantiqiy savollarv soni..." required="true" /><br />
                        
                        <span class="name">Matematikadan saollar</span>
                        <input type="number" name="total_math_qns" placeholder="Matematikadan savollar soni..." /><br /> -->
                        
                        <span class="name">Aktivmi?</span>
                        <input type="radio" name="is_active" value="yes" /> Xa
                        <input type="radio" name="is_active" value="no" /> Yo'q
                        <br />
                        
                        <input type="submit" name="submit" value="Imtihon qo'shish" class="btn-add" style="margin-left: 15%;" />
                        <a href="<?php echo SITEURL; ?>admin/index.php?page=faculties">
                            <button type="button" class="btn-delete">Bekor qilish</button>
                        </a>
                    </form>
                    
                    <?php 
                        if(isset($_POST['submit']))
                        {
                            //echo "Clicked";
                            //Get Values froom the form
                            $faculty_name=$obj->sanitize($conn,$_POST['faculty_name']);
                            $time_duration=$obj->sanitize($conn,$_POST['time_duration']);
                            $qns_per_page=$obj->sanitize($conn,$_POST['qns_per_page']);
                            // $total_english=$obj->sanitize($conn,$_POST['total_english_qns']);
                            // $total_math=$obj->sanitize($conn,$_POST['total_math_qns']);
                            $parol=$obj->sanitize($conn,$_POST['parol']);
                            if(isset($_POST['is_active']))
                            {
                                $is_active=$obj->sanitize($conn,$_POST['is_active']);
                            }
                            else
                            {
                                $is_active="yes";
                            }
                            $added_date=date('Y-m-d');
                            
                            //Normal PHP Validation
                            if(($faculty_name=="")||($time_duration=="")||($qns_per_page==""))
                            {
                                $_SESSION['validation']="<div class='error'>Barcha ma'lumotlarni kiriting</div>";
                                header('location:'.SITEURL.'admin/index.php?page=add_faculty');
                            }
                            //Inserting into the database
                            $tbl_name='tbl_faculty';
                            $data="parol='$parol',
                                    faculty_name='$faculty_name',
                                    time_duration='$time_duration',
                                    qns_per_set='$qns_per_page',
                                    is_active='$is_active',
                                    added_date='$added_date',
                                    updated_date=''";
                            //Query to Insert Data
                            $query=$obj->insert_data($tbl_name,$data);
                            $res=$obj->execute_query($conn,$query);
                            if($res===true)
                            {
                                //Success Message
                                $_SESSION['add']="<div class='success'>Imtihon muvaffaqiyatli qo'shildi</div>";
                                header('location:'.SITEURL.'admin/index.php?page=faculties');
                            }
                            else
                            {
                                //FAil Message
                                $_SESSION['add']="<div class='error'>Imtihonni qo'shishda xatolik. Qaytadan urinib ko'ring.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=add_faculty');
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!--Body Ends Here-->