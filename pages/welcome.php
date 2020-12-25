<?php 
    include('check.php');
?>
<!--Body Starts Here-->
        <div class="main">
            <div class="content">
                <div class="welcome">
                    <?php 
                        if(isset($_SESSION['login']))
                        {
                            echo $_SESSION['login'];
                            unset($_SESSION['login']);
                        }
                        //Setting Time Limit Here
                        if(!isset($_SESSION['start_time']))
                        {
                            //$_SESSION['start_time']=
                        }
                    ?>
                    <span class="heavy">MAAB Innovation Test portaliga xush kelibsiz.<br />
                    
                    <div class="success">
                        <p style="text-align: left;">
                            Test topshirish tartibi.<br />
                            1. Test avtomatlashtirilgan va savollarni o'tkazib bo'lmaydi.<br />
                            <!-- 1. This test is automated and you won't be able to return to previous question.<br /> -->
                            2. Test topshirishga 1 marta imkon beriladi. Logout qilgandan so'ng qayta kirishning iloji yo'q. <br />
                            <!-- 2. Once you successfully login, you can't log back in unless the permission of system administrator.<br /> -->
                            3. Test boshlangandan so'ng timerga start beriladi va uni to'xtatish yoki o'chirishning iloji yo'q. <br />
                            <!-- 3. After you click on "Take a Test", the timer will start and it can't be paused or stopped.<br /> -->
                        </p>
                    </div>
                    <?php
                         $tbl_name="tbl_faculty";
                         $where="is_active='yes'";
                         $query=$obj->select_data($tbl_name,$where);
                         $res=$obj->execute_query($conn,$query);
                         $count_rows=$obj->num_rows($res);
                         if($count_rows>0)
                         {?>
                            <a href="<?php echo SITEURL; ?>index.php?page=question">
                                <button type="button" class="btn-go">Testni boshlash</button>
                            </a>
                            <!-- <a href="index.php?page=logout">
                                <button type="button" class="btn-exit">&nbsp;  &nbsp;</button>
                            </a> -->
                        <?php
                         }
                        else {
                            echo("<h3>Wait...</h3>");
                        }
                    ?>
                   
                </div>
            </div>
        </div>
        <!--Body Ends Here-->