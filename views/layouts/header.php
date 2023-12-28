<style>
    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        background-color: var(--white);

        & i {
          font-size: 20px;
          color: var(--blue);
        }
    }
</style>
<header class="container">
    <a href="../pages/homePage.php"><img src="../../imgs/logo.png" height="50" alt=""></a>
    <div class="btn__group">
    <?php
      if (isset($_SESSION['username'])) {
        // เข้าสู่ระบบแล้ว ให้แสดงรูปภาพ
        
        echo '<i class="bx bx-user-circle"></i>' . '<h3>' . $_SESSION['username'] . '</h3>'; 
        echo '<a href="../pages/logout.php" class="button w100">ออกจากระบบ</a>';
      } else {
        // ยังไม่เข้าสู่ระบบ ให้ซ่อนรูปภาพ
        echo '<a href="../pages/login.php" class="buttonOutline w100">เข้าสู่ระบบ</a>
              <a href="../pages/register.php" class="button w100">สร้างบัญชี</a>';
      }
    ?>
    </div>
</header>