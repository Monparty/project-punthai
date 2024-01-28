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

  .dropbtn {
    display: flex;
    align-items: center;
    justify-content: space-around;
    gap: 10px;
    padding: 5px 20px;
    border-radius: 5px;
    transition: .2s;
    
      &:hover {
        background-color: var(--lightGray);
      }
  }

  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    margin-top: 5px;
    position: absolute;
    background-color: var(--white);
    box-shadow: var(--shadow);
    border-radius: 5px;
    width: 200px;
    overflow: auto;
    right: 0;
    z-index: 2;
    padding: 10px;

    & .btn__group {
      display: flex;
      justify-content: flex-start;
      margin-bottom: 10px;
      font-size: 16px;
      border-radius: 15px;
      padding: 5px;
      
      &:last-child {
        margin-bottom: 0;
      }

      &:hover {
        background: var(--lightGray);
      }
    }
  }

  .show {
    display: block;
  }
</style>
<header class="container">
  <a href="../pages/homePage.php"><img src="../../imgs/logo.png" height="50" alt=""></a>
  <div class="btn__group">
    <?php if (isset($_SESSION['username'])) { ?>

      <!-- เข้าสู่ระบบแล้ว ให้แสดงรูปภาพ -->
      <div  class="dropdown">
        <div class="dropbtn" onclick="myFunction()">
          <?php echo $_SESSION['username'];?>
          <i class='bx bx-chevron-down'></i>
        </div>
        <div id="myDropdown" class="dropdown-content">
          <a href="userAccount.php" class="btn__group">
            <i class='bx bx-user'></i>
            แก้ไขข้อมูลส่วนตัว
          </a>
          <a href="userBooking.php" class="btn__group">
            <i class="bx bx-book-bookmark"></i>
            การจองของฉัน
          </a>
          <a href="logout.php" class="btn__group">
            <i class='bx bx-power-off'></i>
            ออกจากระบบ
          </a>
        </div>
      </div>
      
    <?php } else { ?>

      <!-- ยังไม่เข้าสู่ระบบ ให้ซ่อนรูปภาพ -->
      <a href="../pages/login.php" class="buttonOutline w100">เข้าสู่ระบบ</a>
      <a href="../pages/register.php" class="button w100">สร้างบัญชี</a>

    <?php } ?>
  </div>
</header>

<script>
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
</script>