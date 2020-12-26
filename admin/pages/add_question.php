<!--Body Starts Here-->
        <div class="main">
            <div class="content">
                <div class="report">
                    
                    <form method="post" action="" class="forms" enctype="multipart/form-data">
                        <h2>Savol qo'shish</h2>
                        <?php 
                            if(isset($_SESSION['add']))
                            {
                                echo $_SESSION['add'];
                                unset($_SESSION['add']);
                            }
                            if(isset($_SESSION['invalid']))
                            {
                                echo $_SESSION['invalid'];
                                unset($_SESSION['invalid']);
                            }
                            if(isset($_SESSION['upload']))
                            {
                                echo $_SESSION['upload'];
                                unset($_SESSION['upload']);
                            }
                        ?>
                        <span class="name">Savol</span> <br />
                        <textarea name="question" placeholder="Savol qo'shing" required="true"></textarea> <br />
                        <script>
                            CKEDITOR.replace( 'question' );
                        </script>
                        
                        <span class="name">Rasm</span>
                        <input type="file" name="image" /><br />
                        
                        <span class="name">Birinchi javob</span>
                        <input type="text" name="first_answer" placeholder="Birinchi javob..." required="true" /><br />
                        
                        <span class="name">Ikkinchi javob</span>
                        <input type="text" name="second_answer" placeholder="Ikkinchi javob..." required="true" /><br />
                        
                        <span class="name">Uchinchi javob</span>
                        <input type="text" name="third_answer" placeholder="Uchinchi javob..." required="true" /><br />
                        
                        <span class="name">To'rtinchi javob</span>
                        <input type="text" name="fourth_answer" placeholder="To'rtinchi javob..." required="true" /><br />
                        
                         <!-- <span class="name">Beshinchi javob</span>
                        <input type="text" name="fifth_answer" placeholder="Beshinchi javob..." required="true" /><br /> -->
                       
                        
                        <span class="name">Javob</span>
                        <select name="answer">
                            <option value="1">Birinchi javob</option>
                            <option value="2">Ikkinchi javob</option>
                            <option value="3">Uchinchi javob</option>
                            <option value="4">To'rtinchi javob</option>
                            <!-- <option value="5">Fifth Answer</option> -->
                        </select>
                        <br />
                        
                        <span class="name">Tushuntirish</span><br />
                        <textarea name="reason" placeholder="Reason to be the answer"></textarea>
                        <script>
                            CKEDITOR.replace( 'reason' );
                        </script>
                        <br />
                        
                        <span class="name">Marks</span>
                        <input type="text" name="marks" placeholder="Marks for this question" />
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
                                        <option value="<?php echo $faculty_id; ?>"><?php echo $faculty_name; ?></option>
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
                        
                        <span class="name">Is Active?</span>
                        <input type="radio" name="is_active" value="yes" /> Yes 
                        <input type="radio" name="is_active" value="no" /> No
                        <br />
                        
                        <input type="submit" name="submit" value="Add Question" class="btn-add" style="margin-left: 15%;" />
                        <a href="<?php echo SITEURL; ?>admin/index.php?page=questions"><button type="button" class="btn-delete">Cancel</button></a>
                    </form>
                    
                    <?php 
                        if(isset($_POST['submit']))
                        {
                            //echo "Clicked";
                            //Managing Question Images
                            if($_FILES['image']['name']!="")
                            {
                                //echo "Book Cover is Available";
                                //Getting File Extension
                                $ext=end(explode('.',$_FILES['image']['name']));
                                //Checking if the file type is valid or not
                                $valid_file=$obj->check_image_type($ext);
                                if($valid_file==false)
                                {
                                    $_SESSION['invalid']="<div class='error'>Invalid Image type. Please use JPG or PNG or GIF file type.</div>";
                                    header('location:'.SITEURL.'admin/index.php?page=add_question');
                                    die();
                                }
                                //Uploading if the file is valid
                                //first changing image name
                                $new_name='Beyond_Boundaries_Question_'.$obj->uniqid();
                                $image_name=$new_name.'.'.$ext;
                                //Adding Watermark to the image fie too
                                $source=$_FILES['image']['tmp_name'];
                                $destination="../images/questions/".$image_name;
                                $upload=$obj->upload_file($source,$destination);
                                if($upload==false)
                                {
                                    $_SESSION['upload']="<div class='error'>Failed to upload question image. Try again.</div>";
                                    header('location:'.SITEURL.'admin/index.php?page=add_question');
                                    die();
                                }
                            }
                            else
                            {
                                $image_name="";
                            }
                            //Get all values from the forms
                            $question=$obj->sanitize($conn,$_POST['question']);
                            $first_answer=$obj->sanitize($conn,$_POST['first_answer']);
                            $second_answer=$obj->sanitize($conn,$_POST['second_answer']);
                            $third_answer=$obj->sanitize($conn,$_POST['third_answer']);
                            $fourth_answer=$obj->sanitize($conn,$_POST['fourth_answer']);
                           
                            $faculty=$obj->sanitize($conn,$_POST['faculty']);
                            if(isset($_POST['is_active']))
                            {
                                $is_active=$_POST['is_active'];
                            }
                            else
                            {
                                $is_active='yes';
                            }
                            $answer=$obj->sanitize($conn,$_POST['answer']);
                            $reason=$obj->sanitize($conn,$_POST['reason']);
                            $marks=$obj->sanitize($conn,$_POST['marks']);
                            // $category=$obj->sanitize($conn,$_POST['category']);
                            $added_date=date('Y-m-d');
                            
                            $tbl_name='tbl_question';
                            $data="question='$question',
                                    first_answer='$first_answer',
                                    second_answer='$second_answer',
                                    third_answer='$third_answer',
                                    fourth_answer='$fourth_answer',
                                    answer='$answer',
                                    reason='$reason',
                                    marks='$marks',
                                    faculty='$faculty',
                                    is_active='$is_active',
                                    added_date='$added_date',
                                    updated_date='',
                                    image_name='$image_name'
                                    ";
                            $query=$obj->insert_data($tbl_name,$data);
                            $res=$obj->execute_query($conn,$query);
                            if($res===true)
                            {
                                $_SESSION['add']="<div class='success'>Question successfully added.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=questions');
                            }
                            else
                            {
                                $_SESSION['add']="<div class='error'>Failed to add question. Try again.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=add_question');
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!--Body Ends Here-->