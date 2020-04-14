
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="logo">
                <?php
                   $school ->schoolLogo($roleNo);
              ?>
            </div>

        </div>

        <!-- Sidebar Menu -->
        <?php
            $school ->schoolDetails($roleNo);
        ?>


    </section>
    <!-- /.sidebar -->
</aside>
