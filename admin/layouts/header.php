<style>
    header {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 10px 20px;
        column-gap: 50px;
        background-color: #F7F9FC;

        & i {
          font-size: 28px;
          color: #666666;
          cursor: pointer;
        }

        .btn__group {
          column-gap: 20px;
        }

    }
</style>
<header>
  <div class="btn__group">
    <a href="#">
      <i class='bx bx-info-circle' ></i>
    </a>
    <a href="#">
      <i class='bx bx-cog'></i>
    </a>
    <a href="../logout.php">
      <i class='bx bx-log-out'></i>
    </a>
  </div>
</header>