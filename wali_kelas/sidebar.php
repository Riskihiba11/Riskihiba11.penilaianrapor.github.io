<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="sidebar-brand-text mx-3">wali kelas Panel</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Raport</div>
    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportCard" aria-expanded="true" aria-controls="collapseReportCard">
        <i class="fas fa-file-alt"></i>
        <span>Generate Report Card</span>
    </a>
    <div id="collapseReportCard" class="collapse" aria-labelledby="headingReportCard" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Select Class:</h6>
            <a class="collapse-item" href="generate_report_card.php?class=Class 1">Class 1</a>
            <a class="collapse-item" href="generate_report_card.php?class=Class 2">Class 2</a>
            <a class="collapse-item" href="generate_report_card.php?class=Class 3">Class 3</a>
        </div>
    </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link" href="../logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
</ul>
