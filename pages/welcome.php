<?php 
    include('check.php');
    $tbl_name4="tbl_student";
    $username=$_SESSION['student'];
    $where4="username='$username'";
    $query4=$obj->select_data($tbl_name4,$where4);
    $res4=$obj->execute_query($conn,$query4);
    if($res4==true)
    {
        $row4=$obj->fetch_data($res4);
        $student_id=$row4['student_id'];
        $first_name=$row4['first_name'];
        $last_name=$row4['last_name'];
        $faculty=$row4['faculty'];
        $full_name=$first_name.' '.$last_name;
    }
    //get total time and total no. of questions based on the faculty of the student
    $tbl_name_qns='tbl_faculty';
    $where_qns="faculty_id='$faculty'";
    $query_qns=$obj->select_data($tbl_name_qns,$where_qns);
    $res_qns=$obj->execute_query($conn,$query_qns);
    if($res_qns==true)
    {
        $row_qns=$obj->fetch_data($res_qns);
        $faculty_name=$row_qns['faculty_name'];
        $_SESSION['facultyName']=$faculty_name;
        $_SESSION['parol']=$row_qns['parol'];
        $time_duration=$row_qns['time_duration'];
        $totalTime=$time_duration*60;
        $qns_per_page=$row_qns['qns_per_set'];
        // $total_english=$row_qns['total_english'];
        
        //echo $total_english;die();
    }
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
            <form method="post" action="" class="forms">
                <?php
                $tbl_name="tbl_faculty";
                $where="is_active='yes'";
                $query=$obj->select_data($tbl_name,$where);
                $res=$obj->execute_query($conn,$query);
                $count_rows=$obj->num_rows($res);
                if($count_rows>0)
                {?>
                    <!-- <h3 style="margin: 10px 0;">Imtihon parolini kiriting</h3> -->
                    <span class="name" style="font-size: 30px;">Boshlash uchun parolni kiriting:</span>
                    <input style="width: 50%; margin-left: 30px; height: 40px; font-size: 30px" type="tel" name="parol" placeholder="12345678" pattern="[0-9]{8}" required /><br />
                    <input style="margin: 10px 0;" type="submit" name="submit" value="Tasdiqlash" class="btn-add" style="margin-left: 25%;" />
                <?php
                    }
                else {
                    echo("<h3 style='margin: 10px 0;'>Wait...</h3>");
                }
            ?>
            </form>
            <?php 
                if(isset($_POST['submit']))
                {
                    $parolX=$obj->sanitize($conn,$_POST['parol']);
                    if($parolX==$_SESSION['parol'])
                    {
                        header('location:'.SITEURL.'index.php?page=question'); 
                    }
                    else
                    {
                        header('location:'.SITEURL.'index.php?page=welcome'); 
                    }
                }
            ?>            
        </div>
    </div>
</div>
<!--Body Ends Here-->