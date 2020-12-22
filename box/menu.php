<?php 
    if(!isset($_SESSION['user']))
    {
        $_SESSION['xss']="<div class='error'>Control panelga kirish uchun login parolni kiriting</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>
<!--Navigation Starts Here-->
<nav class="menu">
    <div class="wrapper">
        <ul>
            <a href="<?php echo SITEURL; ?>admin/index.php?page=home"><li>Asosiy</li></a>
            <a href="<?php echo SITEURL; ?>admin/index.php?page=students"><li>O'quvchilar</li></a>
            <a href="<?php echo SITEURL; ?>admin/index.php?page=faculties"><li>Imtihonlar</li></a>
            <a href="<?php echo SITEURL; ?>admin/index.php?page=questions"><li>Savollar</li></a>
            <a href="<?php echo SITEURL; ?>admin/index.php?page=results"><li>Natijalar</li></a>
            <a href="<?php echo SITEURL; ?>admin/index.php?page=settings"><li>Sozlamalar</li></a>
            <a href="<?php echo SITEURL; ?>admin/index.php?page=logout" onclick="return confirm('Ishonchingiz komilmi?')"><li>Log Out</li></a>
        </ul>
    </div>
</nav>
<!--Navigation Ends Here-->