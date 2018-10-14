      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sales">
          <a class="nav-link" href="sales.php">
            <i class="fa fa-fw fa-shopping-cart"></i>
            <span class="nav-link-text">Sales</span>
          </a>
        </li>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Inventory">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseInventory" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-cogs"></i>
            <span class="nav-link-text">Inventory</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseInventory">
            <li>
              <a href="products.php">Products</a>
            </li>
            <li>
              <a href="customers.php">Customers</a>
            </li>
            <li>
              <a href="suppliers.php">Suppliers</a>
            </li>
            <li>
              <a href="invoice.php">Invoice</a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sales Report">
          <a class="nav-link" href="salesreport.php">
            <i class="fa fa-fw fa-bar-chart"></i>
            <span class="nav-link-text">Sales Report</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Settings">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-cogs"></i>
            <span class="nav-link-text">Settings</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="homesetting.php">Shop Details</a>
            </li>
            <li>
              <a href="taxsetting.php">Tax Slab</a>
            </li>
             <li>
              <a href="profile.php?service_code=OTH">User</a>
            </li>
          </ul>
        </li>
        

      </ul>
            <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>